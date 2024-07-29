<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers\OrdersRelationManager;
use Filament\Resources\Pages\Page;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rules\Unique;

use App\Models\Transaction;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables\Columns\ImageColumn;

use Filament\Forms\Components\Toggle;
use Filament\Tables\Action\ActiveGroup;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\CheckboxColumn;

use Filament\Forms\Components\FileUpload\recorderable ;
use Filament\Tables\Filters\SelectFilter;
use Schema;
use Filament\Forms\Components\Repeater;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\Resources\OrderResource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\color;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;
use Filament\Forms\Get;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Number;
use Filament\Forms\Components\Placeholder;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required(),

                TextInput::make('phone')
                ->required()
                ->numeric(),

                TextInput::make('phone2')
                ->numeric(),

                TextInput::make('address')
                ->maxLength(255),

                // TextInput::make('sold')
                // ->numeric(),

                TextInput::make('remark')
                ->maxLength(255),

                Select::make('car_id')
                ->relationship('cars', 'model')
                ->searchable()
                ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->badge()
                ->color('success')
                ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                ->searchable()
                ->badge()
                ->color('info')
                ->sortable(),

                Tables\Columns\TextColumn::make('phone2')
                ->searchable()
                ->badge()
                ->sortable(),

                Tables\Columns\TextColumn::make('address')
                ->searchable()
                ->badge()
                ->sortable(),

                Tables\Columns\TextColumn::make('remark')
                ->searchable()
                ->badge()
                ->sortable(),

                Tables\Columns\TextColumn::make('sold')
                ->searchable()
                ->badge()
                ->sortable(),


            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
