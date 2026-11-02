<?php

namespace App\Filament\Resources\Leads;

use App\Filament\Resources\Leads\Pages\EditLead;
use App\Filament\Resources\Leads\Pages\ListLeads;
use App\Models\Lead;
use BackedEnum;
use Filament\Actions\Action;
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
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

/** Personas que dejaron sus datos en la página de venta. */
class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $modelLabel = 'contacto';

    protected static ?string $pluralModelLabel = 'contactos';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    public static function getNavigationBadge(): ?string
    {
        return Lead::where('contactado', false)->count() ?: null;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columnSpanFull()->columns(2)->schema([
                TextInput::make('nombre')->required(),
                TextInput::make('negocio'),
                TextInput::make('telefono')->label('Teléfono')->required(),
                TextInput::make('email')->label('Correo')->email(),
                TextInput::make('rubro'),
                TextInput::make('paquete')->label('Plan de interés'),
                Textarea::make('mensaje')->rows(4)->columnSpanFull(),
                Toggle::make('contactado'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')->label('Recibido')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('nombre')->searchable(),
                TextColumn::make('negocio')->searchable(),
                TextColumn::make('rubro')->badge(),
                TextColumn::make('paquete')->label('Plan'),
                TextColumn::make('telefono')->label('Teléfono'),
                IconColumn::make('contactado')->boolean(),
            ])
            ->filters([TernaryFilter::make('contactado')])
            ->recordActions([
                Action::make('whatsapp')->label('WhatsApp')->icon(Heroicon::OutlinedChatBubbleLeftRight)->color('success')
                    ->url(fn (Lead $record) => 'https://wa.me/'.preg_replace('/\D/', '', $record->telefono))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLeads::route('/'),
            'edit' => EditLead::route('/{record}/edit'),
        ];
    }
}
