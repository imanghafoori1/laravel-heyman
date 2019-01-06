# Laravel Hey Man


![image](https://user-images.githubusercontent.com/6961695/43285148-4d86673e-9133-11e8-9415-2df017906762.png)

### Readability Counts. In fact, Readability is the primary value of your code !!!

<a href="https://scrutinizer-ci.com/g/imanghafoori1/laravel-heyman"><img src="https://img.shields.io/scrutinizer/g/imanghafoori1/laravel-heyman.svg?style=round-square" alt="Quality Score"></img></a>
[![code coverage](https://codecov.io/gh/imanghafoori1/laravel-heyman/branch/master/graph/badge.svg)](https://codecov.io/gh/imanghafoori1/laravel-heyman)
[![Maintainability](https://api.codeclimate.com/v1/badges/9d6be7b057103cb14410/maintainability)](https://codeclimate.com/github/imanghafoori1/laravel-heyman/maintainability)
[![Build Status](https://travis-ci.org/imanghafoori1/laravel-heyman.svg?branch=master)](https://travis-ci.org/imanghafoori1/laravel-heyman)
[![Code Coverage](https://scrutinizer-ci.com/g/imanghafoori1/laravel-heyman/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/imanghafoori1/laravel-heyman/?branch=master)
[![StyleCI](https://github.styleci.io/repos/139709518/shield?branch=master)](https://github.styleci.io/repos/139709518)
[![Latest Stable Version](https://poser.pugx.org/imanghafoori/laravel-heyman/v/stable)](https://packagist.org/packages/imanghafoori/laravel-heyman)
[![Daily Downloads](https://poser.pugx.org/imanghafoori/laravel-heyman/d/daily)](https://packagist.org/packages/imanghafoori/laravel-heyman)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=round-square)](LICENSE.md)



## :ribbon: Heyman continues where the other role-permission packages left off :ribbon:

## We have used CDD (Creativity Driven Development) along side the TDD

### Built with :heart: for every smart laravel developer

and it is very well tested, optimized and production ready !

In fact, We have tackled a lot of `complexity` behind the scenes, to provide you with a lot of `simplicity`.

- Integrated with laravel-debugbar package out of the box:

https://github.com/barryvdh/laravel-debugbar


### Installation

```

composer require imanghafoori/laravel-heyman

```

### Requirements:


- PHP v7.0 or above
- Laravel v5.1 or above


## Example : 

Here you can see a good example at :

https://github.com/imanghafoori1/council

Specially this file:

https://github.com/imanghafoori1/council/blob/master/app/Providers/AuthServiceProvider.php


This is fork from result of laracasts.com tutorial series refactored to use the Heyman package.


## Heyman, let's fight off zombies





<img align="right" src="https://user-images.githubusercontent.com/6961695/45443957-64cc3e00-b6db-11e8-9768-163e47f5a46c.jpg" width="160px">


<p align="right">
   Zombie Http Request =>
 </p>

<img align="left" src="https://user-images.githubusercontent.com/6961695/45444536-f7b9a800-b6dc-11e8-84c2-2b0eb224afdb.jpg" width="130px">

#

<br>

 <= Laravel Heyman   



<br>


<br>

<br>

<br>

### A story :

Imagine your boss comes to you and says :

```
 Hey man !!!
 
 When you visit the login form,
 
 You should be guest,
 
 Otherwise you get redirected to '/panel',
```

> Write the code for me, just now... But KEEP IN MIND you are not allowed to touch the current code. it is very sensitive and we do not want you to tamper with it. You may break it.



And you write code like this in a Service Provider `boot` method to implement what your boss wanted.


![image](https://user-images.githubusercontent.com/6961695/43285559-8c09a1e6-9134-11e8-841b-2dc933456082.png)


### That is what this package does for you + a lot more...


### Structural Benefits:

1 - This way you can fully `decouple` authorization and a lot of guarding code from the rest of your application code and put it in an other place. So your Controllers and Routes become less crowded and you will have a central place where you limit the access of users to your application or perform Request validation.


2 - In fact, when you write your code in the way, you are conforming to the famous "`Tell don't ask principle.`"

You are telling the framework what to do in certain situations rather than getting information and decide what to do then.


> ` Procedural code gets information then makes decisions.
>   Object-oriented code tells objects to do things.
> — Alec Sharp `


3 - This approach is paticularly useful when you for example write a package which needs ACL but you want to allow your package users to override and apply they own ACL (or validation) rules into your package routes...

And that becomes possible when you use laravel-HeyMan for ACL. The users can easily cancel out the default rules and re-write their favorite acl or validation stuff in a regular ServiceProviders.

HeyMan, that is Amazing stuff !!! 

```php

// This is written in package and lives in vendor folder, So we can not touch it.
HeyMan::whenYouHitRouteName('myPackageRoute')->youShouldHaveRole(....; 

```


 To override that we use the `forget` method, within `app/Providers/...` : 
 
```php

public function boot() {
  
  // Cancels out the current rules
   HeyMan::forget()->aboutRoute('myPackageRoute');
  
  
   // Add new rules by package user.
   HeyMan::whenYouHitRouteName('myPackageRoute')-> ... 
   
}
```


#### Hey Man, Should I Momorize all the Methods ?! 

You do not need any cheat sheet.

> IDE `Auto-completion` is fully supported.

![refactor5](https://user-images.githubusercontent.com/6961695/43903677-320db906-9c02-11e8-9f2a-ca5a85f6839d.gif)

#### Hey Man, Where do I put these `Heyman::` calls ?

> You may put them in `AuthServiceProvider.php` (or any other service provider) `boot` method.


![image](https://user-images.githubusercontent.com/6961695/43330086-66d0b9a2-91d7-11e8-84fb-fa4ff90821a3.png)


## Usage:

You should call the following method of the HeyMan Facade class.

```php
use Imanghafoori\HeyMan\Facades\HeyMan;
// or
use HeyMan;  // <--- alias
```

Again we recommend visiting this link for examples:

https://github.com/imanghafoori1/council/blob/master/app/Providers/AuthServiceProvider.php



## Situations :

```php
HeyMan::  (situation) ->   (condition)   -> otherwise() -> (reaction) ;
```


#### 1 - Url is matched

```php
HeyMan::whenYouVisitUrl(['/welcome', '/home'])->...   // you can pass an Array
HeyMan::whenYouVisitUrl('/admin/*')->...     // or match by wildcard
```

```php
HeyMan::whenYouSendPost('/article/store')->   ...   
HeyMan::whenYouSendPatch('/article/edit')->  ...  
HeyMan::whenYouSendPut('/article/edit')->    ...     
HeyMan::whenYouSendDelete('/article/delete')-> ...
```

#### 2 - Route Name is matched

```php
HeyMan::whenYouHitRouteName('welcome.name')->...              // For route names
HeyMan::whenYouHitRouteName('welcome.*')->...                 // or match by wildcard
```


#### 3 - Controller Action is about to Call

```php
HeyMan::whenYouCallAction('HomeController@index')->...
HeyMan::whenYouCallAction('HomeController@*')->...          // or match by wildcard
```

#### 4 - A View file is about to render

```php 
 HeyMan::whenYouMakeView('article.editForm')->...     // also accepts an array
 HeyMan::whenYouMakeView('article.*')->...            // You can watch a group of views
 ```
 
 Actually it refers to the moment when `view('article.editForm')` is executed.
 
 #### 5 - Custom Event is Fired

```php
HeyMan::whenEventHappens('myEvent')->...
```

Actually it refers to the moment when `event('myEvent')` is executed.


#### 6 - An Eloquent Model is about to save
```php
HeyMan::whenYouSave(\App\User::class)->...
HeyMan::whenYouFetch(\App\User::class)->...
HeyMan::whenYouCreate(\App\User::class)->...
HeyMan::whenYouUpdate(\App\User::class)->...
HeyMan::whenYouDelete(\App\User::class)->...
```
 
 Actually it refers to the moment when eloquent fires it's internal events like: (saving, deleting, creating, ...)
 
 #### Note that the saving model is passed to the Gate of callback in the next chain call. so for example you can check the ID of the model which is saving.




## Conditions:

```php
HeyMan::  (situation) ->   (condition)   -> otherwise() -> (reaction) ;
```

After considering situations it is time to check some conditions

#### 1 - Gates

```php

// define Gate
Gate::define('hasRole', function(){...});

```

Then you can use the gate:

```php

HeyMan::whenYouVisitUrl('/home')->thisGateShouldAllow('hasRole', 'editor')->otherwise()->...;

```

Passing a Closure as a Gate:

```php
$gate = function($user, $role) {
    /// some logic
    return true;
}
HeyMan::whenYouVisitUrl('/home')->thisGateShouldAllow($gate, 'editor')->otherwise()->...;
```

#### 2 - Authentication stuff:
```php
HeyMan::whenYouVisitUrl('/home')->  youShouldBeGuest()    ->otherwise()->...;
HeyMan::whenYouVisitUrl('/home')->  youShouldBeLoggedIn() ->otherwise()->...;
```

#### 3 - Checking A `Closure` or `Method` or `Value`:
```php
HeyMan::whenYouVisitUrl('home')->thisMethodShouldAllow('someClass@someMethod', ['param1'])->otherwise()->...;
HeyMan::whenYouVisitUrl('home')->thisClosureShouldAllow( function($a) { ... }, ['param1'] )  ->otherwise()->...;
HeyMan::whenYouVisitUrl('home')->thisValueShouldAllow( $someValue )->otherwise()->...;
```

#### 4- Validate Requests:
```php
HeyMan::whenYouHitRouteName('articles.store')->yourRequestShouldBeValid([
    'title' => 'required', 'body' => 'required',
]);
```

You can also modify the data before validation by calling `beforeValidationModifyData()`.

```php

$modifier = function ($data) {
  // removes "@" character from the "name" before validation.
  $data['name'] = str_replace('@', '', $data['name']);
  return $data;
}

HeyMan::whenYouHitRouteName('welcome.name')
        ->yourRequestShouldBeValid(['name' => 'required'])
        ->beforeValidationModifyData($modifier);
```

#### 5- Check points:

You can also declare some check points some where, within your application code:

```php

HeyMan::checkPoint('MyLane');

```

And put some rules for it

```php

HeyMan::whenYouReachCheckPoint('MyLane')->youShouldHaveRole('Zombie')-> ...

```


```
HeyMan::whenYouVisitUrl('home')->always()-> ...
HeyMan::whenYouVisitUrl('home')->sessionShouldHave('key1')->...
```


#### Other things:

You can also use one of these:
```
HeyMan::whenYouVisitUrl('home')->always()-> ...
HeyMan::whenYouVisitUrl('home')->sessionShouldHave('key1')->...
```

--------------------


#### Define your own conditions : 

You can extend the conditions and introduce new methods into heyman API like this:


```php

// Place this code:
// In the `boot` method of your service providers

HeyMan::condition('youShouldBeMan', function () {
   return function () {
       return auth()->user() && auth()->user()->gender === 'Man';
   };
});

// or 

HeyMan::condition('youShouldBeMan', '\App\SomeWhere\SomeClass@someMethod');

```
Then you can use it like this:

```php

HeyMan::whenYouVisitUrl('home')->youShouldBeMan()-> ...

```
Nice, isn't it ?!



## Reactions:


```php
HeyMan::  (situation) ->   (condition)   -> otherwise() -> (reaction) ;
```

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
In fact the redirect method here is very much like the laravel's `redirect()` helper function.

### 3- Throw Exception:
```php
$msg = 'My Message';

HeyMan::whenYouVisitUrl('/login')
    ->youShouldBeGuest()
    ->otherwise()
    ->weThrowNew(AuthorizationException::class, $msg);
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

### 6- Send custom response:

```php
HeyMan::whenYouVisitUrl('/login')-> 
       ...
      ->otherwise()
      ->weRespondFrom('\App\Http\Responses\Authentication@guestsOnly');
```

```php
namespace App\Http\Responses;

class Authentication
{
    public function guestsOnly()
    {
        if (request()->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}

```

Hey man, You see ? we have just an Http response here. So our controllers are free to handle the right situaltions and do not worry about exceptional ones.


## More Advanced Reactions:

Hey man, You may want to call some method or fire an event right before you send the response back.
You can do so by `afterCalling()` and `afterFiringEvent()` methods.

```php
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->afterFiringEvent('explode')->response()->json(...);
HeyMan::whenYouVisitUrl('/login')-> ... ->otherwise()->afterCalling('someclass@method1')->response()->json(...);
```

### Disabling Heyman:

You can disable HeyMan chacks like this (useful while testing): 

![untitled](https://user-images.githubusercontent.com/6961695/43585840-53aae034-967b-11e8-8503-2c1de7a35e9f.png)

```php

HeyMan::turnOff()->eloquentChecks();

...
/// You may save some eloquent models here...
/// without limitations from HeyMan rules.
...

HeyMan::turnOn()->eloquentChecks();

```
--------------------

### :raising_hand: Contributing 
If you find an issue, or have a better way to do something, feel free to open an issue or a pull request.
If you use laravel-heyman in your open source project, create a pull request to provide it's url as a sample application in the README.md file. 


### :exclamation: Security
If you discover any security related issues, please email imanghafoori1@gmail.com instead of using the issue tracker.


### :star: Your Stars Make Us Do More :star:
As always if you found this package useful and you want to encourage us to maintain and work on it. Just press the star button to declare your willing.



### More packages from the author of heyman:


### Laravel Widgetize

 :gem: A minimal yet powerful package to give a better structure and caching opportunity for your laravel apps.

- https://github.com/imanghafoori1/laravel-widgetize


------------

### Laravel Terminator

 :gem: A minimal yet powerful package to give you opportunity to refactor your controllers.

- https://github.com/imanghafoori1/laravel-terminator


------------

### Laravel AnyPass

:gem: It allows you login with any password in local environment only.

- https://github.com/imanghafoori1/laravel-anypass
