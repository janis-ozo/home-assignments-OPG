<?php

use App\Core\Config\ConfigManager;
use App\Core\Database;

use Medoo\Medoo;

function database(): Medoo
{
    return Database::getInstance()->connection();
}

function config(): ConfigManager
{
    return new \App\Core\Config\DatabaseConfig();
}

