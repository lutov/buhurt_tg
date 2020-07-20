<?php

define('BOT_NAME', 'mybot'); // Without "@"
define('API_KEY', '');
define('SECRET', '');
define('URL', 'https://site.ru/manager.php');
define('ADMINS', array(111));
define('MYSQL', array(
    'host'     => 'localhost',
    'user'     => '',
    'password' => '',
    'database' => '',
));
define('IPS', array(
    '127.0.0.1', // single
    //'192.168.1.0/24', // CIDR
    //'10/8', // CIDR (short)
    //'5.6.*', // wildcard
    //'1.1.1.1-2.2.2.2', // range
));