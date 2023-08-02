<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class ForecastController extends Controller
{
    public function forecast()
    {
        $forecastData = [];

        // Ambil data penjualan perhari dan ditotal berdasarkan nama barang
        $dailySales = Sale::select('name', 'date', \DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('name', 'date')
            ->orderBy('name', 'asc')
            ->orderBy('date', 'asc')
            ->get();

        // Loop melalui setiap data penjualan perhari
        foreach ($dailySales as $sale) {
            $name = $sale->name;
            $date = $sale->date;
            $totalQuantity = $sale->total_quantity;

            // Ambil data penjualan perbulan untuk forecasting
            $monthlySales = Sale::select(\DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), \DB::raw('SUM(quantity) as total_quantity'))
                ->where('name', $name)
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get()
                ->pluck('total_quantity', 'month')
                ->toArray();

            // Lakukan peramalan menggunakan single exponential smoothing untuk perbulan
            $forecastMonthly = $this->singleExponentialSmoothing($monthlySales, 0.3);

            // Ambil data penjualan perhari untuk forecasting
            $dailySalesData = Sale::select('date', 'quantity')
                ->where('name', $name)
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get()
                ->pluck('quantity', 'date')
                ->toArray();

            // Lakukan peramalan menggunakan single exponential smoothing untuk perhari
            $forecastDaily = $this->singleExponentialSmoothing($dailySalesData, 0.3);

            // Tambahkan hasil peramalan ke dalam array forecastData
            $forecastData[] = [
                'name' => $name,
                'date' => $date,
                'totalQuantity' => $totalQuantity,
                'forecastMonthly' => $forecastMonthly,
                'forecastDaily' => $forecastDaily,
            ];
        }

        // Tampilkan hasil peramalan dalam view forecast.blade.php
        return view('forecast', compact('forecastData'));
    }

    private function singleExponentialSmoothing($data, $alpha)
    {
        $result = [];
        $smoothedValue = null;

        foreach ($data as $key => $value) {
            if ($smoothedValue === null) {
                $smoothedValue = $value;
            } else {
                $smoothedValue = $alpha * $value + (1 - $alpha) * $smoothedValue;
            }

            $result[$key] = $smoothedValue;
        }

        return $result;
    }
}
