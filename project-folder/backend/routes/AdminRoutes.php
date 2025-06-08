<?php
/**
* @OA\Tag(
*     name="admins",
*     description="Admin management"
* )
*/

/**
* @OA\Post(
*     path="/admins",
*     tags={"admins"},
*     summary="Create a new admin user",
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             required={"user_id"},
*             @OA\Property(property="user_id", type="integer", example=1)
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Admin created successfully"
*     ),
*     @OA\Response(
*         response=403,
*         description="Forbidden - only existing admins can create new admins"
*     )
* )
*/
Flight::route('POST /admins', function() {
    Flight::auth_middleware()->verifyToken();
    Flight::auth_middleware()->authorizeRole('admin');

    $data = Flight::request()->data->getData();
    Flight::json(Flight::adminService()->createAdmin($data['user_id']));
});

/**
* @OA\Delete(
*     path="/admins/{id}",
*     tags={"admins"},
*     summary="Remove admin privileges from a user",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="ID of the admin to remove",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Admin privileges removed successfully"
*     ),
*     @OA\Response(
*         response=404,
*         description="Admin not found"
*     )
* )
*/
Flight::route('DELETE /admins/@id', function($id) {
        Flight::auth_middleware()->verifyToken();
    Flight::auth_middleware()->authorizeRole('admin');

    Flight::json(Flight::adminService()->deleteAdmin($id));
});

/**
* @OA\Get(
*     path="/admins",
*     tags={"admins"},
*     summary="Get all admin users",
*     @OA\Response(
*         response=200,
*         description="List of all admins"
*     ),
*     @OA\Response(
*         response=403,
*         description="Admin privileges required"
*     )
* )
*/
Flight::route('GET /admins', function() {
    Flight::auth_middleware()->verifyToken();
    Flight::auth_middleware()->authorizeRole('admin');


    Flight::json(Flight::adminService()->getAll());
});

/**
* @OA\Get(
*     path="/admins/{id}",
*     tags={"admins"},
*     summary="Get admin by ID",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="Admin ID",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Admin details"
*     ),
*     @OA\Response(
*         response=404,
*         description="Admin not found"
*     )
* )
*/
Flight::route('GET /admins/@id', function($id) {
    Flight::auth_middleware()->verifyToken();
    Flight::auth_middleware()->authorizeRole('admin');

    Flight::json(Flight::adminService()->getAdminById($id));
});

/**
* @OA\Put(
*     path="/admins/{id}",
*     tags={"admins"},
*     summary="Update admin information",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="Admin ID to update",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             @OA\Property(property="role", type="string", example="super_admin"),
*             @OA\Property(property="permissions", type="string", example="users:manage,products:manage")
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Admin updated successfully"
*     ),
*     @OA\Response(
*         response=403,
*         description="Super admin privileges required"
*     )
* )
*/
Flight::route('PUT /admins/@id', function($id) {
    Flight::auth_middleware()->verifyToken();
    Flight::auth_middleware()->authorizeRole('admin');

    $data = Flight::request()->data->getData();
    Flight::json(Flight::adminService()->updateAdmin($id, $data));
});
?>