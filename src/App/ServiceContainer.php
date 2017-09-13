<?php

namespace App;

use App\Http\View\Twig;
use Phonebook\Repositories\MySQL\ContactRepository;
use Phonebook\Services\ContactManager;

/**
 * Class ServiceContainer
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
final class ServiceContainer
{
    /**
     * @var array
     */
    private static $instantiatedMap = [];

    private $map = [
        'config' => Config::class,
        'contact.manager' => ContactManager::class,
        'contact.repository' => ContactRepository::class,
        'view' => Twig::class
    ];

    private $dependency = [
        'contact.manager' => [
            'contact.repository'
        ],
        'contact.repository' => [
            'config'
        ]
    ];

    /**
     * @param string $id
     * @return mixed
     */
    public function get($id)
    {
        $id = strtolower($id);
        if (!isset($this->map[$id])) {
            return null;
        }
        if (isset(static::$instantiatedMap[$id])) {
            return static::$instantiatedMap[$id];
        }
        return $this->instantiate($id);
    }

    /**
     * @param string $id
     * @return object
     */
    private function instantiate($id)
    {
        $dependencies = [];
        $class = $this->map[$id];
        if (isset($this->dependency[$id])) {
            foreach ($this->dependency[$id] as $dependency) {
                $dependencies[] = $this->get($dependency);
            }
        }
        $reflection = new \ReflectionClass($class);
        if (count($dependencies)) {
            $instance = $reflection->newInstanceArgs($dependencies);
        } else {
            $instance = $reflection->newInstance();
        }
        static::$instantiatedMap[$id] = $instance;
        return $instance;
    }
}