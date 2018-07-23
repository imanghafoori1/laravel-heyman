# Laravel Hey Man

## A package to help you write expressive, defensive code in a functional manner

![image](https://user-images.githubusercontent.com/6961695/43092242-c26b141a-8ec1-11e8-8108-4e0cc63d0522.png)

## And it works !!!

[![code coverage](https://codecov.io/gh/imanghafoori1/laravel-heyman/branch/master/graph/badge.svg)](https://codecov.io/gh/imanghafoori1/laravel-heyman)
[![Maintainability](https://api.codeclimate.com/v1/badges/9d6be7b057103cb14410/maintainability)](https://codeclimate.com/github/imanghafoori1/laravel-heyman/maintainability)
<a href="https://scrutinizer-ci.com/g/imanghafoori1/laravel-heyman"><img src="https://img.shields.io/scrutinizer/g/imanghafoori1/laravel-heyman.svg?style=round-square" alt="Quality Score"></img></a>
[![Build Status](https://travis-ci.org/imanghafoori1/laravel-heyman.svg?branch=master)](https://travis-ci.org/imanghafoori1/laravel-heyman)
[![StyleCI](https://github.styleci.io/repos/139709518/shield?branch=master)](https://github.styleci.io/repos/139709518)
[![Latest Stable Version](https://poser.pugx.org/imanghafoori/laravel-heyman/v/stable)](https://packagist.org/packages/imanghafoori/laravel-heyman)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=round-square)](LICENSE.md)



```

composer require imanghafoori/laravel-heyman

```



Imagine your boss comes to you and says :

### Hey man,
### When you go to login form, You should be guest,
### Otherwise you must get redirected to '/panel',
###  Write the code for me, just now

and you write code like this to implement what your boss wanted.


```php


HeyMan::whenYouMakeView('auth.login')->youShouldBeGuest()->otherwise()->redirect('/panel');


```


### That is what this package does for you + a lot more things...



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


You can put these codes in `AuthServiceProvider.php` (or any other service provider) `boot` method to take effect:

## Watching Urls

```php
HeyMan::whenYouVisitUrl(['/welcome', '/home'])->...
HeyMan::whenYouVisitUrl( '/welcome', '/home' )->...
HeyMan::whenYouVisitUrl('/admin/articles/*')->...
```
The input can be `string`, `Array` or `variable number of string inputs`.


## Watching Routes

```php
HeyMan::whenYouVisitRoute('welcome.name')->...
HeyMan::whenYouVisitRoute('welcome.*')->...
```


## Watching Controller Actions

```php
HeyMan::whenYouCallAction('HomeController@index')->...
HeyMan::whenYouCallAction('HomeController@*')->...

```

*In case the gate returns `false` an `AuthorizationException` will be thrown.
*(If it is not the thing you want, do not worry you can customize the action very easily, we will discuss shortly.)


#### Note You can pass an string or an array of strings


## Watching Blade files

`View::make()` or `view()` also fire events behind the scenes when they are called. so we can watch them.

```php 
 HeyMan::whenYouMakeView('article.editForm')->...
 HeyMan::whenYouMakeView('article.*')->...
 ```
 
So you are putting a guard on the blade file named:`article/editForm.blade.php`. (not on the url which eventually leads to it.)


## Watching Custom Events

```php
HeyMan::whenEventHappens('myEvent')->thisGateShouldAllow('hasRole', 'editor')->otherwise()->...
```

This way gate is checked after `event('myEvent')` is executed any where in our app


## Watching Eloquent Model Events
```php
HeyMan::whenYouSave(\App\User::class)->...
HeyMan::whenYouFetch(\App\User::class)->...
HeyMan::whenYouCreate(\App\User::class)->...
HeyMan::whenYouUpdate(\App\User::class)->...
HeyMan::whenYouDelete(\App\User::class)->...
```


## What should be checked:

### 1 - Checking Gates


#### By gate name:

```php
HeyMan::whenYouVisitUrl('/home')->thisGateShouldAllow('hasRole', 'editor')->otherwise()->...;
```

#### Referencing a Method (as a Gate):

```php
HeyMan::whenYouVisitUrl('/home')->thisGateShouldAllow('SomeClass@someMethod', 'editor')->otherwise()->...;
```

#### Passing a Closure (as a Gate):

```php
$gate = function($user, $role){
    /// some logic
    return true;
}

HeyMan::whenYouVisitUrl('/home')->thisGateShouldAllow($gate, 'editor')->otherwise()->...;
```

### 2 - Checking Authentication:

```php
HeyMan::whenYouVisitUrl('/home')->youShouldBeGuest()->otherwise()->...;
HeyMan::whenYouVisitUrl('/home')->youShouldBeLoggedIn()->otherwise()->...;
```

### 3 - Checking A Closure:

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
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirectTo(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirectToRoute(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirectToAction(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirectToIntended(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirectGuest(...);
```

### 3- Throw new Exception:

As the first argument, you pass the exception's class path and the exception message as the second.

```php

$exceptionType = AuthorizationException::class;
$msg = 'My Message';

HeyMan::whenYouVisitUrl('/login')->youShouldBeGuest()->otherwise()->throwNew($exceptionType, $msg);
```

### 4- Abort:

It is exaclty the same as calling the `abort()` laravel helper function.

```php
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->abort(...);
```

### 5- Send Json or View as Response:

Calling these functions generate exact same response as calling them on the `response()` helper function like this:
 
`return response()->json(...);`

```php
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->json(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->view(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->jsonp(...);
```
