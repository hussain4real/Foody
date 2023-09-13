<?php

namespace App\Livewire\Foods;

use App\Http\Resources\FoodResource;
use App\Models\Food;
use Livewire\Component;
use Livewire\WithPagination;

//#[Route(Http::GET, '/foods', name: 'foods.index')
class ViewFoods extends Component
{
    use WithPagination;

    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $foods = Food::with('user:id,first_name,last_name', 'media')
            ->where('for_listing', '=', true)
            ->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.foods.view-foods')->
        with([
            'foods' => FoodResource::collection($foods),
        ]);

    }
}
