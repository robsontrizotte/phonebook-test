<?php

namespace Phonebook\Entities;

use Phonebook\Collections\ContactNumberCollection;

/**
 * Class Contact
 * @package Phonebook\Entities
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
class Contact extends Entity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var ContactNumberCollection
     */
    protected $numbers;

    /**
     * @var string
     */
    protected $email;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ContactNumberCollection
     */
    public function getNumbers()
    {
        return $this->numbers;
    }

    /**
     * @param ContactNumberCollection $numbers
     */
    public function setNumbers(ContactNumberCollection $numbers)
    {
        $this->numbers = $numbers;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        $number = '';
        if (count($this->getNumbers())) {
            $numbers = [];
            /** @var ContactNumber $number */
            foreach ($this->getNumbers() as $contactNumber) {
                $numbers[] = $contactNumber->getNumber();
            }
            $number = implode(', ', $numbers);
        }

        return $number;
    }
}