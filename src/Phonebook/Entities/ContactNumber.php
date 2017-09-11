<?php


namespace Phonebook\Entities;

/**
 * Class ContactNumber
 * @package Phonebook\Entities
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
class ContactNumber extends Entity
{
    const TYPE_CELLPHONE = 'CELL';
    const TYPE_HOME = 'HOME';
    const TYPE_COMMERCIAL = 'COMMERCIAL';
    /**
     * @var string
     */
    protected $number;

    /**
     * @var string
     */
    protected $type;

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
