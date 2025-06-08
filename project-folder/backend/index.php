<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, Authentication"); 
header("Access-Control-Expose-Headers: Authentication"); 

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require 'vendor/autoload.php';

require_once __DIR__ . '/services/ProductsService.php';
require_once __DIR__ . '/services/UsersService.php';
require_once __DIR__ . '/services/ReviewsService.php';
require_once __DIR__ . '/services/TransactionsService.php';
require_once __DIR__ . '/services/AdministratorsService.php';
require_once __DIR__ . '/services/AuthService.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


Flight::register('productService', 'ProductsService');
Flight::register('userService', 'UsersService');
Flight::register('reviewService', 'ReviewsService');
Flight::register('transactionService', 'TransactionsService');
Flight::register('adminService', 'AdministratorsService');
Flight::register('auth_service', 'AuthService');
Flight::register('auth_middleware', 'AuthMiddleware');

Flight::route('/*', function() {
    if(
        strpos(Flight::request()->url, '/auth/login') === 0 ||
        strpos(Flight::request()->url, '/auth/register') === 0 ||
        strpos(Flight::request()->url, '/products') === 0 ||
        strpos(Flight::request()->url, '/products/featured') === 0 ||
        strpos(Flight::request()->url, '/products/recent') === 0
        
    ) {
        return TRUE;
    } else {
        try {
            $token = Flight::request()->getHeader("Authentication");
            if(Flight::auth_middleware()->verifyToken($token))
                return TRUE;
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
 });
 

require_once __DIR__ . '/routes/ProductRoutes.php';
require_once __DIR__ . '/routes/UserRoutes.php';
require_once __DIR__ . '/routes/ReviewRoutes.php';
require_once __DIR__ . '/routes/TransactionRoutes.php';
require_once __DIR__ . '/routes/AdminRoutes.php';
require_once __DIR__ . '/routes/AuthRoutes.php';

Flight::route("/", function () {
    echo 'Hello world!';
});

Flight::start();
