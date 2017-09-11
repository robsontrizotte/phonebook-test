<?php

namespace Phonebook\Repositories\Contracts;

use Phonebook\Collections\ContactCollection;
use Phonebook\Entities\Contact;
use Phonebook\Exceptions\ItemNotFoundException;

/**
 * Interface ContactRepositoryInterface
 * @package Phonebook\Repositories\Contracts
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
interface ContactRepositoryInterface
{
    /**
     * @param Contact $contact
     * @return Contact
     */
    public function create(Contact $contact);

    /**
     * @param Contact $contact
     * @return Contact
     */
    public function update(Contact $contact);

    /**
     * @return ContactCollection
     */
    public function findAll();

    /**
     * @param int $id
     * @return Contact
     */
    public function find($id);

    /**
     * @param array $filters
     * @return ContactCollection
     */
    public function findBy(array $filters);

    /**
     * @param array $filter
     * @return Contact
     * @throws ItemNotFoundException
     */
    public function findOneBy(array $filter);

    /**
     * @param $id
     * @return bool
     */
    public function remove($id);
}
