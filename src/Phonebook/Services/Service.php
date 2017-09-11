<?php


namespace Phonebook\Services;

use Phonebook\Exceptions\InvalidArgumentsException;

/**
 * Class Service
 * @package Phonebook\Services
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
abstract class Service
{
    /**
     * @param array $mandatory
     * @param array $data
     */
    protected function validArguments(array $mandatory, array $data)
    {
        foreach ($mandatory as $key) {
            if (!isset($data[$key])) {
                throw new InvalidArgumentsException(sprintf('%s not found.', $key), 401);
            }
            if (empty($data[$key])) {
                throw new InvalidArgumentsException(sprintf('%s is empty.', $key), 401);
            }
        }
    }
}