<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class FoodForm extends Form
{
    #[Rule('required|min:3|max:125')]
    public string $name = '';

    #[Rule('required|min:3|max:255')]
    public string $description = '';

    #[Rule(['nullable'])]
    public string $type = '';

    //    #[Rule([
    //        'form.photos' => 'required|array|min:1|max:4',
    //        'form.photos.*' => [
    //            'required',
    //            'image',
    //            'mimes:jpg,jpeg,png',
    //            'max:1024',
    //        ],
    //    ], attribute: [
    //        'form.photos' => 'photos',
    //        'form.photos.*' => 'photos',
    //    ], message: [
    //        'form.photos.required' => 'Please upload at least one photo.',
    //        'form.photos.min' => 'Please upload at least one photo.',
    //        'form.photos.max' => 'Please upload no more than four photos.',
    //        'form.photos.*.required' => 'Please upload at least one photo.',
    //        'form.photos.*.image' => 'Please upload a valid image.',
    //        'form.photos.*.mimes' => 'Please upload a valid image.',
    //        'form.photos.*.max' => 'Image size cannot be more than 1MB.',
    //    ])]

    #[Rule('array|max:4')]
    #[Rule(['form.photos.*' => 'image|max:1024|mimes:jpg,jpeg,png'], attribute: [
        'form.photos.*' => 'photos',
        //    ], message: [
        //        'form.photos.*.image' => 'Please upload a valid image.',
        //        'form.photos.*.mimes' => 'Please upload a valid image.',
        //        'form.photos.*.max' => 'Image size cannot be more than 1MB.',
    ])]
    public $photos = [];

    public function store()
    {
        $this->validate();
        //        dd($this->all());

        $food = auth()->user()->postedFoods()->create($this->all());

        if ($this->photos) {
            foreach ($this->photos as $photo) {
                $food->addMedia($photo->getRealPath())
                    ->toMediaCollection('images');
            }
            //            $food->addMedia($this->photos->getRealPath())
            //                ->toMediaCollection('images');
        }

        //        $food->addMedia($this->photo->getRealPath())
        //            ->toMediaCollection('images');
    }
}
