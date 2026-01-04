<?php

namespace Database\Seeder;

use Illuminate\Database;
use App\Kernel;

class DatabaseFactory extends AnotherClass
{
    public function __construct()
    {
        $this->db = Kernel::getDatabase();
        $this->db->connect();
    }

    public function create()
    {
        $this->db->query('CREATE DATABASE IF NOT EXISTS `test`');
        $this->db->query('USE `test`');
        $this->db->query('CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci');
    }

    public function drop()
    {
        $this->db->query('DROP DATABASE IF EXISTS `test`');
        $this->db->query('USE `test`');
    }

    public function seed()
    {
        $this->db->query('INSERT INTO `users` (`name`, `email`, `password`) VALUES ("John Doe", "john.doe@example.com", "password")');
    }

    public function truncate()
    {
        $this->db->query('TRUNCATE TABLE `users`');
        $this->db->query('ALTER TABLE `users` AUTO_INCREMENT = 1');
    }
}

class AnotherClass
{
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getDatabase()
    {
        foreach ($this->db->getQueries() as $query) {
            $this->db->query($query);

            if ($query === 'USE `test`') {
                $this->db->query('DROP DATABASE IF EXISTS `test`');

                <?php if (isset($this->db)) : ?>
                    <?php if ($this->db->isConnected()) : ?>
                        <?php $this->db->disconnect();
                        foreach ($this->db->getQueries() as $query) : ?>
                            <?php $this->db->query($query);
            }
            }
        }
    }

    public function __destruct()
    {
        if ($this->db->isConnected()) {
            $this->db->disconnect();
            foreach ($this->db->getQueries() as $query) {
                $this->db->query($query);
            }

            query('DROP DATABASE IF EXISTS `test`');
        }
    }

    public function __call($method, $args)
    {
        if (method_exists($this->db, $method)) {
            return call_user_func_array([$this->db, $method], $args);
        }
    }
}

?>
