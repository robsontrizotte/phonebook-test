<?php

namespace Phonebook\Factories\Entities;

use Phonebook\Entities\ContactNumber;
use Phonebook\Exceptions\InvalidArgumentsException;

class ContactNumberFactory
{
    /**
     * @param array $data
     * @return ContactNumber
     */
    public static function fromArray(array $data)
    {
        $type = array_keys($data)[0];
        if ($type !== ContactNumber::TYPE_CELLPHONE ||
            $type !== ContactNumber::TYPE_COMMERCIAL ||
            $type !== ContactNumber::TYPE_HOME) {
            throw new InvalidArgumentsException(sprintf('Invalid number type [%s]', $type), 401);
        }
        $entity = new ContactNumber();
        $entity->setType($type);
        $entity->setNumber($data[$type]);
        return $entity;
    }
}