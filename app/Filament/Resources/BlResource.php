<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlResource\Pages;
use App\Filament\Resources\BlResource\RelationManagers;
use App\Models\Bl;
use App\Models\Client;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Fieldset;

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
use Filament\Forms\Components\Wizard;
use Illuminate\Support\HtmlString;

use Filament\Tables\Filters\SelectFilter;
use Schema;
use Filament\Forms\Components\Repeater;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\Resources\OrderResource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\color;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;
use App\Models\Matricule;
use Filament\Forms\Get;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Number;
use Filament\Forms\Components\Placeholder;
class BlResource extends Resource
{
    protected static ?string $model = Bl::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Wizard::make([
                Wizard\Step::make('Order')
                    ->description('Review your basket')
                    ->schema([
                        Select::make('client_id')
                        ->label('Client')
                        ->relationship('client', 'name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            TextInput::make('name')->required(),
                            TextInput::make('phone')->required(),
                        ])
                        ->editOptionForm([
                            TextInput::make('name')->required(),
                            TextInput::make('phone')->required(),
                        ])
                        ->reactive()
                        ->afterStateUpdated(function ($state, $set) {
                            $client = Client::find($state);
                            if ($client) {
                                $firstCar = $client->cars()->first();
                                if ($firstCar) {
                                    $set('car_id', $firstCar->id);
                                } else {
                                    $set('car_id', null);
                                }

                                // Update the car options based on the selected client
                                $carsRelated = $client->cars()->pluck('model', 'id')->toArray(); // Adjust 'model' to the correct column name
                                $otherCars = Car::whereNotIn('id', array_keys($carsRelated))->pluck('model', 'id')->toArray(); // Adjust 'model' to the correct column name
                                $carOptions = [
                                    'Related Cars' => $carsRelated,
                                    'Other Cars' => $otherCars,
                                ];
                            } else {
                                $carOptions = [
                                    'Related Cars' => [],
                                    'Other Cars' => Car::pluck('model', 'id')->toArray(), // Adjust 'model' to the correct column name
                                ];
                            }
                            $set('car_options', $carOptions);
                        }),

                    Select::make('car_id')
                        ->label('Car')
                        ->searchable()
                        ->options(function ($get) {
                            return $get('car_options') ?: [];
                        })
                        ->reactive(),


                        Group::make()
                            ->relationship('matricule')
                            ->schema([
                                TextInput::make('mat')
                                    ->required(),
                                TextInput::make('km')
                                    ->required()
                                    ->dehydrated(),

                                TextInput::make('client_id')
                                    ->required(),
                                TextInput::make('car_id')
                                    ->required(),
                                    ])
                            ]),


                        // SELECT THE Matricule //////////////
                            // Select::make('matricule_id')
                            // ->label('matricule')
                            // ->relationship('matricule', 'mat')
                            // ->searchable()
                            // ->preload()
                            // // ->getSearchResultsUsing(fn (string $search): array => Client::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                            // // ->getOptionLabelUsing(fn ($value): ?string => Client::find($value)?->name)
                            // ->createOptionForm([
                            //     TextInput::make('mat')
                            //         ->required(),
                            //     TextInput::make('km')
                            //         ->required(),

                            // ]),
                    Wizard\Step::make('Delivery')
                        ->schema([

                            TextInput::make('bl_number')
                            ->required(),

                            TextInput::make('product')
                            ->required(),

                            TextInput::make('price')
                            ->numeric(),
                        ]),
                    Wizard\Step::make('Billing')
                        ->schema([
                            TextInput::make('qte')
                            ->numeric(),

                            TextInput::make('total')
                            ->numeric(),

                            TextInput::make('remark')
                            ->maxLength(255),
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bl_number')
                ->searchable()
                ->badge()
                ->color('success')
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBls::route('/'),
            'create' => Pages\CreateBl::route('/create'),
            //'view' => Pages\ViewBl::route('/{record}'),
            'edit' => Pages\EditBl::route('/{record}/edit'),
        ];
    }
}


