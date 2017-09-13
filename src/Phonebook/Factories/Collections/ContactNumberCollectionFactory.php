<?php


namespace Phonebook\Factories\Collections;

use Phonebook\Collections\ContactNumberCollection;
use Phonebook\Entities\ContactNumber;
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

    /**
     * @param $allNumbers
     * @return ContactNumberCollection
     */
    public static function fromDatabase($allNumbers)
    {
        $collection = new ContactNumberCollection();
        $numbers = explode(',', $allNumbers);
        foreach ($numbers as $n) {
            $number = explode(':', $n);
            $contactNumber = new ContactNumber();
            $contactNumber->setType($number[0]);
            $contactNumber->setNumber($number[1]);
            $collection->addItem($contactNumber);
        }
        return $collection;
    }
}