<?php

namespace App\Http\Controllers;

use App\Http\View\Twig;
use App\ServiceContainer;
use Phonebook\Services\ContactManager;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class BaseController
 * @package App\Http\Controllers
 * @author Robson Trizotte <robson.trizotte@gmail.com>
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
     * @param $data
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    protected function json($data, $status = 200, array $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
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
