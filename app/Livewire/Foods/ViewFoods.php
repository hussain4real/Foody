<?php

namespace App\Livewire\Foods;

use App\Http\Resources\FoodResource;
use App\Models\Food;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

//#[Route(Http::GET, '/foods', name: 'foods.index')
class ViewFoods extends Component
{
    use WithPagination;

    public function render(): View
    {
        $foods = Food::paginate(20);
        //        dd(FoodResource::collection($foods));

        return view('livewire.foods.view-foods')->
            with([
                'foods' => FoodResource::collection($foods),
            ]);

    }
}
