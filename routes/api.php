    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\v1\BookController as v1BookController;

    Route::apiResource('v1/books', v1BookController::class);

