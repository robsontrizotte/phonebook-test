<?php


namespace Phonebook\Repositories\MySQL;

use Phonebook\Collections\ContactCollection;
use Phonebook\Collections\ContactNumberCollection;
use Phonebook\Entities\Contact;
use Phonebook\Entities\ContactNumber;
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
        try {
            $sql = "INSERT INTO contact (name, email) VALUES (:name, :email);";
            $st = $this->connection->prepare($sql);
            $st->bindParam(':name', $contact->getName());
            $st->bindParam(':email', $contact->getEmail());
            $st->execute();
            $id = $this->connection->lastInsertId();
            $contact->setId($id);
            $this->saveNumbers($contact);
            return $contact;
        } catch (\PDOException $e) {
            return null;
        }
    }

    /**
     * @param Contact $contact
     * @return Contact
     */
    public function update(Contact $contact)
    {
        try {
            $sql = "UPDATE contact 
                SET 
                    name = :name, 
                    email = :email
                WHERE id = :id";
            $st = $this->connection->prepare($sql);
            $st->bindParam(':name', $contact->getName());
            $st->bindParam(':email', $contact->getEmail());
            $st->bindParam(':id', $contact->getId());
            $st->execute();
            $this->saveNumbers($contact);
            return $contact;
        } catch (\PDOException $e) {
            return null;
        }
    }


    private function getBaseSelect()
    {
        return "SELECT 
            contact.*,
            GROUP_CONCAT(
                CONCAT(contact_number.type, ':', contact_number.number)
            ) AS all_numbers
        FROM
            contact
                LEFT JOIN
            contact_number ON (contact.id = contact_number.id_contact)";
    }

    /**
     * @return ContactCollection
     */
    public function findAll()
    {
        $sql = sprintf(
            "%s
                GROUP BY contact.id
                ORDER BY contact.name",
            $this->getBaseSelect()
        );
        try {
            $st = $this->connection->prepare($sql);
            $st->execute();
            $collection = new ContactCollection();
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
        $sql = sprintf(
            "%s
                WHERE contact.id = :id",
            $this->getBaseSelect()
        );
        try {
            $st = $this->connection->prepare($sql);
            $st->bindParam(':id', $id, \PDO::PARAM_INT);
            $st->execute();
            $row = $st->fetch(\PDO::FETCH_ASSOC);
            if ($row === false || empty($row['id'])) {
                throw new ItemNotFoundException(sprintf('Contact [%d] not found', $id), 400);
            }
            $contact = ContactFactory::fromArray($row);
            $number = $row['all_numbers'];
            if (!empty($number)) {
                $contact->setNumbers(ContactNumberCollectionFactory::fromDatabase($number));
            }
            return $contact;
        } catch (\PDOException $e) {
            throw new ItemNotFoundException(sprintf('Contact [%d] not found', $id), 400, $e);
        }
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
        $this->removeNumbers($id);
        $sql = "DELETE FROM contact WHERE id = :id;";
        $st = $this->connection->prepare($sql);
        $st->bindParam(':id', $id);
        return $st->execute();
    }

    /**
     * @param Contact $contact
     */
    private function saveNumbers(Contact $contact)
    {
        $this->removeNumbers($contact->getId());
        $ordem = 1;

        /** @var ContactNumber $number */
        foreach ($contact->getNumbers() as $number) {
            $sql = "INSERT INTO contact_number (id_contact, ordem, type, number) VALUES (:id_contact, :ordem, :type, :number)";
            $st = $this->connection->prepare($sql);
            $st->bindParam(':id_contact', $contact->getId());
            $st->bindParam(':ordem', $ordem);
            $st->bindParam(':type', $number->getType());
            $st->bindParam(':number', $number->getNumber());
            $st->execute();
            $ordem++;
        }
    }
    private function removeNumbers($id)
    {
        $sql = "DELETE FROM contact_number WHERE id_contact = :id_contact;";
        $st = $this->connection->prepare($sql);
        $st->bindParam(':id_contact', $id);
        $st->execute();
    }
}