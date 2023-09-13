<?php

namespace App\Livewire\Food;

use App\Enums\FoodStatusEnum;
use App\Enums\FoodTypeEnum;
use App\Models\Food;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class CreateFood extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
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
                Forms\Components\TextInput::make('description')
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
                    ->collection('images')
                    ->image()
                    ->maxFiles(4)
                    ->maxSize(1024),
            ])
            ->statePath('data')
            ->model(Food::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Food::create($data);

        $this->form->model($record)->saveRelationships();
    }

    public function render(): View
    {
        return view('livewire.food.create-food');
    }
}
