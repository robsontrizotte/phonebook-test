<?php

namespace App\Http\Controllers;

use App\Http\View\Twig;
use App\ServiceContainer;
use Phonebook\Services\ContactManager;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class BaseController
 * @package App\Http\Controllers
 * @author Robson Trizotte <robson.trizotte@rentcars.com>
 */
abstract class Controller
{
    /**
     * @var ServiceContainer
     */
    protected $container;

    /**
     * @var Twig
     */
    protected $view;

    /**
     * @var ContactManager
     */
    protected $contactManager;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->container = new ServiceContainer();
        $this->view = $this->container->get('view');
        $this->contactManager = $this->container->get('contact.manager');
    }

    /**
     * @param string $data
     * @param int $status
     * @param array $headers
     * @return HtmlResponse
     */
    protected function response($data, $status = 200, array $headers = [])
    {
        return new HtmlResponse($data, $status, $headers);
    }

    /**
     * @param string $view
     * @param array $data
     * @return HtmlResponse
     */
    protected function view($view, $data = [])
    {
        return $this->response(
            $this->view->render($view, $data)
        );
    }
}
