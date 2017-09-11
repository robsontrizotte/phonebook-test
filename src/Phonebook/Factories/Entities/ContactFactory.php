<?php


namespace Phonebook\Factories\Entities;

use Phonebook\Entities\Contact;

/**
 * Class ContactFactory
 * @package Phonebook\Factories\Entities
 */
final class ContactFactory
{
    /**
     * @param array $data
     * @return Contact
     */
    public static function fromArray(array $data)
    {
        $contact = new Contact();
        return static::fillFromArray($contact, $data);
    }

    /**
     * @param Contact $contact
     * @param array $data
     * @return Contact
     */
    public static function fillFromArray(Contact $contact, array $data)
    {
        foreach ($data as $key => $value) {
            $method = sprintf('set%s', ucfirst(strtolower($key)));
            if (method_exists($contact, $method)) {
                $contact->{$method}($value);
            }
        }
        return $contact;
    }
}