<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AllItemController;
use App\Http\Controllers\Admin\AppIntroController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ModelController;
use App\Http\Controllers\Admin\BodyTypeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DtcController;
use App\Http\Controllers\Admin\GarageController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\VideoController;

/*
|--------------------------------------------------------------------------
*/
// Make storage:link
Route::get('/symlink', function () {
    $target = $_SERVER['DOCUMENT_ROOT'] . '/storage/app/public';
    $link = $_SERVER['DOCUMENT_ROOT'] . '/public/storage';
    symlink($target, $link);
    echo "Done";
});
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\File;

Route::get('/get_resources/{path?}', function ($path = null) {
    // dd($path);
    // Specify the directory path relative to the public folder
    if ($path) {
        $directory = public_path($path);
    } else {
        $directory = public_path();
    }

    // Check if the directory exists
    if (File::isDirectory($directory)) {
        // Get all files in the current directory (excluding subdirectories)
        $files = File::files($directory);

        // Get all directories (subdirectories) in the directory
        $directories = File::directories($directory);

        // Initialize arrays to store file names and folder names
        $fileNames = [];
        $folderNames = [];

        // Iterate through files and store file names
        foreach ($files as $file) {
            $fileNames[] = $file->getFilename();
        }

        // Iterate through directories and store folder names
        foreach ($directories as $dir) {
            $folderNames[] = basename($dir); // Get the base name of the directory
        }

        // Return the list of filenames and folder names as JSON response
        // return response()->json(['files' => $fileNames, 'folders' => $folderNames]);
        return view('view-files', ['files' => $fileNames, 'folders' => $folderNames]);
    } else {
        // Handle case where directory does not exist
        abort(404, 'Directory not found');
    }
})->where('path', '.*');

Route::group([
    'middleware' => 'auth',
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {

    Route::resource('dashboard', DashboardController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('items', ItemController::class);
    Route::resource('allitems', AllItemController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('bodytypes', BodyTypeController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('models', ModelController::class);
    Route::resource('types', TypeController::class);

    Route::resource('settings', SettingsController::class);


    Route::resource('slides', SlideController::class);
    Route::resource('dtcs', DtcController::class);
    Route::resource('shops', ShopController::class);

    Route::resource('products', ProductController::class);
    Route::get('products_images/{id}', function($id){
        return view('admin.products.image', [
            'id' => $id,
        ]);
    });

    Route::resource('appintros', AppIntroController::class);
    Route::resource('garages', GarageController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('videos', VideoController::class);
    Route::get('videos/stream/{video}/{quality}', [VideoController::class, 'stream'])->name('videos.stream');


    Route::get('addmore', function () {
        dd('Add More Route Test Success');
    })->name('addmore');
});



/*
|--------------------------------------------------------------------------
| End Admin Routes
|--------------------------------------------------------------------------
*/















Route::group([
    'middleware' => 'role:super-admin|admin'
], function () {
    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/{id}/delete', [PermissionController::class, 'destroy']);

    Route::resource('roles', RoleController::class);
    Route::get('roles/{id}/delete', [RoleController::class, 'destroy']);
    Route::get('roles/{id}/give-permissions', [RoleController::class, 'givePermissionsToRole']);
    Route::put('roles/{id}/give-permissions', [RoleController::class, 'updatePermissionsToRole']);

    Route::resource('users', UserController::class);
    Route::put('users/{user}/update-password', [UserController::class, 'updateUserPassword']);
    Route::get('users/{user}/delete', [UserController::class, 'destroy']);
});

Route::get('ckeditor4-demo', function () {
    return view('ckeditor-demo.ckeditor4-demo');
})->name('ckeditor4');

Route::get('ckeditor5-demo', function () {
    return view('ckeditor-demo.ckeditor5-demo');
})->name('ckeditor5');

Route::get('slide-infinite-loop', function () {
    return view('slide-show.slide-infinite-loop');
})->name('slide-infinite-loop');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});











Route::get('/', function () {
    // return view('welcome');
    return redirect('admin/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
