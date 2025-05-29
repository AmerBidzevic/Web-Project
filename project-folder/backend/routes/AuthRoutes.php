<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::group('/auth', function() {
    /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Register new user",
     *     description="Add a new user to the database",
     *     tags={"auth"},
     *     @OA\RequestBody(
     *         description="User registration data",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"password", "email", "username"},
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="some_password",
     *                     description="User password"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="demo@gmail.com",
     *                     description="User email"
     *                 ),
     *                 @OA\Property(
     *                     property="username",
     *                     type="string",
     *                     example="demo_user",
     *                     description="User's chosen username"
     *                 ),
     *                 @OA\Property(
     *                     property="role",
     *                     type="string",
     *                     example="user",
     *                     description="User role (defaults to 'user')",
     *                     enum={"user", "admin"}
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User registered successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Email, password, and username are required")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unknown error occurred")
     *         )
     *     )
     * )
     */
    Flight::route("POST /register", function () {
    $contentType = Flight::request()->getHeader("Content-Type");
    if (strpos($contentType, "application/json") !== false) {
        $data = json_decode(file_get_contents("php://input"), true);
    } else {
        $data = Flight::request()->data->getData();
    }

    if ($data === null || empty($data)) {
        Flight::halt(400, json_encode(['error' => 'No data received']));
        return;
    }

    if (!isset($data['email']) || !isset($data['password']) || !isset($data['username'])) {
        Flight::halt(400, json_encode(['error' => 'Email, password, and username are required']));
        return;
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        Flight::halt(400, json_encode(['error' => 'Invalid email format']));
        return;
    }

    if (empty($data['username'])) {
        Flight::halt(400, json_encode(['error' => 'Username cannot be empty']));
        return;
    }

    if (!isset($data['role'])) {
        $data['role'] = 'user';  
    }

    $allowedRoles = ['user', 'admin'];
    if (!in_array($data['role'], $allowedRoles)) {
        Flight::halt(400, json_encode(['error' => 'Invalid role']));
        return;
    }

    $response = Flight::auth_service()->register($data);

    if (empty($response) || !isset($response['success'])) {
        Flight::halt(500, json_encode(['error' => 'Unknown error occurred or no response returned from auth service']));
        return;
    }

    if ($response['success']) {
        Flight::json([
            'message' => 'User registered successfully',
            'data' => $response['data']
        ]);
    } else {
        Flight::halt(500, json_encode(['error' => $response['error'] ?? 'Unknown error occurred']));
    }
});

 /**
     * @OA\Post(
     *      path="/auth/login",
     *      tags={"auth"},
     *      summary="Login to system",
     *      description="Authenticate user with email and password",
     *      @OA\RequestBody(
     *          description="User credentials",
     *          required=true,
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"email", "password"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="demo@gmail.com",
     *                     description="User email"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="some_password",
     *                     description="User password"
     *                 )
     *             )
     *          )
     *      ),
     *      @OA\Response(
     *           response=200,
     *           description="Login successful",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Login successful"),
     *               @OA\Property(property="data", type="object")
     *           )
     *      ),
     *      @OA\Response(
     *           response=400,
     *           description="Bad request",
     *           @OA\JsonContent(
     *               @OA\Property(property="error", type="string", example="Email and password are required")
     *           )
     *      ),
     *      @OA\Response(
     *           response=401,
     *           description="Unauthorized",
     *           @OA\JsonContent(
     *               @OA\Property(property="error", type="string", example="Invalid credentials")
     *           )
     *      ),
     *      @OA\Response(
     *           response=500,
     *           description="Internal server error",
     *           @OA\JsonContent(
     *               @OA\Property(property="error", type="string", example="Internal server error")
     *           )
     *      )
     * )
     */
    Flight::route('POST /login', function() {
        try {
            $data = Flight::request()->data->getData();
            
            if (empty($data['email']) || empty($data['password'])) {
                Flight::halt(400, json_encode(['error' => 'Username and password are required']));
                return;
            }

            $response = Flight::auth_service()->login([
                'email' => $data['email'],
                'password' => $data['password']
            ]);

            if ($response['success']) {
                Flight::json([
                    'message' => 'Login successful',
                    'data' => $response['data']
                ]);
            } else {
                Flight::halt(401, json_encode(['error' => $response['error']]));
            }
        } catch (Exception $e) {
            error_log("Login route error: " . $e->getMessage());
            Flight::halt(500, json_encode(['error' => 'Internal server error']));
        }
    });
});

   /**
     * @OA\Post(
     *     path="/auth/register-admin",
     *     summary="Register new admin",
     *     description="Add a new admin user to the database (requires special privileges)",
     *     tags={"auth"},
     *     security={
     *         {"ApiKey": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Admin registration data",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"password", "email", "username"},
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="admin_password",
     *                     description="Admin password"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="admin@gmail.com",
     *                     description="Admin email"
     *                 ),
     *                 @OA\Property(
     *                     property="username",
     *                     type="string",
     *                     example="admin_user",
     *                     description="Admin's username"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Admin registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Admin registered successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Email, password, and username are required")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unknown error occurred")
     *         )
     *     )
     * )
     */


Flight::route("POST /auth/register-admin", function () {
    $contentType = Flight::request()->getHeader("Content-Type");
    if (strpos($contentType, "application/json") !== false) {
        $data = json_decode(file_get_contents("php://input"), true);
    } else {
        $data = Flight::request()->data->getData();
    }

    if ($data === null || empty($data)) {
        Flight::halt(400, json_encode(['error' => 'No data received']));
        return;
    }

    if (!isset($data['email']) || !isset($data['password']) || !isset($data['username'])) {
        Flight::halt(400, json_encode(['error' => 'Email, password, and username are required']));
        return;
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        Flight::halt(400, json_encode(['error' => 'Invalid email format']));
        return;
    }

    $response = Flight::auth_service()->registerAdmin($data);

    if (empty($response) || !isset($response['success'])) {
        Flight::halt(500, json_encode(['error' => 'Unknown error occurred or no response returned from admin registration']));
        return;
    }

    if ($response['success']) {
        Flight::json([
            'message' => 'Admin registered successfully',
            'data' => $response['data']
        ]);
    } else {
        Flight::halt(500, json_encode(['error' => $response['error'] ?? 'Unknown error occurred']));
    }
});