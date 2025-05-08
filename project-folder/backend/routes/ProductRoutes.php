<?php
/**
* @OA\Tag(
*     name="products",
*     description="Product management"
* )
*/

/**
* @OA\Get(
*     path="/products",
*     tags={"products"},
*     summary="Get all products",
*     security={{"bearerAuth": {}}}, 
*     @OA\Response(
*         response=200,
*         description="List of all available products"
*     )
* )
*/
Flight::route('GET /products', function() {
    Flight::json(Flight::productService()->getAll());
});

/**
* @OA\Get(
*     path="/products/{id}",
*     tags={"products"},
*     summary="Get product details by ID",
*     security={{"bearerAuth": {}}}, 
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="Product ID",
*         @OA\Schema(type="integer", example=5)
*     ),
*     @OA\Response(
*         response=200,
*         description="Product details"
*     ),
*     @OA\Response(
*         response=404,
*         description="Product not found"
*     )
* )
*/
Flight::route('GET /products/@id', function($id) {
    Flight::json(Flight::productService()->getProductById($id));
});

/**
* @OA\Post(
*     path="/products",
*     tags={"products"},
*     summary="Create a new product",
*     security={{"bearerAuth": {}}}, 
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             required={"name", "description", "price", "stock"},
*             @OA\Property(property="name", type="string", example="New Product"),
*             @OA\Property(property="description", type="string", example="Product description"),
*             @OA\Property(property="price", type="number", format="float", example=49.99),
*             @OA\Property(property="stock", type="integer", example=50)
*         )
*     ),
*     @OA\Response(
*         response=201,
*         description="Product created successfully"
*     ),
*     @OA\Response(
*         response=400,
*         description="Invalid input"
*     ),
*     @OA\Response(
*         response=403,
*         description="Admin privileges required"
*     )
* )
*/
Flight::route('POST /products', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::productService()->createProduct($data));
});

/**
* @OA\Put(
*     path="/products/{id}",
*     tags={"products"},
*     summary="Update product information",
*     security={{"bearerAuth": {}}}, 
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="Product ID to update",
*         @OA\Schema(type="integer", example=5)
*     ),
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             @OA\Property(property="name", type="string", example="Updated Name"),
*             @OA\Property(property="description", type="string", example="Updated description"),
*             @OA\Property(property="price", type="number", format="float", example=59.99),
*             @OA\Property(property="stock", type="integer", example=120)
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Product updated successfully"
*     ),
*     @OA\Response(
*         response=403,
*         description="Admin privileges required"
*     )
* )
*/
Flight::route('PUT /products/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::productService()->updateProduct($id, $data));
});

/**
* @OA\Delete(
*     path="/products/{id}",
*     tags={"products"},
*     summary="Delete a product",
*     security={{"bearerAuth": {}}}, 
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="Product ID to delete",
*         @OA\Schema(type="integer", example=5)
*     ),
*     @OA\Response(
*         response=200,
*         description="Product deleted successfully"
*     ),
*     @OA\Response(
*         response=403,
*         description="Admin privileges required"
*     )
* )
*/
Flight::route('DELETE /products/@id', function($id) {
    Flight::json(Flight::productService()->deleteProduct($id));
});


?>
