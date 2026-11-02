<?php

namespace App\Filament\Clinica\Resources\Pacientes;

use App\Filament\Clinica\Resources\Pacientes\Pages\CreatePaciente;
use App\Filament\Clinica\Resources\Pacientes\Pages\EditPaciente;
use App\Filament\Clinica\Resources\Pacientes\Pages\ListPacientes;
use App\Models\Paciente;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

/** Clientes del centro (en el demo se llaman pacientes). */
class PacienteResource extends Resource
{
    protected static ?string $model = Paciente::class;

    protected static ?string $modelLabel = 'paciente';

    protected static ?string $pluralModelLabel = 'pacientes';

    protected static ?string $recordTitleAttribute = 'nombre';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?int $navigationSort = 2;

    public const PREVISIONES = ['Fonasa' => 'Fonasa', 'Isapre' => 'Isapre', 'Particular' => 'Particular'];

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Datos del paciente')->columnSpanFull()->columns(2)->schema([
                TextInput::make('nombre')->required()->maxLength(120),
                TextInput::make('rut')->label('RUT')->placeholder('12.345.678-9')->maxLength(12)->unique(ignoreRecord: true),
                TextInput::make('telefono')->label('Teléfono')->tel()->required(),
                TextInput::make('email')->label('Correo')->email(),
                DatePicker::make('fecha_nacimiento')->label('Fecha de nacimiento')->native(false)->displayFormat('d/m/Y'),
                Select::make('prevision')->label('Previsión')->options(self::PREVISIONES),
                Textarea::make('notas')->rows(3)->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('nombre')
            ->columns([
                TextColumn::make('nombre')->searchable()->sortable(),
                TextColumn::make('rut')->label('RUT')->searchable(),
                TextColumn::make('telefono')->label('Teléfono')->searchable(),
                TextColumn::make('email')->label('Correo')->toggleable(),
                TextColumn::make('prevision')->label('Previsión')->badge(),
                TextColumn::make('citas_count')->label('Citas')->counts('citas')->sortable(),
            ])
            ->filters([
                SelectFilter::make('prevision')->label('Previsión')->options(self::PREVISIONES),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPacientes::route('/'),
            'create' => CreatePaciente::route('/create'),
            'edit' => EditPaciente::route('/{record}/edit'),
        ];
    }
}
