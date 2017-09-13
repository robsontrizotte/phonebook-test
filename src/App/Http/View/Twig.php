<?php

namespace App\Http\View;

/**
 * Class Twig
 * @package App\Http\View
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
class Twig
{
    /**
     * @var \Twig_Environment
     */
    private $engine;

    /**
     * @var \Twig_Loader_Filesystem
     */
    private $loader;
    /**
     * Twig constructor.
     */
    public function __construct()
    {
        $templateDir = realpath(__DIR__.'/../../Resources');
        $cacheDir = realpath(__DIR__.'/../../../../public/cache');
        $this->loader = new \Twig_Loader_Filesystem($templateDir);
//        $this->engine = new \Twig_Environment($this->loader, [
//            'cache' => $cacheDir
//        ]);
        $this->engine = new \Twig_Environment($this->loader);
    }

    /**
     * @param string $template
     * @param array $data
     * @return string
     */
    public function render($template, $data = [])
    {
        $template = $this->engine->load($template);
        return $template->render($data);
    }

}