<?php


namespace Phonebook\Repositories\MySQL;

use Phonebook\Collections\ContactCollection;
use Phonebook\Entities\Contact;
use Phonebook\Exceptions\ItemNotFoundException;
use Phonebook\Repositories\Contracts\ContactRepositoryInterface;

/**
 * Class ContactRepository
 * @package Phonebook\Repositories\MySQL
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
class ContactRepository implements ContactRepositoryInterface
{

    /**
     * @param Contact $contact
     * @return Contact
     */
    public function create(Contact $contact)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param Contact $contact
     * @return Contact
     */
    public function update(Contact $contact)
    {
        // TODO: Implement update() method.
    }

    /**
     * @return ContactCollection
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @param int $id
     * @return Contact
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * @param array $filters
     * @return ContactCollection
     */
    public function findBy(array $filters)
    {
        // TODO: Implement findBy() method.
    }

    /**
     * @param array $filter
     * @return Contact
     * @throws ItemNotFoundException
     */
    public function findOneBy(array $filter)
    {
        // TODO: Implement findOneBy() method.
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }
}