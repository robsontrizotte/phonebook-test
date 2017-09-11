<?php
namespace Phonebook;

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

    private static $map = [
        'contact.manager' => ContactManager::class,
        'contact.repository' => Repositories\MySQL\ContactRepository::class
    ];

    private static $dependency = [
        'contact.manager' => [
            'contact.repository'
        ]
    ];

    /**
     * @param string $id
     * @return mixed
     */
    public static function get($id)
    {
        $id = strtolower($id);
        if (!isset(static::$map[$id])) {
            return null;
        }
        if (isset(static::$instantiatedMap[$id])) {
            return static::$instantiatedMap[$id];
        }
        return static::instantiate($id);
    }

    /**
     * @param string $id
     * @return object
     */
    private static function instantiate($id)
    {
        $dependencies = [];
        $class = static::$map[$id];
        if (isset(static::$dependency[$id])) {
            foreach (static::$dependency[$id] as $dependency) {
                $dependencies[] = static::get($dependency);
            }
        }
        $reflection = new ReflectionClass($class);
        if (count($dependencies)) {
            $instance = $reflection->newInstanceArgs($dependencies);
        } else {
            $instance = $reflection->newInstance();
        }
        static::$instantiatedMap[$id] = $instance;
        return $instance;
    }

    /**
     * @return ContactManager
     */
    public static function getContactManager()
    {
        return static::get('contact.manager');
    }
}