<?php
/**
* @OA\Tag(
*     name="transactions",
*     description="Purchase transactions"
* )
*/

/**
* @OA\Post(
*     path="/transactions",
*     tags={"transactions"},
*     summary="Create a new transaction",
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             required={"user_id", "product_id"},
*             @OA\Property(property="user_id", type="integer", example=1),
*             @OA\Property(property="product_id", type="integer", example=5),
*             @OA\Property(property="quantity", type="integer", example=1)
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Transaction created successfully"
*     ),
*     @OA\Response(
*         response=400,
*         description="Invalid product or insufficient stock"
*     )
* )
*/
Flight::route('POST /transactions', function() {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::transactionService()->createTransaction(
        $data['user_id'],
        $data['product_id'],
        $data['quantity'] ?? 1
    ));
});

/**
* @OA\Get(
*     path="/users/{user_id}/transactions",
*     tags={"transactions"},
*     summary="Get all transactions for a user",
*     @OA\Parameter(
*         name="user_id",
*         in="path",
*         required=true,
*         description="User ID to get transactions for",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="List of user transactions"
*     ),
*     @OA\Response(
*         response=404,
*         description="User not found"
*     )
* )
*/
Flight::route('GET /users/@user_id/transactions', function($user_id) {
    Flight::json(Flight::transactionService()->getUserTransactions($user_id));
});

/**
* @OA\Get(
*     path="/transactions",
*     tags={"transactions"},
*     summary="Get all transactions",
*     @OA\Response(
*         response=200,
*         description="List of all transactions"
*     ),
*     @OA\Response(
*         response=403,
*         description="Admin privileges required"
*     )
* )
*/
Flight::route('GET /transactions', function() {
    Flight::json(Flight::transactionService()->getAllTransactions());
});

/**
* @OA\Get(
*     path="/transactions/{id}",
*     tags={"transactions"},
*     summary="Get transaction by ID",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="Transaction ID",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Transaction details"
*     ),
*     @OA\Response(
*         response=404,
*         description="Transaction not found"
*     )
* )
*/
Flight::route('GET /transactions/@id', function($id) {
    Flight::json(Flight::transactionService()->getTransactionById($id));
});

/**
* @OA\Put(
*     path="/transactions/{id}",
*     tags={"transactions"},
*     summary="Update transaction status",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="Transaction ID to update",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             @OA\Property(property="status", type="string", example="completed")
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Transaction updated successfully"
*     ),
*     @OA\Response(
*         response=403,
*         description="Admin privileges required"
*     )
* )
*/
Flight::route('PUT /transactions/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::transactionService()->updateTransaction($id, $data));
});

/**
* @OA\Delete(
*     path="/transactions/{id}",
*     tags={"transactions"},
*     summary="Delete a transaction",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="Transaction ID to delete",
*         @OA\Schema(type="integer", example=1)
*     ),
*     @OA\Response(
*         response=200,
*         description="Transaction deleted successfully"
*     ),
*     @OA\Response(
*         response=403,
*         description="Admin privileges required"
*     )
* )
*/
Flight::route('DELETE /transactions/@id', function($id) {
    Flight::json(Flight::transactionService()->deleteTransaction($id));
});
?>