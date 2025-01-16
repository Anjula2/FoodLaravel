<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerRequestResource\Pages;
use App\Filament\Resources\CustomerRequestResource\RelationManagers;
use App\Models\CustomerRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Illuminate\Notifications\Notifiable;

class CustomerRequestResource extends Resource
{
    protected static ?string $model = CustomerRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                     ->default(auth()->id())
                     ->required(),

                Forms\Components\TextInput::make('customer_name')
                     ->label('Customer Name')
                     ->required()
                     ->maxLength(255),

                Forms\Components\TextInput::make('email')
                     ->label('Email')
                     ->email()
                     ->required()
                     ->maxLength(255),

                Forms\Components\TextInput::make('meal_name')
                    ->label('Meal Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('message')
                    ->label('Message')
                    ->maxLength(500)
                    ->nullable(),
                
                Forms\Components\FileUpload::make('image_path')
                    ->nullable(),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->maxLength(500)
                    ->nullable(),

                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->nullable(),

                Forms\Components\Toggle::make('is_accepted')
                    ->label('Is Accepted')
                    ->default(true),
              ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('meal_name')
                   ->label('Meal Name')
                   ->sortable()
                   ->searchable(),

                Tables\Columns\TextColumn::make('message')
                   ->label('Message')
                   ->limit(50) 
                   ->wrap(),

                Tables\Columns\ImageColumn::make('image_path')
                   ->label('Image')
                   ->size(50, 50)
                   ->url(fn ($record) => asset('storage/' . $record->image_path)),

                Tables\Columns\TextColumn::make('description')
                   ->label('Description')
                   ->limit(50) 
                   ->wrap(),

                Tables\Columns\TextColumn::make('price')
                   ->label('Price')
                   ->sortable()
                   ->prefix('Rs.'),
                Tables\Columns\BooleanColumn::make('is_accepted')->label('Accepted')->sortable(),
            ])

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Accept')->label('Accept')
                    ->action(function ($record) {
                        $record->update(['is_accepted' => true]);
                        Notification::make()
                            ->success()
                            ->title('Accepted')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check'),
                    
                Tables\Actions\EditAction::make(),
                
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
            'index' => Pages\ListCustomerRequests::route('/'),
            'create' => Pages\CreateCustomerRequest::route('/create'),
            'edit' => Pages\EditCustomerRequest::route('/{record}/edit'),
        ];
    }
}
