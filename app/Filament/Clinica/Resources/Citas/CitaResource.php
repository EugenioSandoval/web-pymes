<?php

namespace App\Filament\Clinica\Resources\Citas;

use App\Filament\Clinica\Resources\Citas\Pages\CreateCita;
use App\Filament\Clinica\Resources\Citas\Pages\EditCita;
use App\Filament\Clinica\Resources\Citas\Pages\ListCitas;
use App\Filament\Clinica\Resources\Pacientes\PacienteResource;
use App\Models\Cita;
use App\Models\Servicio;
use BackedEnum;
use Closure;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/** Horas agendadas. La vista de calendario está en la página "Agenda". */
class CitaResource extends Resource
{
    protected static ?string $model = Cita::class;

    protected static ?string $modelLabel = 'cita';

    protected static ?string $pluralModelLabel = 'citas';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?int $navigationSort = 1;

    public const COLORES = ['pendiente' => 'warning', 'confirmada' => 'info', 'atendida' => 'success', 'cancelada' => 'gray'];

    public static function getNavigationBadge(): ?string
    {
        $pendientes = Cita::where('estado', 'pendiente')->where('inicio', '>=', now())->count();

        return $pendientes ?: null;
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Citas pendientes de confirmar';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columnSpanFull()->columns(2)->schema([
                Select::make('paciente_id')->label('Paciente')
                    ->relationship('paciente', 'nombre')->searchable()->preload()->required()
                    ->createOptionForm(fn (Schema $schema) => PacienteResource::form($schema)),
                Select::make('servicio_id')->label('Servicio')
                    ->relationship('servicio', 'nombre')->required()->live(),
                Select::make('profesional_id')->label('Profesional')
                    ->relationship('profesional', 'nombre', fn (Builder $query) => $query->where('activo', true))
                    ->required(),
                DateTimePicker::make('inicio')->label('Fecha y hora')
                    ->native(false)->seconds(false)->minutesStep(15)->displayFormat('d/m/Y H:i')->required()
                    ->rules([
                        fn (Get $get, ?Cita $record): Closure => function (string $attribute, $value, Closure $fail) use ($get, $record) {
                            if (! $value || ! $get('profesional_id') || ! $get('servicio_id')) {
                                return;
                            }
                            $inicio = Carbon::parse($value);
                            $fin = $inicio->copy()->addMinutes(Servicio::find($get('servicio_id'))?->duracion_minutos ?? 45);
                            if (Cita::hayChoque((int) $get('profesional_id'), $inicio, $fin, $record?->id)) {
                                $fail('El profesional ya tiene una cita en ese horario.');
                            }
                        },
                    ]),
                Select::make('estado')->options(Cita::ESTADOS)->default('confirmada')->required(),
                Textarea::make('notas')->rows(3)->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('inicio')
            ->columns([
                TextColumn::make('inicio')->label('Fecha')->dateTime('D d/m · H:i')->sortable(),
                TextColumn::make('paciente.nombre')->label('Paciente')->searchable(),
                TextColumn::make('servicio.nombre')->label('Servicio'),
                TextColumn::make('profesional.nombre')->label('Profesional'),
                TextColumn::make('estado')->badge()
                    ->formatStateUsing(fn (string $state) => Cita::ESTADOS[$state] ?? $state)
                    ->color(fn (string $state) => self::COLORES[$state] ?? 'gray'),
                TextColumn::make('origen')->badge()->color(fn ($state) => $state === 'web' ? 'primary' : 'gray')
                    ->formatStateUsing(fn ($state) => $state === 'web' ? 'Web' : 'Panel'),
            ])
            ->filters([
                Filter::make('proximas')->label('Solo próximas')->default()
                    ->query(fn (Builder $query) => $query->where('inicio', '>=', today())),
                SelectFilter::make('estado')->options(Cita::ESTADOS),
                SelectFilter::make('profesional')->relationship('profesional', 'nombre'),
            ])
            ->recordActions([
                Action::make('confirmar')->icon(Heroicon::OutlinedCheck)->color('info')
                    ->visible(fn (Cita $record) => $record->estado === 'pendiente')
                    ->action(fn (Cita $record) => $record->update(['estado' => 'confirmada'])),
                Action::make('atendida')->label('Marcar atendida')->icon(Heroicon::OutlinedCheckBadge)->color('success')
                    ->visible(fn (Cita $record) => $record->estado === 'confirmada')
                    ->action(fn (Cita $record) => $record->update(['estado' => 'atendida'])),
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCitas::route('/'),
            'create' => CreateCita::route('/create'),
            'edit' => EditCita::route('/{record}/edit'),
        ];
    }
}
