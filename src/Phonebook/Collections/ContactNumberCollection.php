<?php


namespace Phonebook\Collections;

use Phonebook\Entities\ContactNumber;

/**
 * Class ContactNumberCollection
 * @package Phonebook\Collections
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
class ContactNumberCollection extends Collection
{
    /**
     * @param ContactNumber $item
     */
    public function addItem(ContactNumber $item)
    {
        $this->offsetSet($this->count(), $item);
    }
}