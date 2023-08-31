<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                    ->minLength(2)
                    ->maxLength(155)
                    ->required(),
                TextInput::make('last_name')
                    ->minLength(2)
                    ->maxLength(155)
                    ->required(),
                TextInput::make('mobile_number')
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                    ->required(),
                TextInput::make('building_number')
                    ->minLength(1)
                    ->maxLength(20)
                    ->required(),
                TextInput::make('street')
                    ->minLength(1)
                    ->maxLength(255)
                    ->required(),
                TextInput::make('zone')
                    ->minLength(1)
                    ->maxLength(20)
                    ->required(),
                TextInput::make('city')
                    ->minLength(1)
                    ->maxLength(20)
                    ->required(),
                $this->getEmailFormComponent(),
                TextInput::make('password')
                    ->password()
                    ->autocomplete('new-password'),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ])
            ->columns(2);
    }
}
