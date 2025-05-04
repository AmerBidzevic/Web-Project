<?php
/**
* @OA\Tag(
*     name="reviews",
*     description="Product reviews"
* )
*/

/**
* @OA\Post(
*     path="/reviews",
*     tags={"reviews"},
*     summary="Create a new product review",
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             required={"user_id", "product_id", "rating"},
*             @OA\Property(property="user_id", type="integer", example=1),
*             @OA\Property(property="product_id", type="integer", example=5),
*             @OA\Property(property="rating", type="integer", minimum=1, maximum=5, example=4),
*             @OA\Property(property="comment", type="string", example="Great product quality!")
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Review created successfully"
*     ),
*     @OA\Response(
*         response=400,
*         description="Invalid rating or missing required fields"
*     )
* )
*/
Flight::route('POST /reviews', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::reviewService()->addReview(
        $data['user_id'],
        $data['product_id'],
        $data['rating'],
        $data['comment'] ?? null
    ));
});

/**
* @OA\Get(
*     path="/products/{product_id}/reviews",
*     tags={"reviews"},
*     summary="Get all reviews for a product",
*     @OA\Parameter(
*         name="product_id",
*         in="path",
*         required=true,
*         description="Product ID to get reviews for",
*         @OA\Schema(type="integer", example=5)
*     ),
*     @OA\Response(
*         response=200,
*         description="List of product reviews"
*     ),
*     @OA\Response(
*         response=404,
*         description="Product not found"
*     )
* )
*/
Flight::route('GET /products/@product_id/reviews', function($productId) {
    Flight::json(Flight::reviewService()->getReviewsByProduct($productId));
});

/**
* @OA\Get(
*     path="/reviews",
*     tags={"reviews"},
*     summary="Get all reviews",
*     @OA\Response(
*         response=200,
*         description="List of all reviews"
*     ),
*     @OA\Response(
*         response=403,
*         description="Admin privileges required"
*     )
* )
*/
Flight::route('GET /reviews', function() {
    Flight::json(Flight::reviewService()->getAllReviews());
});

/**
* @OA\Get(
*     path="/reviews/{id}",
*     tags={"reviews"},
*     summary="Get review by ID",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="Review ID",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Review details"
*     ),
*     @OA\Response(
*         response=404,
*         description="Review not found"
*     )
* )
*/
Flight::route('GET /reviews/@id', function($id) {
    Flight::json(Flight::reviewService()->getReviewById($id));
});

/**
* @OA\Put(
*     path="/reviews/{id}",
*     tags={"reviews"},
*     summary="Update a review",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="Review ID to update",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             @OA\Property(property="rating", type="integer", minimum=1, maximum=5, example=4),
*             @OA\Property(property="comment", type="string", example="Updated review comment")
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Review updated successfully"
*     ),
*     @OA\Response(
*         response=403,
*         description="Can only update your own reviews"
*     )
* )
*/
Flight::route('PUT /reviews/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::reviewService()->updateReview($id, $data));
});

/**
* @OA\Delete(
*     path="/reviews/{id}",
*     tags={"reviews"},
*     summary="Delete a review",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="Review ID to delete",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Review deleted successfully"
*     ),
*     @OA\Response(
*         response=403,
*         description="Can only delete your own reviews"
*     )
* )
*/
Flight::route('DELETE /reviews/@id', function($id) {
    Flight::json(Flight::reviewService()->deleteReview($id));
});
?>