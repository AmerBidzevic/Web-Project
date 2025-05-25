<?php
use PHPUnit\Framework\TestCase;

class AuthRoutesTest extends TestCase {
    public function setUp(): void
    {
        require_once __DIR__ . '/../vendor/autoload.php';
        require_once __DIR__ . '/../index.php';
        Flight::halt(false);
        Flight::start();
    }

    public function testUserRegistration()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/auth/register';
        $_SERVER['CONTENT_TYPE'] = 'application/json';
        
        $testUser = [
            'email' => 'test' . uniqid() . '@example.com',
            'password' => 'testpassword123'
        ];
        
        file_put_contents('php://input', json_encode($testUser));
        
        ob_start();
        Flight::start();
        $output = ob_get_clean();
        
        $this->assertEquals(200, http_response_code());
        $this->assertJson($output);
        $this->assertStringContainsString('User registered successfully', $output);
    }

    public function testUserLogin()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/auth/login';
        $_SERVER['CONTENT_TYPE'] = 'application/json';
        
        $credentials = [
            'email' => 'existing@user.com',
            'password' => 'correctpassword'
        ];
        
        file_put_contents('php://input', json_encode($credentials));
        
        ob_start();
        Flight::start();
        $output = ob_get_clean();
        
        $this->assertEquals(200, http_response_code());
        $this->assertJson($output);
        $this->assertStringContainsString('JWT', $output);
    }
}