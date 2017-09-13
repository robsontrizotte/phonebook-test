<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
        return $this->view('index.twig', ['name' => 'Robson']);
    }

}