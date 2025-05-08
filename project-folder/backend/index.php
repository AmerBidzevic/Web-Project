<?php
require 'vendor/autoload.php';

require_once __DIR__ . '\services\ProductsService.php';
require_once __DIR__ . '\services\UsersService.php';
require_once __DIR__ . '\services\ReviewsService.php';
require_once __DIR__ . '\services\TransactionsService.php';
require_once __DIR__ . '\services\AdministratorsService.php';

Flight::register('productService', 'ProductsService');
Flight::register('userService', 'UsersService');
Flight::register('reviewService', 'ReviewsService');
Flight::register('transactionService', 'TransactionsService');
Flight::register('adminService', 'AdministratorsService');

require_once __DIR__ . '\routes\ProductRoutes.php';
require_once __DIR__ . '\routes\UserRoutes.php';
require_once __DIR__ . '\routes\ReviewRoutes.php';
require_once __DIR__ . '\routes\TransactionRoutes.php';
require_once __DIR__ . '\routes\AdminRoutes.php';

Flight::route("/", function() {
    echo 'Hello world!';
});

Flight::start();
?>