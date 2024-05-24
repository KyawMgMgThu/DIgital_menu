<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends BaseWidget
{

    protected function getStats(): array
    {
        return [
            //
            Stat::make('ဆိုင်ထိုင် Order', Order::query()->where('status', 'ဆိုင်ထိုင်')->count()),
            Stat::make('ပါဆယ် Order', Order::query()->where('status', 'ပါဆယ်')->count()),
            Stat::make('Cancelled Order', Order::query()->where('status', 'cancelled')->count()),
            Stat::make('Average Order Price', number_format(Order::query()->avg('grand_total'), 2)),

        ];
    }
}
