<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\crudController;
use App\http\Controllers\postController;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;
use App\Models\Role;
use App\Models\Country;
use App\Models\Photos;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/post/example', array('as'=>'admin.home', function(){
    \route('admin.home');
    return view('welcome');
}));


Route::get('/post/{id}', [crudController::class, 'index']);

Route::get('/homepage.php', function (){
    return view('Laravel/homepage');
});

Route::get('/login.php', function(){
    return view('Laravel/login');
});

Route::resource('crud', crudController::class);
Route::get('/contact/{id}', [crudController::class, 'contact']);
Route::get('login/{name}/{age}/{password}', [crudController::class, 'login']);
Route::get('posts/{username}', [postController::class, 'index']);
Route::get('/form', function (){
    return view('form');
});
Route::post('/result/{fname}/{lname}', [postController::class, 'form']);
Route::get('/contact', [postController::class, 'list']);

Route::get('shoestore/insert', function (){
    DB::insert('insert into store(Brand, Shoe_Name, Shoe_size , Price) values (?, ?, ?, ?)', ['Clarks', 'Clarks sandal', 42, 150]);
    return "Insert successful";
});
Route::get('shoestore/read', function(){
    $results = DB::select('select * from store where id = ?', [1]);
    foreach($results as $values) {
        return $values->Shoe_Name;
    }
});
Route::get('shoestore/update', function (){
    $updated = DB::update('update store set Shoe_Name="Nike Air max" where id= ?', [1]);
    return $updated;
});
Route::get('shoestore/delete', function (){
    $delete = DB::delete('delete from store where id in (?, ?, ?)', [8, 9, 10]);
    return "Delete successful";
});
Route::get('eloquent/read', function (){
    $posts = Post::all();
    foreach ($posts as $post){
        return $post->Shoe_Name;

    }
});
Route::get('eloquent/findwhere', function (){
    $posts = Post::whereIn('id', [3, 4, 5, 6])->orderBy('id', 'desc')->get();
    return $posts;
});
// Eloquent Insert
Route::get('eloquent/basicinsert', function (){
    $store = new Post;

    $store->Brand = 'Adidas';
//    $store->user_id = '001';
    $store->Price = 200;
    $store->Shoe_Name = 'Adidas Slipper';
    $store->Shoe_size = 45;

    $store->save();
    return "Insert successful";
});
// Eloquent update.

Route::get('eloquent/basicupdate', function (){
    $store = Post::find(8);

//    $store->user_id = 4;
    $store->Brand = 'Addidas 8';
    $store->Price = 250;
    $store->Shoe_Name = 'Addidas Slippers';
    $store->Shoe_size = 40;

    $store->save();
    return "Update successful";
});

Route::get('eloquent/create', function (){
    Post::create(['Brand'=>'Adidas 16', 'Price'=>230, 'Shoe_Name'=>'Adidas Shoe', 'Shoe_size'=>44]);
    return 'Insert successfuly';
});

// Eloquent Update method
Route::get('eloquent/update', function (){

   Post::where('id', 5)->where('Shoe_size', 40)->update(['Brand'=>'Sebago', 'Price'=>250, 'Shoe_Name'=>'Sebago Shoe', 'Shoe_size'=>38]);

});

// Eloquent delete
Route::get('eloquent/destroy', function (){
   Post::destroy([12, 13]);
    return 'Delete succesfully';
});

Route::get('eloquent/delete', function (){

    $store = Post::find(6);
    $store->delete();
    return 'Delete succesfully';

});
Route::get('eloquent/delete2', function (){
    Post::where('id', 4)->delete();
    return 'Delete succesfully';
});
Route::get('eloquent/softdelete', function (){
   Post::whereIn('id', [5, 7, 11])->delete();

});
Route::get('eloquent/trashread', function (){

//    $store = Post::onlyTrashed()->get();
//    return $store;

        $store = Post::withTrashed()->get();
        return $store;
});
Route::get('eloquent/restore', function(){
    Post::onlyTrashed()->restore();
    return 'Success';
});
Route::get('eloquent/forcedelete', function (){
   Post::onlyTrashed()->forceDelete();
   return 'Success';
});
Route::get('eloquent/user/insert', function (){
   User::create(['name'=>'Adebayo Abdulmalik', 'email'=>'milikiadbay@gmail.com', 'password'=>'maleekbaryor07', 'country_id'=>2]);
    return 'Success';
});

// One to one relationship
Route::get('user/{id}/post', function ($id){
   return User::find($id)->store->Shoe_Name;
});
// Reverse one to one relationship
Route::get('post/{id}/user', function ($id){
   return Post::find($id)->user->name;
});
// one to many relationship
Route::get('/shoesizes', function (){
   $user = User::find(1);
   foreach ($user->stores as $store){
       echo $store->Shoe_size . "<br>";
   }
});
Route::get('roles/insert', function (){
    $roles = new Role;
        $roles->name = 'Subscriber';
        $roles->save();
        return "Insert Successful";
});
Route::get('role_user/insert', function (){
    DB::insert('insert into role_user(user_id, role_id) values(?,?)', [2, 2]);
    return 'Success';
});
Route::get('/role_user', function (){
    $user = User::find(3);
    foreach ($user->roles as $role){
        return $role->name;
    }
});
Route::get('user_role',function (){
    $role = Role::find(2);
    foreach ($role->users as $user){
        return $user->name;
    }
});
// Accessing the intermediate table / pivot table
Route::get('user/pivot', function (){
   $user = User::find(1);
   foreach ($user->roles as $role){
       return $role->pivot->created_at;
   }
});
Route::get('photos/insert', function (){
    $photo = new Photos;

    $photo->path = 'abdulmalik.jpg';
    $photo->imageable_id = 1;
    $photo->imageable_type = 'Post::class';

    $photo->save();
    return 'Insert Successfully';
});
Route::get('countries/insert', function (){
    $country = new Country;

    $country->name = 'Nigeria';
    $country->save();
    return "Insert successful";
});
Route::get('user/update', function (){
    $user = User::find(3);
    $user->country_id = 5;

    $user->save();
    return 'Update successful';
});
# Has many through relationship
Route::get('user/country', function (){
   $country = Country::find(1);
   foreach ($country->stores as $store){
       return $store->Brand;
   };
});

// Polymorphic Relation
Route::get('poly/posts/photos', function (){
    $user = User::find(1);
    foreach ($user->photos as $photo){
        return $photo;
    }
});

// Polymorphic Relation: Inverse
Route::get('photo/{id}/post', function ($id){
    $photo = Photos::findOrFail($id);
    return $photo->imageable;
});



