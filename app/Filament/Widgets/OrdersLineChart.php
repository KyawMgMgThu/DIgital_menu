<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\LineChartWidget;

class OrdersLineChart extends LineChartWidget
{
    protected static ?string $heading = 'Order Trends';

    protected function getData(): array
    {
        $dailyOrders = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->take(30)
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        $monthlyOrders = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->take(12)
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $yearlyOrders = Order::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->take(5)
            ->get()
            ->pluck('count', 'year')
            ->toArray();

        $weeklyOrders = Order::selectRaw('YEARWEEK(created_at, 1) as week, COUNT(*) as count')
            ->groupBy('week')
            ->orderBy('week', 'asc')
            ->take(7)
            ->get()
            ->pluck('count', 'week')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Daily Orders (Last 30 days)',
                    'data' => array_values($dailyOrders),
                    'borderColor' => '#FF6384',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'fill' => true,
                ],
                [
                    'label' => 'Weekly Orders (Last 7 weeks)', 
                    'data' => array_values($weeklyOrders),
                    'borderColor' => '#4BC0C0',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'fill' => true,
                ],
                [
                    'label' => 'Monthly Orders (Last 12 months)',
                    'data' => array_values($monthlyOrders),
                    'borderColor' => '#36A2EB',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'fill' => true,
                ],
                [
                    'label' => 'Yearly Orders (Last 5 years)',
                    'data' => array_values($yearlyOrders),
                    'borderColor' => '#FFCE56',
                    'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                    'fill' => true,
                ],
            ],
            'labels' => array_keys($dailyOrders), 
        ];
    }
}
