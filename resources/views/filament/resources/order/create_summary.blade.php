<div>
    <h2>Order Summary {{ $gg }}</h2>
    {{-- @dd($customData) --}}
    <p>Name: {{ $this->convertDistributorIDToName($this->data['distributor_id']) }}</p>

    @foreach ($this->data['order_details'] as $order_detail)
    <div class="relative flex flex-col my-6 shadow-sm border border-gray-200 rounded-lg w-96">
        <div class="p-4">
            <p>Product: {{ $this->convertProductIDToName($order_detail['product_id']) }}</p>
            <p>Market Price: {{ $order_detail['market_price'] }}</p>
            <p>Basket Quantity: {{ $order_detail['basket_qty'] }}</p>
            <p>Quoted Kilograms: {{ $order_detail['quoted_kg'] }}</p>
            <p>Real Kilograms: {{ $order_detail['real_kg'] }}</p>
            <p>Grade: {{ $order_detail['grade'] }}</p>
        </div>
    </div>
    @endforeach
</div>
