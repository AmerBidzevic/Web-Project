<?php
use PHPUnit\Framework\TestCase;

class ReviewRoutesTest extends TestCase {
    public function setUp(): void
    {
        require_once __DIR__ . '/../vendor/autoload.php';
        require_once __DIR__ . '/../index.php';
        Flight::halt(false);
        Flight::start();
    }

    public function testGetProductReviews()
    {
        $testProductId = 1; 
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/products/' . $testProductId . '/reviews';
        ob_start();
        Flight::start();
        $output = ob_get_clean();
        
        $this->assertEquals(200, http_response_code());
        $this->assertJson($output);
    }

    public function testCreateReview()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/reviews';
        $_SERVER['CONTENT_TYPE'] = 'application/json';
        $_SERVER['HTTP_AUTHENTICATION'] = 'my-valid-thingy-jwt-token'; 
        
        $reviewData = [
            'user_id' => 1,
            'product_id' => 1,
            'rating' => 5,
            'comment' => 'Great product!'
        ];
        
        file_put_contents('php://input', json_encode($reviewData));
        
        ob_start();
        Flight::start();
        $output = ob_get_clean();
        
        $this->assertEquals(200, http_response_code());
        $this->assertJson($output);
    }
}