<?php

namespace App\Enums;

enum FoodTypeEnum: string
{
    case FOOD = 'food';
    case DRINK = 'drink';
    case DESSERT = 'dessert';
    case SNACK = 'snack';
    case OTHER = 'other';

}
