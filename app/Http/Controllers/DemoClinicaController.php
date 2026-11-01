<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cotizacion;
use App\Models\Paciente;
use App\Models\Profesional;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/** Web pública del demo "Centro Kine Ñuble" y reserva de horas en línea. */
class DemoClinicaController extends Controller
{
    public function inicio()
    {
        return view('demo.inicio', [
            'servicios' => Servicio::where('publico', true)->orderBy('nombre')->get(),
            'profesionales' => Profesional::where('activo', true)->with('servicios')->get(),
        ]);
    }

    public function especialidad(string $slug)
    {
        $especialidad = config("demo.especialidades.$slug") ?? abort(404);
        $servicios = Servicio::where('publico', true)->whereIn('nombre', $especialidad['servicios'])->orderBy('precio')->get();

        return view('demo.especialidad', [
            'especialidad' => $especialidad,
            'servicios' => $servicios,
            'profesionales' => Profesional::where('activo', true)
                ->whereHas('servicios', fn ($q) => $q->whereIn('servicios.id', $servicios->pluck('id')))
                ->get(),
        ]);
    }

    public function profesional(Profesional $profesional)
    {
        abort_unless($profesional->activo, 404);
        $profesional->load(['servicios' => fn ($q) => $q->where('publico', true)]);
        $servicio = $profesional->servicios->first();

        // Las 5 próximas horas libres, para mostrar disponibilidad real.
        $proximas = $servicio
            ? $this->proximosDias()->flatMap(fn (Carbon $dia) => $this->horasLibres($profesional, $servicio, $dia))->take(5)
            : collect();

        return view('demo.profesional', compact('profesional', 'servicio', 'proximas'));
    }

    public function presupuesto()
    {
        return view('demo.presupuesto', ['servicios' => Servicio::where('publico', true)->orderBy('nombre')->get()]);
    }

