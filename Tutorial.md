# Getting started with building applications with Laravel

In this tutorial we look at how we can create web applications with Laravel. Using the version 7.x.
To learn more about Laravel we can check out their website [here](https://laravel.com/) and the
documentation [here](https://laravel.com/docs/7.x).

# Things you need

Some of the things you need to get started are:
* Composer
* PHP
* Node

# Installation

To install Laravel we can use composer. You can download composer [here](https://getcomposer.org/download/).

```bash
composer create-project laravel/laravel {directory}
```

Once you run the command above. You can create your application. We ran the command below

```bash
composer create-project laravel/laravel laraveltuts
```

You can view our tutorial [here](https://github.com/wftutorials/laravel-tutorial2) for future reference.

To run your application you can use the command below. This starts the server.

```bash
php artisan serve
```

[running_laravel.png]

This gets your application started.

[laravel_welcome_page.png]

To learn more you can check out the documents [here](https://laravel.com/docs/7.x/installation).


# Hello world

Lets create our common hello world application.
Head to the `web.php` in your `routes` directory. 
This holds all the routes for your application.

Lets create a new route called `helloworld`.

```php
Route::get('/helloworld', function () {
    return "hello world";
});
```

The results are seen below.

[hello_world.png]

# Routing

Routing is how we control where our application goes via the url.
Let see what kind of routes we can create.

Lets create a help route. We made a route like this before.

```php
Route::get('/help', function () {
    return "Help Page";
});
```

Results is shown below.

[help_route]

## Parameters

Lets pass parameters via our url and access it in our route function.

```php
Route::get('/posts/{id}', function ($id) {
    return "Viewing the current post " . $id;
});
```

Let's see how this works.

[route_with_arguments.png]

## Multiple parameters

Let's add more parameters.

```php
Route::get('/notes/{id}/{page}', function ($id, $page) {
    return "View the current note: " . $id . " on the current page:" . $page;
});
```

The results are shown below.

[multiple_parameters.png]

## Using the GET super variable

We can still access the super globals and use it as we see necessary.

```php
Route::get('/book', function () {
    if(isset($_GET['id'])){
        return "Viewing the book via the id " . $_GET['id'];
    }else{
        return  "No book id given";
    }
});
```

The result is shown below.

[route_super_global.png]

## Working with POST routes

We can create a `POST` route and test it with `POSTMAN`.
You can download postman [here](https://www.postman.com/downloads/).

```php
Route::post('/create', function(){
    return "test";
});
```

[post_request.png]

> We need to add an exception in VerifyCsrfToken.php otherwise your request wouldn't work.
>Learn more about that [here](https://laravel.com/docs/7.x/csrf#csrf-x-csrf-token)

## Working with Controller routes

We will get into controllers further but for now we create a `DashboardController.php`.
We create it in the `Http/Controllers` directory.

```php
<?php


namespace App\Http\Controllers;


class DashboardController extends Controller
{
    public function index(){
        return "this is the dashboard controller";
    }
}
```

Now we can reference that function.

```php
Route::get('/dashboard', 'DashboardController@index');
```

So we can test this as shown below.

[dashboard_controller.png]

## Working with redirects

So we can send our users to different routes using redirection.
Lets see how. We create a route called `login`. Then we use `Route::redirect('/here', '/there')`
to send the user from `home` to `login`.

```php
Route::get('/login', function () {
    return "login page";
});


Route::redirect('/home', '/login');
```

The result is shown below.

[testing_redirection.gif]

## Redirecting to another route

Let's try to redirect from a route to another route.
In your `web.php` we add the code below

```php
Route::get('/admin', function () {
    return redirect('/help');
});
```

This means when we head to the `admin` route we should be redirected to the
**help** route.

Let's test this out.

[redirection_from_routes.png]


# Working with Controllers

Let's create a controller. We created one before so let's repeat that.
Head to `app/Http/Controllers` and create a controller called `UsersController.php`
as shown below.

```php
<?php


namespace App\Http\Controllers;


class UsersController extends Controller
{

}
```

Now let's create a function called show.

```php
public function show(){
    return "showing all users";
}
```

Let's add our route in `web.php`.

```php
// Users Routes
Route::get('/users/show', 'UsersController@show');
```

Now we can test the route.

[show_users_route.png]

## Rendering Views

Let's see how we can render a view. Head to the `resoures/views` folder and create a file called
`users.blade.php`.

In this file we place a header `h1` element.

```html
<h1>Showing all users</h1>
```

Now in our `UsersController.php` we return our view as shown below.

```php
public function show(){
    return View("users");
}
```

The results is in the picture below.

[rendering_users_view.png]

## Passing data to our views

Passing data to our views is quite simple. We pass our data as an array as the second argument of your
view function.

In the `UsersController.php` we can see this below

```php
public function show(){
    return View("users",['title'=>'Hello World']);
}
```

Now in our `users.blade.php` we have access to `$title` variable.

```html
<h1>{{ $title  }}</h1>
<p>The title is passed from the controller</p>
```

The result is shown below.

[passing_data.png]

### An alternative way

We can also pass data using the `with` function on the view. Lets see how.

```php
public function show(){
    return View("users")->with('title','Another Hello World');
}
```

This works the same and gives the same results.

# Layouts

We are using `blade` so we can use blade features to manage our layouts. Let's see how and what we can do with 
this.

First we create a new layout. In our `resources/views/layouts` directory. 
We create a file called `main.blade.php` and we add the code below.

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div style="margin: 0 auto; border: 1px solid #ccc; padding:5px;">
    @yield('content')
</div>
</body>
</html>
```

Using `@yield()` is where we can pass content into when we extend views using this layout.
Let's try that. In `users.blade.php` we extend this layout.

```html
@extends('layouts.main')

@section('content')
<h1>{{ $title  }}</h1>
<p>The title is passed from the controller</p>
@endsection
```

Now when we run our app we can see how the page changed.

[extending_layouts.png]

## Working with variables

Let's change the title of the page from our view. 
First in our `main.blade.php` file we try to get the variable using

```html
<title>App Name - @yield('title')</title>
```

So if `title` exits it will show as the title of the page.

Next in our `users.blade.php` layout we create this variable.

```html
@section('title',"My Users")
```

So our title should display **My Users**. Let's see the results below.

[title_in_layout.png]


# Control Structures

Let's try working with some conditionals. We will pass some data and display content based on where it exits
or not.

Let's modify our `UsersController.php`. We update the `show` function like below

```php
public function show(){
    return View("users",['title'=>'Hello World','show'=>false]);
}
```

So we are passing a variable called `show`. It can be either `true` or `false`.
Now in our `users.blade.php` file we check to see if exits.

```html
@section('content')
<h1>{{ $title  }}</h1>
@if($show == true)
    <p>The title is passed from the controller</p>
@endif
@endsection
```

If it is true we will display our `p` element. Currently it is false so our output will be.

[conditionals.png]

## For loops

Lets for fun try out a for loop to see how we can do this. In our `users.blade.php` we add the content
below.

```html
@section('content')
<h1>{{ $title  }}</h1>
@if($show == true)
    <p>The title is passed from the controller</p>
    <ul>
        @for ($i = 0; $i < 10; $i++)
            <li>The current value is item: {{ $i }} </li>
        @endfor
    </ul>
@endif
@endsection
```

The results can be seen below.

[for_loop_example.png]

# Working with the database

First we create our database. For this we use MYSQL workbench.

[creating_database.png]

Now lets head to `config/database.php` in your Laravel app.

[database_configuration.png]

We update our configurations as shown above. 

In our `.env` file we add our database name.

[env_file_sample.png]

Next we create a new function called `test` in our `UsersController.php` and we create a new route for it.

```php
Route::get('/users/test', 'UsersController@test');
```

Now lets get started working with our database. In our `UsersController.php` we want to use the class `DB`.

```php
use Illuminate\Support\Facades\DB;
```

Now we can use the `DB` class. Let's add our `test` function code.

```php
public function test(){
    $users = DB::select('select * from users limit ?', [100]);
    foreach($users as $user){
      echo $user->firstname . " " . $user->lastname . '<br>';
    }
}
```

Using the `DB` class we call select. Then we loop through the results.
We can see what this looks like below.

[list_of_users.png]

## Using the query builder

We can retrieve data from our database using a query builder format. Lets see how below.
Check out this code here

```php
DB::table('users')->get();
```

This gives us the same result that we had before. Check out the full code below

```php
public function test(){
    $users = DB::table('users')->get();
    foreach($users as $user){
      echo $user->firstname . " " . $user->lastname . '<br>';
    }
}
```

This gives us the same result. Well there is not limit. It will pull all your data.

## Find by primary key

Let pull a record by the id.

```php
public function test(){
    $user = DB::table('users')->find(10);
    echo $user->firstname . " " . $user->lastname . '<br>';
}
```

Its that simple.

## Getting the first row

Lets get the first row from a query.

```php
public function test(){
    $user = DB::table('users')->get()->first();
    echo $user->firstname . " " . $user->lastname . '<br>';
}
```

## Using the where query

Lets try to get an email from a user row.

```php
public function test(){
    $email = DB::table('users')->where('firstname', 'Cchaddie')->value('email');
    echo $email . '<br>';
}
```

We can look at the database to understand the data.

[email_users_dataview.png]

There are alot more things you can do. Check out the link [here](https://laravel.com/docs/7.x/queries).


# Migrations

We can create tables via the command line in Laravel using migrations. Lets see how.

First we run the following command.

```bash
php artisan make:migration create_post_table
```

Migrations are saved in the `databasee/migrations` folder.

[creating_migrations.png]

When we enter the file we can create the structure of the table
within in the up function.

```php
public function up()
{
    Schema::create('post', function (Blueprint $table) {
        $table->id();
        $table->string("title");
        $table->string("description");
        $table->string("Category");
        $table->timestamps();
    });
}
```

Above we added a title, description and category to our table. Lets run this to see what happens.

Run the migration using the command

```bash
php artisan migrate
```

This will run any outstanding migrations. 

[post_table_created.png]

Above you can see our created post table.

You can learn more about migrations [here](https://laravel.com/docs/7.x/migrations).

# Working with models

To work with models we use Eloquent. Learn more about eloquent here.
We run the command

```bash
php artisan make:model Post
```

Our model is created in the `app` directory.

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
}
```

We add the table name to avoid conflicts

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = "post";
}
```

## Retreiving data using models

Lets get our posts. In our database we add some random data.

[posts_random_data.png]

Now in our `DashboardController.php` we get all the posts and display it.


```php
class DashboardController extends Controller
{
    public function index(){
        $posts = Post::all();
        foreach($posts as $post){
            echo $post->title ."<br>";
        }
    }
}
```

The results is shown below.

[showing_posts_displayed.png]


Learn more [here](https://laravel.com/docs/7.x/eloquent).

# Working with forms

Lets get started submitting a form. First we go to our `web.php` and add our route.

```php
Route::match(['get', 'post'],'/dashboard/create', 'DashboardController@create');
```

Above we use the `Route::match()` function.

Next we create a view in dashboard called `create.blade.php`.

```html
<h1>Create a new Post</h1>
<form method="POST" action="/dashboard/create">
    @csrf
    Post Title: <input type="text" name="title" /><br><br>
    Post Description: <br><textarea name="description" cols="30" rows="3"></textarea>
    <br><br>

    <button type="submit">Submit</button>
</form>
```

Note our `@csrf` for Cross-Site Request Forgery protection.

In our `DashboardController.php` we add some stuff.

We need to user the `Request` object first.

```php
use Illuminate\Http\Request;
```

Then we can create our function.

```php
public function create(Request $request){
    if($request->isMethod('post')){
        $postTitle = $request->input('title');
        $postDescription = $request->input("description");
        echo $postTitle . "<br>" . $postDescription;
        return false;
    }
    return View("dashboard.create");
}
```


The results is show below.

[submitting_a_form.gif]


Learn more [here](https://laravel.com/docs/7.x/blade#forms).

## Saving using the model

First we update our `Post.php` so we can use it better. We add some cool comments for our
intellsense.

```php
<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $title
 * @property string $description
 * @property string $category
 */
class Post extends Model
{
    //
    protected $table = "post";

    protected $attributes = [

    ];
}
```

The `@property` comments allows us to set our object without getting warning messages in our ide.

Then in our dashboard controller we change the `create` function.

```php
public function create(Request $request){
    if($request->isMethod('post')){
        $post = new Post();
        $post->title = $request->input('title');
        $post->description = $request->input("description");
        $post->category = "general";
        $post->save();
        echo  "POST saved";
        return false;
    }
    return View("dashboard.create");
}
```

Thats it. When we enter information in our form. Our Post should b added to the database.


[entering_form_data.png]

[inserted_in_the_database.png]

Learn more about using models [here](https://laravel.com/docs/7.x/eloquent).

# Working with assets

When working with assets Laravel has a lot of options for us to choose from. But we will kepp it simple.
Head to the public folder and create a file called `primary.css`.

Enter some css into it as shown below.

```css
.header {
    font-size: 20px;
    color:darkblue;
}

.subtitle {
    font-style: italic;
    text-underline: #1b1e21;
    font-weight: bold;
}

```

Now we create a new route to test your style in. 
How route name is `dashboard/home`.

```php
// web.php
Route::get('/dashboard/home', 'DashboardController@home');
```

Create our function

```php
// DashboardController.php

public function home(){
    return View("dashboard.home");
}
```

Now we add our `primary.css` in our `home.blade.php` view.


```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>App Name</title>
    <link href="{{ asset('primary.css') }}" rel="stylesheet" />
</head>
<body>
<div style="margin: 0 auto; border: 1px solid #ccc; padding:5px;">
    <h1 class="header">Welcome to the home page</h1>
    <p class="subtitle">This is the home page</p>
</div>
</body>
</html>
```

Of special mention is this link

```html
<link href="{{ asset('primary.css') }}" rel="stylesheet" />
```

This is how you add an external sytyle cheat. You can create a css folder if you want. Only the path will chnage

```html
<link href="{{ asset('css/primary.css') }}" rel="stylesheet" />
```

The results can be seen below. Our `header` and `subtitle` elements are shown with styling.

[adding_a_stylesheet.png]

## Adding javascript files

Lets try to add javascript files to our app.
In our public folder we create the `main.js` file. We add the code below.

```javascript
window.onload = function() {
    document.getElementById("Save").onclick = function fun() {
        alert("hello");

    }
}
```

Next we create our view called `help.blade.php`.

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>App Name</title>
    <script type="text/javascript" src="{{ asset('main.js') }}"></script>
</head>
<body>
<div style="margin: 0 auto; border: 1px solid #ccc; padding:5px;">
    <h1>Help Page</h1>
    <button id="Save">Button</button>
</div>
</body>
</html>
```

Notice we add our script using the same `asset` function.

Thats all we need we should be good to go. The results is shown below.s

[add_js_assets.gif]


# User authentication

To get started with authentication we use Laravel suggested method.
So we need to run some commands. Learn more [here](https://laravel.com/docs/7.x/authentication).

First we run some composer commands

```bash
composer require laravel/ui

php artisan ui vue --auth
```

Now if we didn't run `npm install` we do this now.

```bash
npm install
```

Then we run the `dev` scripts

```bash
npm run dev
```

Doing all of this adds authentication to our app. When we are complete run the app
and head to `http://127.0.0.1:8000/login`. We will see an awesome login page.

[login_view.png]

## Creating a user

To create a new user lets head to the registration page. Via `http://127.0.0.1:8000/register`.
Enter you new user information

[register_user.png]

Once thats complete we would have created a new user. Lets check the database to see it.

[user_in_database]

## Protected Routes

Lets protect a route. We will user the create a post route.

```php
Route::match(['get', 'post'],'/dashboard/create', 'DashboardController@create')
->middleware('auth');
```

We attach the `auth` middleware to our function. This means you need to be logged in to access this route.

We can see this in action below.

[protecting_a_route.gif]

# Conclusion

Here ends our beginner introduction into the Laravel framework. There is alot more to dive into. 
But we will stop here for now. You should have the basics to get up and running. Be sure to check out
the documents as they are pretty good and that's what I used to guide me.

There are alot more beginner tutorials on this site with awesome pictures. Be sure to check them out.
