<?php

namespace App\Enums;

enum FoodTypeEnum: string
{
    case FOOD = 'food';
    case DRINK = 'drink';
    case DESSERT = 'dessert';
    case SNACK = 'snack';
    case OTHER = 'other';

    public static function getConstants(): array
    {
        $oClass = new \ReflectionClass(get_called_class());

        return $oClass->getConstants();
    }

    public static function getCommaSeperatedConstants(): string
    {
        $oClass = new \ReflectionClass(get_called_class());
        $array = array_values($oClass->getConstants());

        return implode(',', $array);
    }

    public static function getValue($key)
    {
        $oClass = new \ReflectionClass(get_called_class());

        $key = array_search($key, $oClass->getConstants());

        return $oClass->getConstant($key);
    }
}
