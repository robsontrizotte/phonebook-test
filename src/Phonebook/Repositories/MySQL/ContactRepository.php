<?php


namespace Phonebook\Repositories\MySQL;

use Phonebook\Collections\ContactCollection;
use Phonebook\Collections\ContactNumberCollection;
use Phonebook\Entities\Contact;
use Phonebook\Exceptions\ItemNotFoundException;
use Phonebook\Factories\Collections\ContactNumberCollectionFactory;
use Phonebook\Factories\Entities\ContactFactory;
use Phonebook\Repositories\Contracts\ContactRepositoryInterface;

/**
 * Class ContactRepository
 * @package Phonebook\Repositories\MySQL
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
class ContactRepository extends Repository implements ContactRepositoryInterface
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
        $sql = "SELECT 
            contact.*,
            GROUP_CONCAT(CONCAT(contact_number.type,
                        ':',
                        contact_number.number)) AS all_numbers
        FROM
            contact
                LEFT JOIN
            contact_number ON (contact.id = contact_number.id_contact)
        GROUP BY contact.id
        ORDER BY contact.name";
        try {
            $st = $this->connection->prepare($sql);
            $st->execute();
            $collection = new ContactNumberCollection();
            while ($row = $st->fetch(\PDO::FETCH_ASSOC)) {
                $contact = ContactFactory::fromArray($row);
                $number = $row['all_numbers'];
                if (!empty($number)) {
                    $contact->setNumbers(ContactNumberCollectionFactory::fromDatabase($number));
                }
                $collection->addItem($contact);
            }
            return $collection;
        } catch (\PDOException $e) {
            return null;
        }
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