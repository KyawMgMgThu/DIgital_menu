<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\OrderItem;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Support\Facades\URL;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $recordTitleAttribute = 'status';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Order Information')->schema([
    
                        TextInput::make('order_id')
                            ->label('Order ID')
                            ->default(fn () => 'ORD-' . strtoupper(uniqid())) // Example unique ID generation
                            ->required(),
    
                        Select::make('payment_method')
                            ->options([
                                'cash' => 'Cash',
                                'credit card' => 'Credit Card'
                            ])->required(),
    
                        Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                            ])->default('pending')
                            ->required(),
    
                        ToggleButtons::make('status')
                            ->inline()
                            ->default('ဆိုင်ထိုင်')
                            ->required()
                            ->options([
                                'ဆိုင်ထိုင်' => 'ဆိုင်ထိုင်',
                                'ပါဆယ်' => 'ပါဆယ်',
                                'cancelled' => 'cancelled',
                            ])
                            ->colors([
                                'ဆိုင်ထိုင်' => 'info',
                                'ပါဆယ်' => 'warning',
                                'cancelled' => 'danger',
                            ])
                            ->icons([
                                'ဆိုင်ထိုင်' => 'heroicon-m-sparkles',
                                'ပါဆယ်' => 'heroicon-m-check-badge',
                                'cancelled' => 'heroicon-m-x-circle',
                            ]),
    
                        ToggleButtons::make('table_no')
                            ->inline()
                            ->default('none')
                            ->required()
                            ->options([
                                'none' => 'none',
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '5' => '5',
                                '6' => '6',
                                '7' => '7',
                                '8' => '8',
                                '9' => '9',
                            ])
                    ])->columns(2),
    
                    Section::make('Order Items')->schema([
                        Repeater::make('item')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->distinct()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        $price = Product::find($state)?->price ?? 0;
                                        $set('unit_amount', $price);
                                        $set('total_amount', $price);
                                    }),
    
                                TextInput::make('quantity')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->minValue(1)
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, Set $set, Get $get) => $set('total_amount', $state * $get('unit_amount'))),
    
                                TextInput::make('unit_amount')
                                    ->numeric()
                                    ->required()
                                    ->dehydrated(),
    
                                TextInput::make('total_amount')
                                    ->numeric()
                                    ->dehydrated()
                                    ->required(),
                            ])->columns(2),
    
                        Placeholder::make('grand_total_placeholder')
                            ->label('Total')
                            ->content(function (Get $get, Set $set) {
                                $total = 0;
                                if (!$repeaterItems = $get('item')) {
                                    return $total;
                                }
    
                                foreach ($repeaterItems as $key => $item) {
                                    $total += $get("item.{$key}.total_amount");
                                }
                                $set('grand_total', $total);
                                return $total . ' Ks';
                            }),
    
                        Hidden::make('grand_total')->dehydrated(),
                    ])
                ])->columnSpan(3)
            ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                ->label('Order ID') 
                ->sortable()
                ->searchable(),
                TextColumn::make('table_no')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('grand_total')
                    ->numeric()
                    ->sortable()
                    ->money('MMK'), // Assuming MMK as currency
                TextColumn::make('payment_method')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('payment_status')
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
            ])
            ->filters([
                SelectFilter::make('payment_status')->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'failed' => 'Failed',
                ]),
                SelectFilter::make('status')->options([
                    'ဆိုင်ထိုင်' => 'ဆိုင်ထိုင်',
                    'ပါဆယ်' => 'ပါဆယ်',
                    'cancelled' => 'Cancelled',
                ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('Voucher')
                    ->icon('heroicon-o-document')
                    ->action(function (Order $record) {
                        $url = URL::temporarySignedRoute(
                            'download.order.pdf',
                            now()->addMinutes(30),
                            ['order' => $record->id]
                        );
                        return redirect($url);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 10 ? 'success' : 'danger';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
