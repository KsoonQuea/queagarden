<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Distributor;
use App\Models\OrderDetails;
use App\Models\Product;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;
use Filament\Tables\Actions\CreateAction;

class CreateOrder extends CreateRecord
{

    use HasWizard;


    protected static string $resource = OrderResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('Order Information')
            ->schema(self::getOrderInfoSchema()),
            Step::make('Summary')
            ->schema(self::getSummarySchema())
        ];
    }

    protected function getOrderInfoSchema(): array
    {
        $OrderDetails = new OrderDetails();
        return [
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
        ];
    }

    protected function getSummarySchema(): array
    {
        return [
            View::make('filament.resources.order.create_summary')
                ->viewData([
                    'gg' => $this->data['distributor_id'] ?? 'None',
                ])
        ];
    }

    public function convertDistributorIDToName($distributor_id)
    {
        return Distributor::find($distributor_id)?->company_name ?? 'None';
    }

    public function convertProductIDToName($product_id)
    {
        return Product::find($product_id)?->name ?? 'None';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        logger($data);
        return $data;
    }

    protected function beforeCreate()
    {
        logger("Before Create");
    }

    protected function afterCreate(): void
    {
        logger("After Create");
    }
}
