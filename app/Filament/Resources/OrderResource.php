<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\OrderDetails;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {

        $OrderDetails = new OrderDetails();

        return $form
            ->schema([
                Section::make('')
                ->schema([
                    Select::make('distributor_id')
                    ->relationship('distributor', titleAttribute:'company_name')
                    ->required(),

                    Repeater::make('order_details')
                    ->label("Carts")
                    ->relationship('order_details')
                    ->schema([
                        Select::make('product_id')
                        ->label('Product')
                        ->relationship('product', titleAttribute:'name')
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('grade', null))
                        ->native(false)
                        ->required(),
                        TextInput::make('market_price')
                        ->label('Market Price')
                        ->required(),
                        TextInput::make('basket_qty')
                        ->label('Basket Quantity')
                        ->required(),
                        TextInput::make('quoted_kg')
                        ->label('Quoted Kilograms')
                        ->required(),
                        TextInput::make('real_kg')
                        ->label('Real Kilograms')
                        ->required(),
                        Select::make('grade')
                        ->label('Grade')
                        ->options(fn (callable $get) => $OrderDetails->getGradeOptions($get('product_id')))
                        ->disabled(fn (callable $get) => $get('product_id') === null)
                        ->required()
                    ])->columns(3)
                ])

                    ]);
            // ->actions([
            //     Action::make('create')
            //         ->label('Create')
            //         ->modalHeading('Create New Record')
            //         ->modalButton('Save')
            //         ->modalWidth('md') // Customize modal width
            //         ->form([
            //             // Define modal form components here
            //             Forms\Components\TextInput::make('name')
            //                 ->required(),
            //             Forms\Components\TextInput::make('description')
            //                 ->required(),
            //         ])
            //         ->action(function (array $data) {
            //             // Logic for creating the record
            //             Order::create($data);
            //         })
            //         ->button(), // Custom create button inside the modal
            // ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            // 'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
