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
        $foods = Food::with('user:id,first_name,last_name', 'media')->paginate(5);

        return view('livewire.foods.view-foods')->
        with([
            'foods' => FoodResource::collection($foods),
        ]);

    }
}
//$images = $foods->pluck('images')->flatten(
//    1
//)->map(
//    fn ($image) => json_decode($image)
//)->flatten(
//    1
//)->toArray();
