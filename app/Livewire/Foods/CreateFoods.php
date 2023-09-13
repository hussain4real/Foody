<?php

namespace App\Livewire\Foods;

use App\Enums\FoodTypeEnum;
use App\Livewire\Forms\FoodForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateFoods extends Component
{
    use WithFileUploads;

    public FoodForm $form;

    public function save()
    {

        $this->form->store();

        return redirect(route('food.index'))
            ->with('status', 'Food created successfully!');

    }

    public function render()
    {
        $foodTypes = FoodTypeEnum::getConstants();
        $photos = $this->form->photos;

        return view('livewire.foods.create-food')
            ->with([
                'foodTypes' => $foodTypes,
                'photos' => $photos,
            ]);
    }
}
