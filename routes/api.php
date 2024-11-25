<?php

use App\Http\Controllers\Api\VideoCategoryController;
use App\Http\Controllers\Api\VideoPlaylistController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\GaragePostController;
use App\Http\Controllers\Api\GarageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\DtcController;
use App\Http\Controllers\Api\SlideController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BodyTypeController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ModelController;
use App\Http\Controllers\Api\CourseController;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FileExploreController;
use App\Models\Shop;
use App\Models\Payment;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user_shop', function (Request $request) {
    // Get the authenticated user
    $user = $request->user();

    // Find the shop for the authenticated user
    $shop = Shop::where('id', $user->shop_id)->first();

    // If no shop is found, return an appropriate message or null
    if (!$shop) {
        return response()->json(['message' => 'No shop found for this user'], 404);
    }

    // Return the shop details if found
    return response()->json($shop);
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::resource('dtcs', DtcController::class);
Route::resource('courses', CourseController::class);
Route::resource('slides', SlideController::class);
Route::resource('shops', ShopController::class);
Route::resource('products', ProductController::class);
Route::get('get_products_by_shop/{shop_id}', [ProductController::class, 'getProductsByShop']);
Route::get('related_products/{id}', [ProductController::class, 'relatedProducts']);
Route::get('get_products_by_category/{category_id}', [ProductController::class, 'getProductsByCategory']);
Route::get('get_products_by_body_type/{body_type_id}', [ProductController::class, 'getProductsByBodyType']);
Route::get('get_products_by_brand/{brand_id}', [ProductController::class, 'getProductsByBrand']);
Route::get('get_products_by_model/{model_id}', [ProductController::class, 'getProductsByModel']);
Route::resource('categories', CategoryController::class);
Route::resource('body_types', BodyTypeController::class);
Route::resource('brands', BrandController::class);
Route::resource('models', ModelController::class);
Route::get('get_models_by_brand/{brand_id}', [ModelController::class, 'getModelsByBrand']);


Route::resource('garages', GarageController::class);
Route::resource('garages_posts', GaragePostController::class);
Route::get('get_posts_by_garage/{id}', [GaragePostController::class, "getPostsByGarage"]);

Route::resource('videos_category', VideoCategoryController::class);
Route::get('get_videos_by_category/{id}', [VideoController::class, "getVideosByCategory"]);
Route::resource('videos', VideoController::class);
Route::resource('videos_playlists', VideoPlaylistController::class);


Route::get('/file-explorer', [FileExploreController::class, 'index']);
Route::post('/file-explorer/upload', [FileExploreController::class, 'upload']);
Route::post('/file-explorer/create-folder', [FileExploreController::class, 'createFolder']);
Route::get('/file-explorer/folder/{path}', [FileExploreController::class, 'folder']);
Route::post('/file-explorer/rename', [FileExploreController::class, 'rename']);
Route::delete('/file-explorer/delete', [FileExploreController::class, 'delete']);

 Route::get('/payment', function(){
     $payment = Payment::first();
        return response()->json($payment);
    });


// Routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
   
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/users/{id}', [AuthController::class, 'update']);
    
    Route::post('shops', [ShopController::class, 'store']); 
    Route::post('shops/{id}', [ShopController::class, 'update']); 
    Route::post('products', [ShopController::class, 'storeProduct']);
    Route::post('products/{id}', [ShopController::class, 'updateProduct']);
    Route::get('products/{id}/delete', [ShopController::class, 'deleteProduct']);
    
    Route::post('submit_order_video_playlist', [VideoPlaylistController::class, 'storeOrderVideoPlaylist']);
    Route::get('playlists_user', [VideoPlaylistController::class, 'playlistUser']);
});
