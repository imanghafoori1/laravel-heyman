# Laravel Hey Man

A package to make authorization a trivial thing and decoupled from the rest of the application


## Authorization with laravel gates:

First, we define a simple standard laravel Gate like so:

```php
Gate::define('hasRole', function ($user, $role) {
    // we can check any thing we want about the user in a gate
    return ($user->role == $role) ? true : false;
});

```
Nothing new here,

So now we can use this gate to authorize and stop the user in various moments of the application life cycle, including:
- 1- Right after a Route is Matched
- 2- Right before a blade file is going to be rendered. For example by calling: `view('myViewFile');` 
- 3- Right before an eloquent model is going to be `read` or `created` or `updated` or `deleted`
- 4- When any custom event is fired by calling `event('myEvent');`


You can put these codes in your service provider's `boot` method to take effect:

## Hooking on : Routes

```php

// On Url address:
HeyMan::whenYouVisitUrl(['welcome', 'home'])->thisGateShouldAllow('hasRole', 'editor')->otherwise()->weDenyAccess();


// On Route's Name:
HeyMan::whenVisitingRoute('welcome.name')->thisGateShouldAllow('hasRole', 'editor')->otherwise()->weDenyAccess();

```

## Hooking on : Controller Actions

```php
// On Action Name:
HeyMan::whenCallingAction('\App\Http\Controllers\HomeController@index')->thisGateShouldAllow('hasRole', 'editor')->otherwise()->weDenyAccess();

```

*In case the gate returns `false` an `AuthorizationException` will be thrown.
*(If it is not the thing you want, do not worry you can customize the action very easily, we will discuss shortly.)


#### Note You can pass an string or an array of strings


## Hooking on : Blade files


```php 

// to authorize \View::make();   or   view();

 HeyMan::whenViewMake('edit_form')->thisGateShouldAllow('hasRole', 'editor')->otherwise()->weDenyAccess();
 ```
 
This way authorization logic is fired after this line of code is executed:

```php
view('edit_form');
```
so you are putting a guard on the blade file named:`edit_form.blade.php`. (not on the url which eventually leads to it.)


## Hooking on : Custom Events

```php
HeyMan::whenEventHappens('myEvent')->thisGateShouldAllow('hasRole', 'editor')->otherwise()->weDenyAccess();
```

This way gate is checked after `event('myEvent')` is executed any where in our app


## Hooking on : Eloquent Model Events
```php
HeyMan::whenSaving(\App\User::class)->thisGateShouldAllow('hasRole', 'editor')->otherwise()->weDenyAccess();
HeyMan::whenFetching(\App\User::class)->thisGateShouldAllow('hasRole', 'editor')->otherwise()->weDenyAccess();
HeyMan::whenCreating(\App\User::class)->thisGateShouldAllow('hasRole', 'editor')->otherwise()->weDenyAccess();
HeyMan::whenUpdating(\App\User::class)->thisGateShouldAllow('hasRole', 'editor')->otherwise()->weDenyAccess();
HeyMan::whenDeleting(\App\User::class)->thisGateShouldAllow('hasRole', 'editor')->otherwise()->weDenyAccess();
```


## Things You Can Check After Hooking:

### 1 - Checking Gates


#### By gate name:

```php
HeyMan::whenYouVisitUrl('home')->thisGateShouldAllow('hasRole', 'editor')->otherwise()->...;
```

#### Referencing a Method (as a Gate):

```php
HeyMan::whenYouVisitUrl('home')->thisGateShouldAllow('SomeClass@someMethod', 'editor')->otherwise()->...;
```

#### Passing a Closure:

```php
$gate = function($user, $role){
    /// some logic
    return true;
}

HeyMan::whenYouVisitUrl('home')->thisGateShouldAllow($gate, 'editor')->otherwise()->...;
```

### 2 - Checking Authentication:

```php
HeyMan::whenYouVisitUrl('home')->youShouldBeGuest()->otherwise()->...;
HeyMan::whenYouVisitUrl('home')->youShouldBeLoggedIn()->otherwise()->...;
```

### 3 - Checking A Closure: (coming soon)

```php
$callback = function($params){
    /// some logic
    return true;
}
HeyMan::whenYouVisitUrl('home')->thisClosureMustPass($callback, ['param1'])->otherwise()->...;
```


## Things You Can Enforce After Checking:

### 1 - Deny Access

By calling `weDenyAccess` method an `AuthorizationException` will be thrown if needed

```php
HeyMan::whenSaving(\App\User::class)->thisGateShouldAllow('hasRole', 'editor')->otherwise()->weDenyAccess();
```

### 2 - Redirect the user

```php
// Sample sudo Code
HeyMan::whenYouVisitUrl('/login')->youShouldBeGuest()->otherwise() ->redirectTo(...);
HeyMan::whenYouVisitUrl('/login')->youShouldBeGuest()->otherwise() ->redirectToRoute(...);
HeyMan::whenYouVisitUrl('/login')->youShouldBeGuest()->otherwise() ->redirectToAction(...);
HeyMan::whenYouVisitUrl('/login')->youShouldBeGuest()->otherwise() ->redirectToIntended(...);
HeyMan::whenYouVisitUrl('/login')->youShouldBeGuest()->otherwise() ->redirectGuest(...);
```

### 3- Throw new Exception:

As the first argument, you pass the exception class path, and the exception message as the second.

```php
HeyMan::whenYouVisitUrl('/login')->youShouldBeGuest()->otherwise() ->throwNew(AuthorizationException::class, 'My Message');
```

### 4- Abort:

It is exaclty the same as calling the `abort()` laravel helper function.

```php
HeyMan::whenYouVisitUrl('/login')->youShouldBeGuest()->otherwise() ->abort();
```

### 5- Send Json or View as Response:

Calling these functions generate exact same response as calling them on the `response()` helper function like this:
 
`return response()->json(...);`

```php
HeyMan::whenYouVisitUrl('/login')->youShouldBeGuest()->otherwise() ->json(...);
HeyMan::whenYouVisitUrl('/login')->youShouldBeGuest()->otherwise() ->view(...);
HeyMan::whenYouVisitUrl('/login')->youShouldBeGuest()->otherwise() ->jsonp(...);
```

### 6 - Send Any Response Object

```php

$response = response()->make(...);

HeyMan::whenYouVisitUrl('/login')->youShouldBeGuest()->otherwise() ->sned($response);
```
