<?php

namespace App\Filament\Resources;

use App\Enums\FoodStatusEnum;
use App\Enums\FoodTypeEnum;
use App\Filament\Resources\FoodResource\Pages;
use App\Models\Food;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FoodResource extends Resource
{
    protected static ?string $model = Food::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([

                Forms\Components\Select::make('user_id')
                    ->relationship('user',
                        modifyQueryUsing: function (Builder $query) {
                            if (auth()->user()->hasRole('Super Admin')) {
                                $query->orderBy('first_name')->orderBy('last_name');
                            } else {
                                $query
                                    ->where('id', '=', auth()
                                        ->user()->id
                                    )
                                    ->orderBy('first_name')
                                    ->orderBy('last_name');
                            }

                        }
                    )
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->last_name}")
                    ->preload()
                    ->selectablePlaceholder(false)
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cost_price')
                    ->maxLength(255)
                    ->numeric()
                    ->inputMode('decimal')
                    ->suffixIcon('heroicon-m-banknotes'),
                Forms\Components\TextInput::make('selling_price')
                    ->maxLength(255)
                    ->suffixIcon('heroicon-m-banknotes'),
                Forms\Components\TextInput::make('quantity')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('manufactured_date')
                    ->native(true)
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection()
                    ->live(onBlur: true),
                Forms\Components\DatePicker::make('purchase_date')
                    ->afterOrEqual('manufactured_date')
                    ->before('tomorrow')
                    ->native(true)
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection()
                    ->live(onBlur: true),
                Forms\Components\DatePicker::make('expiry_date')
                    ->after('manufactured_date')
                    ->prefix('Expires')
                    ->suffix('at midnight')
                    ->native(true)
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection()
                    ->live(onBlur: true),
                Forms\Components\Select::make('type')
                    ->suffixIcon('heroicon-m-cake')
                    ->options(FoodTypeEnum::class)
                    ->required()
                    ->default('food')
                    ->selectablePlaceholder(false),
                Forms\Components\Select::make('status')
                    ->suffixIcon('heroicon-m-arrow-path')
                    ->options(FoodStatusEnum::class)
                    ->required()
                    ->default('available')
                    ->selectablePlaceholder(false),
                Forms\Components\Toggle::make('for_listing')
                    ->required(),
                Forms\Components\SpatieMediaLibraryFileUpload::make('photos')
                    ->multiple()
                    ->responsiveImages()
                    ->imageEditor()
                    ->reorderable()
                    ->panelLayout('grid')
                    ->collection('images')
                    ->image()
                    ->maxFiles(4)
                    ->maxSize(1024),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.first_name')
                    ->color('gray')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cost_price')
                    ->money('qar')
                    ->color('yellow')
                    ->default(0)
                    ->searchable(),
                Tables\Columns\TextColumn::make('selling_price')
//                    ->money('qar')
                    ->color('cyan')
                    ->state(
                        function (Model $record): string {
                            return $record->selling_price == 0 ? 'free' : "QAR {$record->selling_price}";
                        }
                    )
                    ->badge(function (Model $record, $state): string {
                        return $record->selling_price == 0 ? $state : false;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric(decimalPlaces: 0)
                    ->default(0)
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        FoodTypeEnum::FOOD->value => 'violet',
                        FoodTypeEnum::DESSERT->value => 'teal',
                        FoodTypeEnum::DRINK->value => 'lime',
                        FoodTypeEnum::SNACK->value => 'orange',
                        FoodTypeEnum::OTHER->value => 'stone'
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        FoodStatusEnum::AVAILABLE->value => 'success',
                        FoodStatusEnum::UNAVAILABLE->value => 'gray',
                        FoodStatusEnum::BOOKED->value => 'warning',
                        FoodStatusEnum::COLLECTED->value => 'info'
                    })
                    ->searchable(),
                Tables\Columns\IconColumn::make('for_listing')
                    ->boolean(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('photos')
                    ->collection('images')
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText(false),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->dateTime()
                    ->since()
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchase_date')
                    ->dateTime()
                    ->since()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->poll('10s')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListFood::route('/'),
            'create' => Pages\CreateFood::route('/create'),
            'view' => Pages\ViewFood::route('/{record}'),
            'edit' => Pages\EditFood::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole('Super Admin')) {
            return parent::getEloquentQuery()
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
        } else {
            return parent::getEloquentQuery()
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ])
                ->where('user_id', '=', auth()->id());
        }

        //        return parent::getEloquentQuery()
        //            ->withoutGlobalScopes([
        //                SoftDeletingScope::class,
        //            ]);
    }

    //    public static function getPermissionPrefixes(): array
    //    {
    //        // TODO: Implement getPermissionPrefixes() method.
    //    }
}
