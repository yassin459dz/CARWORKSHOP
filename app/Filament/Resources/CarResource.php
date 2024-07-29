<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Filament\Resources\CarResource\RelationManagers;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Client;
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
use Filament\Support\Facades\FilamentColor;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('client_id')
                ->required()
                ->searchable()
                ->preload()
                ->relationship('client' , 'name'),

                TextInput::make('brand')
                ->required(),

                TextInput::make('model')
                ->required(),

                TextInput::make('color')
                ->required(),

                TextInput::make('mat')
                ->required(),

                TextInput::make('km')
                ->numeric(),

                TextInput::make('remark')
                ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('client.name')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('brand')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('')
                    ->toggleable(isToggledHiddenByDefault: true),


                TextColumn::make('model')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('color')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('mat')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->toggleable(isToggledHiddenByDefault: true),


                TextColumn::make('km')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($state) => "{$state} km"),

                TextColumn::make('remark')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('danger'),
            ])
            ->filters([
                // Add your filters here if needed
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
