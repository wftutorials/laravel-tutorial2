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
