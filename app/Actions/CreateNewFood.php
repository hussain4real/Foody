<?php

namespace App\Actions;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateNewFood
{
    public function __invoke(array $data, Request $request): Food
    {
        // Validate the request...
        $data = Validator::validate($data, [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
        ]);

        $food = $request->user()->postedFoods()->create($data);

        return $food;
    }
}
