<?php

namespace App;

/**
 * Class Config
 * @package Phonebook
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
final class Config
{
    /**
     * @var array
     */
    private static $loadedFiles = [];

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->loadFile('database');
    }

    /**
     * @param string $filename
     */
    public function loadFile($filename)
    {
        if (isset(static::$loadedFiles[$filename])) {
            return ;
        }
        $path = realpath(__DIR__ . '/../../app/config');
        if (!file_exists($path . '/' . $filename . '.php')) {
            return ;
        }
        $file = require $path . '/' . $filename. '.php';
        static::$loadedFiles[$filename] = $file;
    }

    /**
     * @param string $filename
     * @param string $key
     * @return mixed
     */
    public function get($filename, $key)
    {
        if (!isset(static::$loadedFiles[$filename])) {
            return null;
        }
        if (!isset(static::$loadedFiles[$filename][$key])) {
            return null;
        }
        return static::$loadedFiles[$filename][$key];
    }
}