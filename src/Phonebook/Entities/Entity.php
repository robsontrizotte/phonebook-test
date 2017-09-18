<?php

namespace Phonebook\Entities;

use Phonebook\Collections\Collection;

/**
 * Class Entity
 * @package Phonebook\Entities
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
abstract class Entity
{
    /**
     * @return array
     */
    public function toArray()
    {
        $properties = get_object_vars($this);
        foreach ($properties as $prop => $value) {
            if ($value instanceof Entity || $value instanceof Collection) {
                $properties[$prop] = $value->toArray();
            }
        }
        return $properties;
    }
}