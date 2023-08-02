<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Jual;

class InventoryController extends Controller
{
    public function forecast()
    {
        $sales = Jual::select('name', \DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), \DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('name', 'month')
            ->orderBy('name')
            ->orderBy('month')
            ->get();

        if ($sales->isEmpty()) {
            return "Data penjualan barang tidak ditemukan";
        }

        $forecastData = [];

        foreach ($sales as $sale) {
            $quantity = $sale->total_quantity;

            // Ambil data penjualan perbulan dimulai dari bulan ketiga
            $monthlySales = Jual::select(\DB::raw('SUM(quantity) as total_quantity'))
                ->where('name', $sale->name)
                ->where('date', '>=', date('Y-m', strtotime($sale->month . '-01 months')) . '-01')
                ->where('date', '<=', $sale->month . '-01')
                ->groupBy(\DB::raw('DATE_FORMAT(date, "%Y-%m")'))
                ->pluck('total_quantity')
                ->toArray();

            $forecast = $this->singleExponentialSmoothing($monthlySales, 0.7);
            $nextMonthForecast = $this->forecastNextMonth($forecast);
            $rmse = $this->calculateRMSE($monthlySales, $forecast);
            $mape = $this->calculateMAPE($monthlySales, $forecast);

            $forecastData[] = [
                'name' => $sale->name,
                'month' => $sale->month,
                'quantity' => $quantity,
                'forecast' => $forecast,
                'nextMonthForecast' => $nextMonthForecast,
                'rmse' => $rmse,
                'mape' => $mape,
            ];
        }

        return view('forecast', compact('forecastData'));
    }

    private function singleExponentialSmoothing($data, $alpha)
    {
        $n = count($data);
        $smoothedData = [];

        if ($n == 0) {
            return $smoothedData;
        }

        $smoothedData[0] = $data[0];

        for ($i = 1; $i < $n; $i++) {
            $smoothedData[$i] = $alpha * $data[$i] + (1 - $alpha) * ($smoothedData[$i - 1] ?? 0);
        }

        return $smoothedData;
    }

    private function forecastNextMonth($data)
    {
        $n = count($data);
        $lastIndex = $n - 1;

        if ($n <= 1) {
            return end($data) ?? 0;
        }

        $lastValue = $data[$lastIndex];
        $secondLastValue = $data[$lastIndex - 1];
        $trend = $lastValue - $secondLastValue;
        $forecast = $lastValue + $trend;

        return $forecast;
    }

    private function calculateRMSE($actual, $forecast)
    {
        $n = count($actual);
        $sumSquaredError = 0;

        if ($n == 0) {
            return 0;
        }

        for ($i = 0; $i < $n; $i++) {
            $error = $actual[$i] - $forecast[$i];
            $sumSquaredError += pow($error, 2);
        }

        $rmse = sqrt($sumSquaredError / $n);
        return $rmse;
    }

    private function calculateMAPE($actual, $forecast)
    {
        $n = count($actual);
        $sumPercentageError = 0;
        $countNonZeroActual = 0;

        for ($i = 0; $i < $n; $i++) {
            if ($actual[$i] != 0) {
                $error = abs($actual[$i] - $forecast[$i]);
                $percentageError = $error / $actual[$i] * 100;
                $sumPercentageError += $percentageError;
                $countNonZeroActual++;
            }
        }

        if ($countNonZeroActual == 0) {
            return 0;
        }

        $mape = $sumPercentageError / $countNonZeroActual;
        return $mape;
    }
}
