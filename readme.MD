
# Slim Auryn Invoker

[![Build Status](https://travis-ci.org/Danack/SlimAurynInvoker.svg?branch=master)](https://travis-ci.org/Danack/SlimAurynInvoker)

This library allows you to use the [Auryn Dependency Injection](https://github.com/rdlowrey/auryn) library as the dispatching layer of a [Slim Framework](https://www.slimframework.com/) application. 

It replaces the built-in dispatcher that executes the callables for routes, and instead executes the callables through Auryn.

It does not affect the dispatching of middlewares.


## Why you should use this library

There are two main reasons to use Auryn as the tool that executes your controllers in your application; it allows you to use interface segregation for passing in parameters, as well   



### Inteface segregation for parameters

@todo - explain why interface segration is so awesome for controllers.

I have a talk that I have given at a couple of user groups and PHPNW - [https://www.youtube.com/watch?v=YKXfOYTBaI4](https://www.youtube.com/watch?v=YKXfOYTBaI4) for which the slides are available [here](http://docs.basereality.com/InterfaceSegregationPHPNW/#/). 


### Simple typed return values

I pretty strongly believe that most of the time, it should be left to the framework to connect up a 'stub response' from a controller to the underlying library that will be used to actually send it to a user.

The SlimAurynInvoker allows you to return a 'stub response' object that consists of just the status code, body and a set of headers that the controller wishes to send as the response. The library 

This makes life much more pleasant. Compare two equivalent controllers. The first controller directly modifies the Response object.

```
function psr7JsonController(Request $request, Response $response)
{
    $data = ['foo' => 'bar'];
    $json = json_encode($data);

    $response->getBody()
      ->write($json)
      ->withHeader('Content-type', 'application/json');
      return $response;
}
```

The second controller simply returns a stub JsonResponse.

```
function simpleJsonController(Request $request, Response $response)
{
    $data = ['foo' => 'bar'];

    return new JsonResponse($data);
}
```

By returning a stub response object, it not only remove a lot of tedious, fiddly code from your controllers, but also makes it easier to:

* Understand what type of data the controller is returning.
* Manage the details of which headers are sent for which response type in one place, rather than having to alter every controller that returns that type.
* Test your controllers are returning the correct data type.

## Running the example

There is a simple example app in the example folder, which can be run by using PHP's built-in webserver. You can run it by running this:

```
php -S 0.0.0.0:8000 -t example/public
```

in the root directory of this library, and then going to http://127.0.0.1:8000/ in your browser.


## Notes

### How to run the unit tests

php vendor/bin/phpunit -c test/phpunit.xml

### How to run the code style check

php vendor/bin/phpcs --standard=./test/codesniffer.xml --encoding=utf-8 --extensions=php -p -s lib



