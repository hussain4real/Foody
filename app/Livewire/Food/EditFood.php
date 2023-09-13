<?php

namespace App\Livewire\Food;

use App\Models\Food;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class EditFood extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public Food $record;

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'id')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cost_price')
                    ->maxLength(255),
                Forms\Components\TextInput::make('selling_price')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('purchase_date'),
                Forms\Components\DateTimePicker::make('manufactured_date'),
                Forms\Components\DateTimePicker::make('expiry_date'),
                Forms\Components\TextInput::make('quantity')
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255)
                    ->default('food'),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('available'),
                Forms\Components\Toggle::make('for_listing')
                    ->required(),
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function edit(): void
    {
        $data = $this->form->getState();

        $this->record->update($data);
    }

    public function render(): View
    {
        return view('livewire.food.edit-food');
    }
}
