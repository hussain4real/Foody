<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FoodStatusEnum: string implements HasLabel
{
    case AVAILABLE = 'available';
    case UNAVAILABLE = 'unavailable';
    case COLLECTED = 'collected';
    case BOOKED = 'booked';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
