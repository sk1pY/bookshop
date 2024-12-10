    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\v1\BookController as v1BookController;

    //BOOKS
    Route::apiResource('v1/books', v1BookController::class);
    Route::get('v1/books/{book}/commentaries', [v1BookController::class, 'commentaries']);
    //STOCK BOOKS
    Route::get('v1/stock/{book}',[v1BookController::class,'stock'])->name('books.stock');

    //AUTHORS
    Route::get('v1/authors', [\App\Http\Controllers\Api\v1\AuthorController::class, 'index'])->name('authors.index');
    Route::get('v1/authors/{author}', [\App\Http\Controllers\Api\v1\AuthorController::class, 'show'])->name('authors.show');

    //CATEGORIES
    Route::get('v1/categories', [\App\Http\Controllers\Api\v1\CategoryController::class, 'index'])->name('categories.index');
    Route::get('v1/categories/{category}', [\App\Http\Controllers\Api\v1\CategoryController::class, 'show'])->name('categories.show');

    //COMMENTARIES


