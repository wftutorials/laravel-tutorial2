# Getting started with building applications with Laravel

In this tutorial we look at how we can create web applications with Laravel.
To learn more about Laravel we can check out their website [here](https://laravel.com/).

# Things you need

Some of the things you need to get started are:
* Composer
* PHP
* XAMPP maybe but not required.

# Installation

To install Laravel we can use composer

```bash
composer create-project laravel/laravel {directory}
```

Once you run the command above. You can crate your application. We ran the command below

```bash
composer create-project laravel/laravel laraveltuts
```

You can view our tutorial [here](https://github.com/wftutorials/laravel-tutorial2).

To run your application you can use the command below

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

Lets create a new route called `helloworld`.

```php
Route::get('/helloworld', function () {
    return "hello world";
});
```

The results as seen below.

[hello_world.png]

# Routing

Routing is how we control where our application goes. Let see what kind of routes we can create.

Lets create a help route. We made a route like this before.

```php
Route::get('/help', function () {
    return "Help Page";
});
```

Results is shown below.

[help_route]

## Parameters

Lets pass parameters via our url to our route function.

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

The results is shown below.

[multiple_parameters.png]

## Using the GET super variable

We can still access the super global and use it as we see necessary.

```php
Route::get('/book', function () {
    if(isset($_GET['id'])){
        return "Viewing the book via the id " . $_GET['id'];
    }else{
        return  "No book id given";
    }
});
```

The results is shown below.

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

We will get into controller further but for now we create a `DashboardController.php`.
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

So we can test this.

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

The results is shown below.

[testing_redirection.gif]

## Redirecting to another route

Let's try to redirect from a route to another route.
In your `web.php` we add the below

```php
Route::get('/admin', function () {
    return redirect('/help');
});
```

This means when we head to the admin route we should be redirected to the
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

Lets see how we can render a view. head to the `resoures/views` folder and create a file called
`users.blade.php`.

In this file we place a `h1` element.

```html
<h1>Showing all users</h1>
```

Now in our `UsersController.php` we return our view.

```php
public function show(){
    return View("users");
}
```

The results.

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

Now in our `users.blade.php` we have access to `$title`.

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




