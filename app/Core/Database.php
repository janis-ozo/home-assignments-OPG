<?php
namespace App\Core;

use Medoo\Medoo;

class Database
{
    private $connection;

    public static $instance = null;

    public function __construct()
    {
        if (self::$instance === null) {
            self::$instance = $this;
        }

        $this->connection = new Medoo([
            'database_type' => 'mysql',
            'database_name' => config()->get('database.name'),
            'server' => config()->get('database.host'),
            'username' => config()->get('database.username'),
            'password' => config()->get('database.password')
        ]);
    }

    public static function getInstance(): self
    {
        return self::$instance ?? new Database();
    }

    public function connection()
    {
        return $this->connection;
    }

}