<?php
/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="Get all users",
 *     @OA\Response(
 *         response=200,
 *         description="List of all users",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="username", type="string", example="Jeff"),
 *                 @OA\Property(property="email", type="string", example="billy@gmail.com")
 *             )
 *         )
 *     )
 * )
 */
Flight::route('GET /users', function() {
    Flight::auth_middleware()->verifyToken();
    Flight::auth_middleware()->authorizeRole('user');

    Flight::json(Flight::userService()->getAllUsers());
});

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Get user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User details",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="username", type="string", example="john_doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
Flight::route('GET /users/@id', function($id) {
    Flight::auth_middleware()->verifyToken();
    Flight::auth_middleware()->authorizeRole('admin');


    $user = Flight::userService()->getUserById($id);
    Flight::json($user);
});

/**
 * @OA\Post(
 *     path="/users",
 *     tags={"users"},
 *     summary="Create a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username", "email", "password"},
 *             @OA\Property(property="username", type="string", example="newuser"),
 *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="simplepassword123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="User created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="username", type="string", example="newuser"),
 *             @OA\Property(property="email", type="string", example="user@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
 *     )
 * )
 */
Flight::route('POST /users', function() {
    $data = Flight::request()->data->getData();
    $user = Flight::userService()->registerUser(
        $data['username'],
        $data['email'],
        $data['password']
    );
    Flight::json($user, 201);
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Update user information",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID to update",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="username", type="string", example="updateduser"),
 *             @OA\Property(property="email", type="string", format="email", example="updated@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User updated")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
 *     )
 * )
 */
Flight::route('PUT /users/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::userService()->updateUser($id, $data);
    Flight::json(['message' => 'User updated']);
});

/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Delete a user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID to delete",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User deleted")
 *         )
 *     )
 * )
 */
Flight::route('DELETE /users/@id', function($id) {
    Flight::auth_middleware()->verifyToken();
    Flight::auth_middleware()->authorizeRole('admin');
    
    Flight::userService()->deleteUser($id);
    Flight::json(['message' => 'User deleted']);
});

/**
 * @OA\Post(
 *     path="/users/login",
 *     tags={"users"},
 *     summary="Simple login check",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="userHUMAN@gmail.com"),
 *             @OA\Property(property="password", type="string", format="password", example="simplepassword123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Login successful"),
 *             @OA\Property(property="user", ref="#/components/schemas/User")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid credentials"
 *     )
 * )
 */
Flight::route('POST /users/login', function() {
    $data = Flight::request()->data->getData();
    $user = Flight::userService()->getUserByEmail($data['email']);
    
    if (!$user || $data['password'] !== $user['password']) { 
        Flight::halt(401, 'Invalid credentials');
    }
    
    unset($user['password']);
    Flight::json([
        'message' => 'Login successful',
        'user' => $user
    ]);
});
?>