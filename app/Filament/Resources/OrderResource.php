<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Notifications\Notifiable;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Order Id'),
                Tables\Columns\TextColumn::make('customer_name')->label('Customer Name'),
                Tables\Columns\TextColumn::make('contact_number')->label('Contact Number'),
                Tables\Columns\TextColumn::make('shipping_address')->label('Shipping Address'),
                Tables\Columns\TextColumn::make('delivery_method')->label('Delivery Method'),
                Tables\Columns\TagsColumn::make('total_items'),
                Tables\Columns\TextColumn::make('total_price'),
                Tables\Columns\BadgeColumn::make('items')
                ->formatStateUsing(fn ($state) => is_array($state) 
                ? implode(', ', $state)
                : implode(', ', json_decode($state, true))
                ),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\BooleanColumn::make('is_completed')->label('Completed')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('changeStatus')
                    ->label('Change Status')
                    ->action(function (Order $record, array $data): void {
                        $record->update(['status' => $data['status']]);
                    })
                    ->form([
                        Forms\Components\Select::make('status')
                            ->options([
                                'Received' => 'Received',
                                'Preparing' => 'Preparing',
                                'Pick Up by Rider' => 'Pick Up by Rider',
                                'On the Way' => 'On the Way',
                            ])
                            ->required()
                            ->label('Order Status'),
                    ])
                    ->modalHeading('Update Order Status')
                    ->modalButton('Update')
                    ->color('info')
                    ->icon('heroicon-o-pencil')
                    ->visible(fn (Order $record): bool => $record->delivery_method === 'delivery'),
                Tables\Actions\Action::make('Complete')->label('Complete')
                    ->action(function (Order $record) {
                       $record->update([
                         'is_completed' => true,
                         'status' => $record->delivery_method === 'pickup' ? 'Picked-Up' : 'Delivered',
                    ]);
                        Notification::make()
                           ->success()
                           ->title('Order Completed')
                           ->body('The Order has been marked as completed')
                           ->send();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check'),
                Tables\Actions\Action::make('Cancelled')->label('Cancelled')
                ->action(function ($record) {
                    $record->update([
                        'is_completed' => false,
                        'status' => 'Cancelled',
                    ]);
                        Notification::make()
                           ->danger()
                           ->title('Order Cancelled')
                           ->body('The Order has been marked as Cancelled')
                           ->send();
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-x-mark'),
                Tables\Actions\DeleteAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
