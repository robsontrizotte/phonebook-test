<?php


namespace Phonebook\Factories\Collections;

use Phonebook\Collections\ContactNumberCollection;
use Phonebook\Factories\Entities\ContactNumberFactory;

/**
 * Class ContactNumberCollectionFactory
 * @package Phonebook\Factories\Collections
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
class ContactNumberCollectionFactory
{
    /**
     * @param array $data
     * @return ContactNumberCollection
     */
    public static function fromArray(array $data)
    {
        $collection = new ContactNumberCollection();
        foreach ($data as $item) {
            $collection->addItem(ContactNumberFactory::fromArray($item));
        }
        return $collection;
    }
}