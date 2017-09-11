<?php

namespace Phonebook\Entities;

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
        return get_object_vars($this);
    }
}