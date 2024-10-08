<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Widgets\Action;
use App\Models\Order;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\OrderResource;
use Filament\Tables\Columns\SelectColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\URL;

class LatestOrders extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;
    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                // ...
                Tables\Columns\TextColumn::make('id')
                ->label('Order ID') 
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('table_no')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grand_total')
                    ->searchable()
                    ->sortable()
                    ->money('MMK'),
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('item')
                    ->label('Product Name')
                    ->getStateUsing(fn ($record) => $record->item ? $record->item->map(fn ($item) => $item->product->name)->join(', ') : 'N/A')
                    ->sortable(),
                SelectColumn::make('status')
                    ->options([
                        'ဆိုင်ထိုင်' => 'ဆိုင်ထိုင်',
                        'ပါဆယ်' => 'ပါဆယ်',
                        'cancelled' => 'Cancelled'
                    ])->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->actions([
                Tables\Actions\Action::make('View Orders')
                    ->url(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record->id]))
                    ->icon('heroicon-o-eye'),
                Tables\Actions\Action::make('Voucher')
                    ->icon('heroicon-o-document')
                    ->action(function (Order $record) {
                        $url = URL::temporarySignedRoute(
                            'download.order.pdf',
                            now()->addMinutes(30),
                            ['order' => $record->id]
                        );
                        return redirect($url);
                    }),
            ]);
    }
}