    /** Crea un presupuesto en borrador que recepción ve en el panel. */
    public function guardarPresupuesto(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'telefono' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:120'],
            'prevision' => ['nullable', 'in:Fonasa,Isapre,Particular'],
            'comentarios' => ['nullable', 'string', 'max:500'],
            'servicios' => ['required', 'array'],
            'servicios.*.activo' => ['nullable', 'boolean'],
            'servicios.*.cantidad' => ['nullable', 'integer', 'min:1', 'max:30'],
        ], ['servicios.required' => 'Marca al menos un servicio.'], ['telefono' => 'teléfono', 'email' => 'correo']);

        $elegidos = collect($datos['servicios'])->filter(fn ($s) => ! empty($s['activo']));
        $servicios = Servicio::where('publico', true)->whereIn('id', $elegidos->keys())->get();
        if ($servicios->isEmpty()) {
            return back()->withInput()->withErrors(['servicios' => 'Marca al menos un servicio.']);
        }

        $paciente = Paciente::where('telefono', $datos['telefono'])->first()
            ?? Paciente::create(collect($datos)->only(['nombre', 'telefono', 'email', 'prevision'])->filter()->all());

        $sesiones = $servicios->sum(fn ($s) => (int) ($elegidos[$s->id]['cantidad'] ?? 1));
        $cotizacion = Cotizacion::create([
            'paciente_id' => $paciente->id,
            'fecha' => today(),
            'valida_hasta' => today()->addDays(30),
            'estado' => 'borrador',
            'descuento_porcentaje' => $sesiones >= 10 ? 10 : 0,
            'observaciones' => trim('Solicitada desde la web. '.($datos['comentarios'] ?? '')),
        ]);
        foreach ($servicios as $s) {
            $cotizacion->items()->create([
                'servicio_id' => $s->id,
                'descripcion' => $s->nombre,
                'cantidad' => (int) ($elegidos[$s->id]['cantidad'] ?? 1),
                'precio_unitario' => $s->precio,
            ]);
        }

        return redirect()->route('demo.presupuesto')->with('cotizacion', $cotizacion->numero);
    }

    public function reservar(Request $request)
    {
        $servicios = Servicio::where('publico', true)->orderBy('nombre')->get();
        $servicio = $servicios->firstWhere('id', (int) $request->query('servicio'));

        $profesionales = $servicio
            ? $servicio->profesionales()->where('activo', true)->get()
            : collect();
        $profesional = $profesionales->firstWhere('id', (int) $request->query('profesional'));

        $dias = $this->proximosDias();
        $fecha = $dias->first(fn (Carbon $d) => $d->toDateString() === $request->query('fecha'));

        $horas = ($servicio && $profesional && $fecha)
            ? $this->horasLibres($profesional, $servicio, $fecha)
            : collect();

        return view('demo.reservar', compact('servicios', 'servicio', 'profesionales', 'profesional', 'dias', 'fecha', 'horas'));
    }

    public function guardarReserva(Request $request)
    {
        $datos = $request->validate([
            'servicio_id' => ['required', 'exists:servicios,id'],
            'profesional_id' => ['required', 'exists:profesionales,id'],
            'inicio' => ['required', 'date', 'after:now'],
            'nombre' => ['required', 'string', 'max:120'],
            'telefono' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:120'],
            'rut' => ['nullable', 'string', 'max:12'],
            'notas' => ['nullable', 'string', 'max:500'],
        ], [], ['telefono' => 'teléfono', 'email' => 'correo', 'inicio' => 'hora']);

        $servicio = Servicio::findOrFail($datos['servicio_id']);
        $profesional = Profesional::findOrFail($datos['profesional_id']);
        $inicio = Carbon::parse($datos['inicio']);

        // Revisa de nuevo que la hora siga libre (otra persona pudo tomarla).
        if (! $this->horasLibres($profesional, $servicio, $inicio->copy()->startOfDay())->contains(fn ($h) => $h->eq($inicio))) {
            return back()->withInput()->withErrors(['inicio' => 'Esa hora ya fue tomada. Elige otra, por favor.']);
        }

        $paciente = Paciente::query()
            ->when($datos['rut'] ?? null, fn ($q, $rut) => $q->where('rut', $rut), fn ($q) => $q->where('telefono', $datos['telefono']))
            ->first()
            ?? Paciente::create(collect($datos)->only(['nombre', 'telefono', 'email', 'rut'])->filter()->all());

        $cita = Cita::create([
            'paciente_id' => $paciente->id,
            'profesional_id' => $profesional->id,
            'servicio_id' => $servicio->id,
            'inicio' => $inicio,
            'estado' => 'pendiente',
            'origen' => 'web',
            'notas' => $datos['notas'] ?? null,
        ]);

        return redirect()->route('demo.reserva-lista', $cita);
    }

    public function reservaLista(Cita $cita)
    {
        abort_unless($cita->origen === 'web' && $cita->created_at->gt(now()->subHour()), 404);

        return view('demo.reserva-lista', ['cita' => $cita->load('servicio', 'profesional', 'paciente')]);
    }

    /** Versión imprimible de una cotización (el navegador permite guardarla como PDF). */
    public function imprimirCotizacion(Cotizacion $cotizacion)
    {
        return view('demo.cotizacion', ['cotizacion' => $cotizacion->load('items', 'paciente')]);
    }

    /** Los próximos 10 días hábiles (lunes a viernes). */
    private function proximosDias(): Collection
    {
        $dias = collect();
        for ($d = today(); $dias->count() < 10; $d = $d->copy()->addDay()) {
            if (! $d->isWeekend()) {
                $dias->push($d);
            }
        }

        return $dias;
    }

    /** Horas de inicio disponibles cada 30 minutos entre 09:00 y 18:00, sin la hora de almuerzo. */
    private function horasLibres(Profesional $profesional, Servicio $servicio, Carbon $fecha): Collection
    {
        $ocupadas = Cita::activas()
            ->where('profesional_id', $profesional->id)
            ->whereDate('inicio', $fecha)
            ->get(['inicio', 'fin']);

        $horas = collect();
        for ($h = $fecha->copy()->setTime(9, 0); $h->lt($fecha->copy()->setTime(18, 0)); $h = $h->copy()->addMinutes(30)) {
            $fin = $h->copy()->addMinutes($servicio->duracion_minutos);
            $almuerzo = $h->lt($fecha->copy()->setTime(14, 0)) && $fin->gt($fecha->copy()->setTime(13, 0));
            $choca = $ocupadas->contains(fn ($c) => $c->inicio->lt($fin) && $c->fin->gt($h));
            if ($h->isFuture() && ! $almuerzo && ! $choca && $fin->lte($fecha->copy()->setTime(18, 30))) {
                $horas->push($h);
            }
        }

        return $horas;
    }
}
