<?php

namespace Phonebook\Services;

use Phonebook\Entities\Contact;
use Phonebook\Entities\ContactNumber;
use Phonebook\Exceptions\InvalidArgumentsException;
use Phonebook\Factories\Collections\ContactNumberCollectionFactory;
use Phonebook\Factories\Entities\ContactFactory;
use Phonebook\Repositories\Contracts\ContactRepositoryInterface;
use Phonebook\Tools\Arguments;

/**
 * Class ContactManager
 * @package Phonebook\Services
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
class ContactManager extends Service
{
    /**
     * @var ContactRepositoryInterface
     */
    private $repository;

    /**
     * ContactManager constructor.
     * @param ContactRepositoryInterface $repository
     */
    public function __construct(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $contact
     * @return Contact
     */
    public function createContact(array $contact)
    {
        Arguments::validArguments(['name', 'email'], $contact);
        $numbers = $this->getNumbers($contact);
        unset($contact['numbers']);
        unset($contact['number']);

        $contact = ContactFactory::fromArray($contact);
        $contact->setNumbers(ContactNumberCollectionFactory::fromArray($numbers));
        return $this->repository->create($contact);
    }

    /**
     * @param int $id
     * @param array $updateData
     * @return Contact
     */
    public function updateContact($id, array $updateData)
    {
        $contact = $this->repository->find($id);
        if (!$contact instanceof Contact) {
            throw new InvalidArgumentsException(sprintf('Contact [%d] not found.', $id), 401);
        }
        $numbers = $this->getNumbers($updateData);
        unset($updateData['numbers']);
        unset($updateData['number']);
        $contact = ContactFactory::fillFromArray($contact, $updateData);
        $contact->setNumbers(ContactNumberCollectionFactory::fromArray($numbers));
        return $this->repository->update($contact);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function removeContact($id)
    {
        $contact = $this->repository->find($id);
        if (!$contact instanceof Contact) {
            throw new InvalidArgumentsException(sprintf('Contact [%d] not found.', $id), 401);
        }
        return $this->repository->remove($id);
    }

    /**
     * @param array $contact
     * @return array
     */
    private function getNumbers(array $contact)
    {
        $numbers = [];
        if (isset($contact['numbers'])) {
            $numbers = $contact['numbers'];
        }
        if (isset($contact['number'])) {
            $numbers[] = [
                ContactNumber::TYPE_CELLPHONE => $contact['number']
            ];
        }
        return $numbers;
    }

    /**
     * @return \Phonebook\Collections\ContactCollection
     */
    public function listAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param int $id
     * @return Contact
     */
    public function get($id)
    {
        if (empty($id)) {
            throw new InvalidArgumentsException("Contact id is empty.", 400);
        }
        if (!is_int($id)) {
            throw new InvalidArgumentsException("Contact id is invalid.", 400);
        }
        return $this->repository->find($id);
    }

}
