<?php

namespace Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Phonebook\Entities\Contact;
use Phonebook\Exceptions\InvalidArgumentsException;
use Phonebook\Tools\Arguments;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ApiContactController
 * @package Api\Http\Controllers
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
class ApiContactController extends Controller
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return \Zend\Diactoros\Response\JsonResponse
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        $contacts = $this->contactManager->listAll();

        return $this->json(['contacts' => $contacts->toArray()]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return \Zend\Diactoros\Response\JsonResponse
     */
    public function show(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        if (!isset($args['id'])) {
            throw new InvalidArgumentsException('Contact not found.', 401);
        }
        $id = $args['id'];
        $contact = $this->contactManager->get($id);
        if ($contact === null) {
            throw new InvalidArgumentsException('Contact not found.', 401);
        }
        return $this->json($contact->toArray());
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return \Zend\Diactoros\Response\JsonResponse
     */
    public function save(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        $params = $request->getParsedBody();
        Arguments::validArguments(['number', 'type'], $params);
        $numbers = [];
        foreach ($params['number'] as $index => $number) {
            $numbers[] = [
                strtoupper($params['type'][$index]) => $number
            ];
        }
        unset($params['number']);
        unset($params['type']);
        $params['numbers'] = $numbers;
        $action = 'updated';
        if ($request->getMethod() == 'PUT') {
            $contact = $this->contactManager->updateContact($params['id'], $params);
        } else {
            $action = 'added';
            $contact = $this->contactManager->createContact($params);
        }

        if ($contact instanceof Contact) {
            return $this->json([$action => true, 'contact' => $contact]);
        }
        throw new \LogicException('Unable to save contact');
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        if (!isset($args['id'])) {
            throw new InvalidArgumentsException('Contact not found.', 401);
        }
        $id = $args['id'];
        if ($this->contactManager->removeContact($id)) {
            return $this->json(['delete' => true]);
        }
        throw new \LogicException('Unable to remove contact');
    }
}