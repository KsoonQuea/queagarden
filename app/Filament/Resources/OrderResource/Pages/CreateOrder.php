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
use Illuminate\Log\Logger;

class CreateOrder extends CreateRecord
{
    use HasWizard;

    protected static string $resource = OrderResource::class;

    protected $distributor_name;
    protected $order_details;
    protected $grouped_order_details;
    protected $total_price;

    public function mount() : void
    {
        $this->distributor_name         = "";
        $this->grouped_order_details    = [];
        $this->total_price              = 0;
        $this->order_details            = [];
    }

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
            ])->columns(3),
        ];
    }

    protected function getSummarySchema(): array
    {

        $this->order_details = $this->data['order_details'] ?? [];

        $grouped = collect($this->order_details)->groupBy(function ($item) {
            return $item['product_id'] . '-' . $item['grade'];
        });

        $this->grouped_order_details = $grouped->map(function ($items, $key) {
            return [
                'product_id'    => $items[0]['product_id'],
                'grade'         => $items[0]['grade'],
                'market_price'  => $items[0]['market_price'],
                'basket_qty'    => $items->sum('basket_qty'),
                'quoted_kg'     => $items->sum('quoted_kg'),
                'real_kg'       => $items->sum('real_kg')
            ];
        });

        $this->total_price = collect($this->grouped_order_details)->sum(function ($item) {
            return $item['quoted_kg'] * $item['market_price'];
        });

        $this->distributor_name   = self::convertDistributorIDToName($this->data['distributor_id']??0);

        $this->data['total_payment'] = $this->total_price;

        return [
            View::make('filament.resources.order.create_summary'),

            Hidden::make('total_payment')->default($this->total_price),
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
