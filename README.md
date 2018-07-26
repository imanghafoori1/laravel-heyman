# Laravel Hey Man

## A package to help you write expressive code in a functional manner

![image](https://user-images.githubusercontent.com/6961695/43285148-4d86673e-9133-11e8-9415-2df017906762.png)

## And it works !!!

<a href="https://scrutinizer-ci.com/g/imanghafoori1/laravel-heyman"><img src="https://img.shields.io/scrutinizer/g/imanghafoori1/laravel-heyman.svg?style=round-square" alt="Quality Score"></img></a>
[![code coverage](https://codecov.io/gh/imanghafoori1/laravel-heyman/branch/master/graph/badge.svg)](https://codecov.io/gh/imanghafoori1/laravel-heyman)
[![Maintainability](https://api.codeclimate.com/v1/badges/9d6be7b057103cb14410/maintainability)](https://codeclimate.com/github/imanghafoori1/laravel-heyman/maintainability)
[![Build Status](https://travis-ci.org/imanghafoori1/laravel-heyman.svg?branch=master)](https://travis-ci.org/imanghafoori1/laravel-heyman)
[![StyleCI](https://github.styleci.io/repos/139709518/shield?branch=master)](https://github.styleci.io/repos/139709518)
[![Latest Stable Version](https://poser.pugx.org/imanghafoori/laravel-heyman/v/stable)](https://packagist.org/packages/imanghafoori/laravel-heyman)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=round-square)](LICENSE.md)



## Installation

```

composer require imanghafoori/laravel-heyman

```



Imagine your boss comes to you and says :

### Hey man,
### When you go to login form, You should be guest,
### Otherwise you must get redirected to '/panel',
###  Write the code for me, just now

and you write code like this to implement what your boss wanted.


![image](https://user-images.githubusercontent.com/6961695/43285311-cca1f178-9133-11e8-94a2-c03178eee3b9.png)


### That is what this package does for you + a lot more things...


You can put these codes in `AuthServiceProvider.php` (or any other service provider) `boot` method to take effect.

## Watching Urls

```php
HeyMan::whenYouVisitUrl(['/welcome', '/home'])->...   // you can pass an Array
HeyMan::whenYouVisitUrl( '/welcome', '/home' )->...   // variable number of args
HeyMan::whenYouVisitUrl('/admin/articles/*')->...     // or match by wildcard
```


## Watching Route Names

```php
HeyMan::whenYouVisitRoute('welcome.name')->...
HeyMan::whenYouVisitRoute('welcome.*')->...                 // or match by wildcard
```


## Watching Controller Actions

```php
HeyMan::whenYouCallAction('HomeController@index')->...
HeyMan::whenYouCallAction('HomeController@*')->...          // or match by wildcard
```

## Watching Blade files
```php 
 HeyMan::whenYouMakeView('article.editForm')->...     // also accepts an array
 HeyMan::whenYouMakeView('article.*')->...            // You can watch a group of views
 ```
 
 ## Watching Custom Events
```php
HeyMan::whenEventHappens('myEvent')->...
```

## Watching Eloquent Model Events
```php
HeyMan::whenYouSave(\App\User::class)->...
HeyMan::whenYouFetch(\App\User::class)->...
HeyMan::whenYouCreate(\App\User::class)->...
HeyMan::whenYouUpdate(\App\User::class)->...
HeyMan::whenYouDelete(\App\User::class)->...
```
 
 #### Note that the saving model is passed to the Gate of callback in the next chain call. so for example you can check the ID of the model which is saving.
 
*In case the gate returns `false` an `AuthorizationException` will be thrown.
*(If it is not the thing you want, do not worry you can customize the action very easily, we will discuss shortly.)


This way gate is checked after `event('myEvent')` is executed any where in our app





## What can be checked:

### 1 - Gates

```php
HeyMan::whenYouVisitUrl('/home')->thisGateShouldAllow('hasRole', 'param1')->otherwise()->...;
HeyMan::whenYouVisitUrl('/home')->thisGateShouldAllow('SomeClass@someMethod', 'param1')->otherwise()->...;
```

Passing a Closure as a Gate:

```php
$gate = function($user, $role){
    /// some logic
    return true;
}
HeyMan::whenYouVisitUrl('/home')->thisGateShouldAllow($gate, 'editor')->otherwise()->...;
```

### 2 - Authentication stuff:
```php
HeyMan::whenYouVisitUrl('/home')->  youShouldBeGuest()    ->otherwise()->...;
HeyMan::whenYouVisitUrl('/home')->  youShouldBeLoggedIn() ->otherwise()->...;
```

### 3 - Checking A `Closure` or `Method` or `Value`:
```php
HeyMan::whenYouVisitUrl('home')->thisMethodShouldAllow('someClass@someMethod', ['param1'])->otherwise()->...;
HeyMan::whenYouVisitUrl('home')->thisClosureShouldAllow(ّ function($a) { ... }, ['param1'])  ->otherwise()->...;
HeyMan::whenYouVisitUrl('home')->thisValueShouldAllow(ّ $someValue )->otherwise()->...;
```

### Other
You can also use one of these:
```
youShouldAlways()-> ...
sessionShouldHave()->...

```

--------------------


## Reactions:

### 1 - Deny Access
```php
HeyMan::whenSaving(\App\User::class)->thisGateShouldAllow('hasRole', 'editor')->otherwise()->weDenyAccess();
```
An `AuthorizationException` will be thrown if needed


### 2 - Redirect
```php
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirect()->to(...)     ->with([...]);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirect()->route(...)  ->withErrors(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirect()->action(...) ->withInput(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirect()->intended(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->redirect()->guest(...);
```

### 3- Throw Exception:
```php
$msg = 'My Message';

HeyMan::whenYouVisitUrl('/login')
    ->youShouldBeGuest()
    ->otherwise()
    ->throwNew(AuthorizationException::class, $msg);
```

### 4- Abort:
```php
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->abort(...);
```

### 5- Send Response:
Calling these functions generate exact same response as calling them on the `response()` helper function:
`return response()->json(...);`

```php
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->response()->json(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->response()->view(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->response()->jsonp(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->response()->make(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->response()->download(...);
```

## Advanced Usage:

You may want to call some method or fire an event right before you send the response back.
You can do so by `afterCalling()` and `afterFiringEvent()` methods.

```php
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->afterFiringEvent('explode')->response()->json(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->afterCalling('someclass@method1')->response()->json(...);
```
