<?php

namespace App\Filament\Clinica\Resources\Servicios;

use App\Filament\Clinica\Resources\Servicios\Pages\CreateServicio;
use App\Filament\Clinica\Resources\Servicios\Pages\EditServicio;
use App\Filament\Clinica\Resources\Servicios\Pages\ListServicios;
use App\Models\Servicio;
use App\Support\Formato;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicioResource extends Resource
{
    protected static ?string $model = Servicio::class;

    protected static ?string $modelLabel = 'servicio';

    protected static ?string $pluralModelLabel = 'servicios';

    protected static ?string $recordTitleAttribute = 'nombre';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|\UnitEnum|null $navigationGroup = 'Configuración';

    protected static ?int $navigationSort = 11;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columnSpanFull()->columns(3)->schema([
                TextInput::make('nombre')->required()->columnSpan(3),
                TextInput::make('duracion_minutos')->label('Duración (minutos)')->numeric()->minValue(10)->step(5)->required(),
                TextInput::make('precio')->label('Precio (CLP)')->numeric()->prefix('$')->required(),
                Toggle::make('publico')->label('Reservable en la web')->default(true)->inline(false),
                Textarea::make('descripcion')->label('Descripción')->rows(3)->columnSpan(3),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')->searchable(),
                TextColumn::make('duracion_minutos')->label('Duración')->suffix(' min'),
                TextColumn::make('precio')->formatStateUsing(fn ($state) => Formato::clp($state))->sortable(),
                IconColumn::make('publico')->label('En la web')->boolean(),
            ])
            ->recordActions([EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServicios::route('/'),
            'create' => CreateServicio::route('/create'),
            'edit' => EditServicio::route('/{record}/edit'),
        ];
    }
}
