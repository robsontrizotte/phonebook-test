<?php

namespace Phonebook\Repositories\MySQL;

use App\Config;
use Phonebook\Exceptions\ConnectionDatabaseException;

/**
 * Class Repository
 * @package Phonebook\Repositories\MySQL
 * @author Robson Trizotte <robson.trizotte@gmail.com>
 */
abstract class Repository
{
    /**
     * @var \PDO
     */
    protected $connection;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var array
     */
    private $settings;

    /**
     * Repository constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->loadSettings();
        $this->connect();
    }

    /**
     * Connect to database
     */
    protected function connect()
    {
        try {
            $this->connection = new \PDO($this->getDsn(), $this->settings['user'], $this->settings['password']);
        } catch (\PDOException $e) {
            throw new ConnectionDatabaseException($e->getMessage(), 500, $e);
        }
    }

    /**
     * Load database configs
     */
    private function loadSettings()
    {
        $this->settings = $this->config->get('database', 'mysql');
        if (is_null($this->settings)) {
            throw new \RuntimeException('Database settings not found.', 500);
        }

        if (!isset($this->settings['user']) || !isset($this->settings['password']) ||
                !isset($this->settings['host']) || !isset($this->settings['dbname'])) {
            throw new \RuntimeException('Database settings is invalid.', 500);
        }
    }

    /**
     *
     */
    private function getDsn()
    {
        return sprintf(
            'mysql:host=%s;dbname=%s',
            $this->settings['host'],
            $this->settings['dbname']
        );
    }



}
