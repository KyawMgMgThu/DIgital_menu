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
            Stat::make('ဆိုင်ထိုင် Order', Order::query()->where('status', 'ဆိုင်ထိုင်')->count())
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('ပါဆယ် Order', Order::query()->where('status', 'ပါဆယ်')->count())
                ->chart([2, 3, 7, 6, 8, 4, 10])
                ->color('warning'),
            Stat::make('Cancelled Order', Order::query()->where('status', 'cancelled')->count()),
            Stat::make('Average Order Price', number_format(Order::query()->avg('grand_total'), 2))
                ->chart([7, 2, 10, 3, 15, 4, 17]),

        ];
    }
}
