<?php

namespace App\Http\Controllers;

use Phonebook\Entities\Contact;
use Phonebook\Exceptions\InvalidArgumentsException;
use Phonebook\Tools\Arguments;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Class ContactController
 * @package App\Http\Controllers
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
class ContactController extends Controller
{
    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        $contacts = $this->contactManager->listAll();
        return $this->view('index.twig', ['contacts' => $contacts]);
    }

    public function show(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        if (!isset($args['id'])) {
            throw new InvalidArgumentsException('Contact not found.');
        }
        $id = $args['id'];
        $contact = $this->contactManager->get((int)$id);

        return $this->form($contact);
    }
    public function add(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        return $this->form();
    }

    private function form(Contact $contact = null)
    {
        $contact = is_null($contact) ? new Contact() : $contact;
        return $this->view('form.twig', ['contact' => $contact]);
    }

    public function save(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        $params = $request->getParsedBody();
        try {
            Arguments::validArguments(['name', 'email', 'number', 'type'], $params);
            $numbers = [];
            foreach ($params['number'] as $index => $number) {
                $numbers[] = [
                    strtoupper($params['type'][$index]) => $number
                ];
            }
            unset($params['number']);
            unset($params['type']);
            $params['numbers'] = $numbers;
            if (isset($params['id'])) {
                $contact = $this->contactManager->updateContact($params['id'], $params);
            } else {
                $contact = $this->contactManager->createContact($params);
            }

            if ($contact instanceof Contact) {
                return new RedirectResponse('/', 302);
            }
            throw new \LogicException('Unable to save contact');

        } catch (\InvalidArgumentException $e) {
            if (isset($params['id'])) {
                return new RedirectResponse(sprintf('/show/%d', $params['id']), 302);
            }
            return new RedirectResponse('/show/', 302);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return RedirectResponse
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        if (!isset($args['id'])) {
            throw new InvalidArgumentsException('Contact not found.');
        }
        $id = $args['id'];
        if ($this->contactManager->removeContact($id)) {
            return new RedirectResponse('/', 302);
        }
        throw new \LogicException('Unable to remove contact');
    }
}