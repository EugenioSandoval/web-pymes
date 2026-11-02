<?php

namespace App\Filament\Clinica\Resources\Profesionales;

use App\Filament\Clinica\Resources\Profesionales\Pages\CreateProfesional;
use App\Filament\Clinica\Resources\Profesionales\Pages\EditProfesional;
use App\Filament\Clinica\Resources\Profesionales\Pages\ListProfesionales;
use App\Models\Profesional;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/** Trabajadores del centro. */
class ProfesionalResource extends Resource
{
    protected static ?string $model = Profesional::class;

    protected static ?string $slug = 'profesionales';

    protected static ?string $modelLabel = 'profesional';

    protected static ?string $pluralModelLabel = 'profesionales';

    protected static ?string $recordTitleAttribute = 'nombre';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|\UnitEnum|null $navigationGroup = 'Configuración';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Datos del profesional')->columnSpanFull()->columns(2)->schema([
                TextInput::make('nombre')->required(),
                TextInput::make('especialidad')->required(),
                TextInput::make('email')->label('Correo')->email(),
                TextInput::make('telefono')->label('Teléfono')->tel(),
                ColorPicker::make('color')->label('Color en la agenda')->required(),
                Toggle::make('activo')->default(true)->inline(false),
                Select::make('servicios')->label('Servicios que atiende')
                    ->relationship('servicios', 'nombre')->multiple()->preload()->columnSpanFull(),
                Textarea::make('bio')->label('Presentación (se muestra en la web)')->rows(3)->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ColorColumn::make('color')->label(''),
                TextColumn::make('nombre')->searchable(),
                TextColumn::make('especialidad'),
                TextColumn::make('telefono')->label('Teléfono'),
                TextColumn::make('servicios.nombre')->label('Servicios')->badge()->limitList(2),
                IconColumn::make('activo')->boolean(),
            ])
            ->recordActions([EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProfesionales::route('/'),
            'create' => CreateProfesional::route('/create'),
            'edit' => EditProfesional::route('/{record}/edit'),
        ];
    }
}
