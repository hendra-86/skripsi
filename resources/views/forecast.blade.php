@extends('adminlte::page')

@section('title', 'Forecasting')

@section('content_header')
    <h1>Inventory Stock Forecast</h1>
@stop

@section('content')
    

    {{-- @foreach ($inventories as $inventory)
        <h2>Forecast for {{ $inventory->nama_barang }}</h2>
        <h3>Data Asli:</h3>
        <ul>
            @foreach (explode(',', $inventory->jumlah) as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>

        <h3>Hasil Peramalan:</h3>
        <ul>
            @foreach ($forecasts[$inventory->nama_barang] as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    @endforeach --}}


    {{-- @foreach ($forecastData as $item)
        <h3>Barang: {{ $item['nama_barang'] }}</h3>
        <h4>Data Penjualan:</h4>
        <ul>
            @foreach ($item['quantityPerMonth'] as $quantity)
                <li>{{ $quantity }}</li>
            @endforeach
        </ul>

        <h4>Hasil Peramalan:</h4>
        <ul>
            @foreach ($item['forecast'] as $month => $value)
                <li>Bulan {{ $month }}: {{ $value }}</li>
            @endforeach
        </ul>
    @endforeach --}}

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Product</th>
                <th>Month</th>
                <th>Total Quantity</th>
                <th>Forecast</th>
                {{-- <th>Next Month Forecast</th> --}}
                {{-- <th>RMSE</th> --}}
                <th>MAPE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($forecastData as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['month'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ implode(', ', $item['forecast']) }}</td>
                    {{-- <td>{{ $item['nextMonthForecast'] }}</td> --}}
                    {{-- <td>{{ $item['rmse'] }}</td> --}}
                    <td>{{ $item['mape'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop





