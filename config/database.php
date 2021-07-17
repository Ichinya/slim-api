<?php
$database_config = [
    "driver" => "mysql",
    "host" => "localhost",
    "database" => "slim_api",
    "username" => "user",
    "password" => "pass",
    "charset" => "uft8",
    "collation" => "utf8_unicode_ci",
    "prefix" => ""
];

$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($database_config);
$capsule->setAsGlobal();
$capsule->bootEloquent();

return $capsule;