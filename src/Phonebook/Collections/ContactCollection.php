<?php


namespace Phonebook\Collections;

use Phonebook\Entities\Contact;

/**
 * Class ContactCollection
 * @package Phonebook\Collections
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
class ContactCollection extends Collection
{
    /**
     * @param Contact $item
     */
    public function addItem(Contact $item)
    {
        $this->offsetSet($this->count(), $item);
    }
}