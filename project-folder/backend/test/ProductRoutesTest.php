<?php
use PHPUnit\Framework\TestCase;
define('PHPUNIT_RUNNING', true);


class ProductRoutesTest extends TestCase {
    public function setUp(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/'; 
        $_SERVER['HTTP_AUTHENTICATION'] = 'Bearer dummy';

        require_once __DIR__ . '/../vendor/autoload.php';
        require_once __DIR__ . '/../index.php';

        Flight::halt(false);
    }

    public function testGetAllProducts()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/products';
        ob_start();
        Flight::start();
        $output = ob_get_clean();

        $this->assertEquals(200, http_response_code());
        $this->assertJson($output);
        $this->assertStringContainsString('"name"', $output);
    }

    public function testGetProductById()
    {
        $testProductId = 1;
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/products/' . $testProductId;
        ob_start();
        Flight::start();
        $output = ob_get_clean();

        $this->assertEquals(200, http_response_code());
        $this->assertJson($output);
        $this->assertStringContainsString('"id":' . $testProductId, $output);
    }
}
