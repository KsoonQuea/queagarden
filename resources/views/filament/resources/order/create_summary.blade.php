<div>
    <h2 class="text-2xl font-bold border-b border-gray-200 pb-2">Order Summary</h2>
    <h4 class="text-lg font-medium">Distributor: {{ $this->distributor_name }}</h4>

    <table class="w-full border-4 border-red-400">
        <thead>
            <tr>
                <td>Item</td>
                <td>Market Price</td>
                <td>Basket No.</td>
                <td>KG</td>
                <td>Total Price</td>
            </tr>
        </thead>
        <tbody>
        @forelse ($this->order_details ?? [] as $order_detail)
            <tr>
                <td class="text-sm text-gray-500">{{ $this->convertProductIDToName($order_detail['product_id']) }} ({{ $order_detail['grade'] }})</td>
                <td class="text-sm text-gray-500">{{ $order_detail['market_price'] }} </td>
                <td class="text-sm text-gray-500">{{ $order_detail['basket_qty'] }}    </td>
                <td class="text-sm text-gray-500">{{ $order_detail['quoted_kg'] }}    </td>
                <td class="text-sm text-gray-500">{{ $order_detail['quoted_kg'] * $order_detail['market_price'] }}</td>
            </tr>

            @empty
            <tr>
                <td class="text-sm text-gray-500" colspan="5">No data</td>
            </tr>


        @endforelse
        </tbody>
    </table>

    <hr>

    <div class="text-right">
        <h4 class="text-lg font-medium">Total Price: {{ number_format($this->total_price) }} </h4>
    </div>

</div>
