<?php

namespace Phonebook\Tools;

use Phonebook\Exceptions\InvalidArgumentsException;

/**
 * Class Arguments
 * @package Phonebook\Tools
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
class Arguments
{
    /**
     * @param array $mandatory
     * @param array $data
     */
    public static function validArguments(array $mandatory, array $data)
    {
        foreach ($mandatory as $key) {
            if (!isset($data[$key])) {
                throw new InvalidArgumentsException(sprintf('%s not found.', $key), 401);
            }
            if (is_array($data[$key]) && count($data[$key]) == 0) {
                throw new InvalidArgumentsException(sprintf('%s is empty.', $key), 401);
            }
            if (empty($data[$key])) {
                throw new InvalidArgumentsException(sprintf('%s is empty.', $key), 401);
            }
        }
    }
}