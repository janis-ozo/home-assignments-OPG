<?php

namespace App\Core\Config;

class DatabaseConfig implements \App\Core\Config\ConfigManager
{
    public function get(string $name): ?string
    {
        $config = [
            'database.host' => 'localhost',
            'database.name' => 'testdb',
            'database.username' => 'janisozolkaja',
            'database.password' => 'default555',
        ];

        return $config[$name] ?? null;
    }
}
