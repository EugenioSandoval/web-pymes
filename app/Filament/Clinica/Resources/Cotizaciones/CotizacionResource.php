<?php

namespace App\Filament\Clinica\Resources\Cotizaciones;

use App\Filament\Clinica\Resources\Cotizaciones\Pages\CreateCotizacion;
use App\Filament\Clinica\Resources\Cotizaciones\Pages\EditCotizacion;
use App\Filament\Clinica\Resources\Cotizaciones\Pages\ListCotizaciones;
use App\Filament\Clinica\Resources\Pacientes\PacienteResource;
use App\Models\Cotizacion;
use App\Models\Servicio;
use App\Support\Formato;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CotizacionResource extends Resource
{
    protected static ?string $model = Cotizacion::class;

    protected static ?string $slug = 'cotizaciones';

    protected static ?string $modelLabel = 'cotización';

    protected static ?string $pluralModelLabel = 'cotizaciones';

    protected static ?string $recordTitleAttribute = 'numero';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?int $navigationSort = 3;

    public const COLORES = ['borrador' => 'gray', 'enviada' => 'info', 'aceptada' => 'success', 'rechazada' => 'danger'];

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columnSpanFull()->columns(4)->schema([
                Select::make('paciente_id')->label('Paciente')
                    ->relationship('paciente', 'nombre')->searchable()->preload()->required()->columnSpan(2)
                    ->createOptionForm(fn (Schema $schema) => PacienteResource::form($schema)),
                DatePicker::make('fecha')->default(today())->native(false)->displayFormat('d/m/Y')->required(),
                DatePicker::make('valida_hasta')->label('Válida hasta')->default(today()->addDays(30))->native(false)->displayFormat('d/m/Y'),
                Select::make('estado')->options(Cotizacion::ESTADOS)->default('borrador')->required(),
                TextInput::make('descuento_porcentaje')->label('Descuento')->numeric()->minValue(0)->maxValue(100)->suffix('%')->default(0),
            ]),
            Section::make('Detalle')->columnSpanFull()->schema([
                Repeater::make('items')->label('')->relationship()
                    ->columns(6)
                    ->defaultItems(1)
                    ->addActionLabel('Agregar línea')
                    ->schema([
                        Select::make('servicio_id')->label('Servicio')
                            ->options(fn () => Servicio::orderBy('nombre')->pluck('nombre', 'id'))
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if ($servicio = Servicio::find($state)) {
                                    $set('descripcion', $servicio->nombre);
                                    $set('precio_unitario', $servicio->precio);
                                }
                            })
                            ->columnSpan(2),
                        TextInput::make('descripcion')->label('Descripción')->required()->columnSpan(2),
                        TextInput::make('cantidad')->numeric()->minValue(1)->default(1)->required(),
                        TextInput::make('precio_unitario')->label('Precio unitario')->numeric()->prefix('$')->required(),
                    ]),
                Textarea::make('observaciones')->rows(2),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('fecha', 'desc')
            ->modifyQueryUsing(fn ($query) => $query->with('items'))
            ->columns([
                TextColumn::make('numero')->label('N°')->searchable(),
                TextColumn::make('paciente.nombre')->label('Paciente')->searchable(),
                TextColumn::make('fecha')->date('d/m/Y')->sortable(),
                TextColumn::make('total')->state(fn (Cotizacion $record) => Formato::clp($record->total())),
                TextColumn::make('estado')->badge()
                    ->formatStateUsing(fn (string $state) => Cotizacion::ESTADOS[$state] ?? $state)
                    ->color(fn (string $state) => self::COLORES[$state] ?? 'gray'),
            ])
            ->filters([
                SelectFilter::make('estado')->options(Cotizacion::ESTADOS),
            ])
            ->recordActions([
                Action::make('pdf')->label('PDF')->icon(Heroicon::OutlinedPrinter)->color('gray')
                    ->url(fn (Cotizacion $record) => route('clinica.cotizacion.imprimir', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCotizaciones::route('/'),
            'create' => CreateCotizacion::route('/create'),
            'edit' => EditCotizacion::route('/{record}/edit'),
        ];
    }
}
