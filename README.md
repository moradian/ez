# EZ

* [Introduction](#introduction)
* [Contribution](#contribution)
* [Requirements](#requirements)
* [Basics](#basics)
* [EZ to create new controllers](#ez-to-create-new-controllers)
    * [How to create view for a controller](#how-to-create-view-for-a-controller)
    * [How to use a custom view file for a controller](#how-to-use-a-custom-view-file-for-a-controller)
    * [How to pass variables/objects from controllers to views](#how-to-pass-variablesobjects-from-controllers-to-views)
    * [Mapping controllers to URIs](#mapping-controllers-to-uris)
* [Creating a template](#creating-a-template)
* [EZ to access the request](#ez-to-access-the-request)
* [EZ to access your database](#ez-to-access-your-database)

---

## Introduction
EZ is an open source web development framework, targeted for PHP programmers. EZ is not another reinvented wheel.
One major philosophy of EZ is that if a utility class or a component has already been developed by a well maintainable
open source project, we will NOT redevelop it. We will use that instead. The mindset that leaded to the creation of EZ
is to create an easy to use web development framework.

## Requirements
The new namespace feature introduced in PHP 5.3 is heavily utilized in EZ.
This feature is what caused Zend Framework team to make the big move from ZF1.x to ZF2 and also Doctrine 1.2.x to
Doctrine 2. If you are a PHP developer and you still are not familiar with PHP namespaces, I strongly recommend
reading about [this feature](http://php.net/manual/en/language.namespaces.php) of PHP.

## Contribution
If you are interested in working on EZ I will be more than happy to hear from you.

## Basics
EZ is another implementation of an MVC web development framework. To learn the basics of using EZ, keep the
followings in mind.

* Controllers are placed in the "controllers" directory
* Views are placed in the "views" directory
* Models and libraries be placed in the "library" directory
* All client-side resources are placed in the "client" directory (nothing outside of the "client" is exposed to web users)
* Configs are placed in the "configs" directory

Pretty straight forward, huh? Could it be EZer?

## EZ to create new controllers
The checklist to create a new controller is:

(Let's create an example controller to handle new user registrations at the URL "/users/register" )

1. Create a new directory named "Users" in the "controllers" directory.
2. Create a PHP file in the "Users" directory from step 1 and name it "Register.php"
3. Code the class inside the "Register.php" file

```
namespace Users;

class UserController extends \Ez\Controller\AbstractController
{
}
```

As you may have noticed

1. Controller class names MUST be postfixed with "_Controller_".
2. Controller class names MUST be matched case, not camel cased.
3. All controllers MUST be extended from the `\Ez\Controller\AbstractController` class.

That's it. You're almost done. To code your logic in your new controller you need to implement 2 methods that
`\Ez\Controller\AbstractController` enforces you to implement.

1. The `run` method. This method is where the execution of your controller starts.
2. The `postRun` method. This method is the very last piece of code that gets executed by EZ before firing
response to the client.

To sum it up, your final controller looks like:

```
namespace Users;

class UserController extends \Ez\Controller\AbstractController
{
  public function run()
  {
    // YOUR LOGIC, YOUR CREATIVITY!
  }
  
  public function postRun()
  {
    // CLEANING UP
  }
}
```

### How to create view for a controller
To create default view files for your controllers, you need to create a PHP file in the "views" directory and
name it using the following convention.

1. _Replace backslashes in the full qualified name of controllers with dots._
2. _Remove the "Controller" from the end of the result of step1._
3. _The name of all view files should be lowercase._

Example:

The full qualified name of the controller that serves the homepage of your web application is `Home\IndexController`.
So to create the view file for the homepage controller all you gotta do is to create a new PHP file in the "views"
directory and name it "home.index.php".

As you can see I have replaced back slashes of `Home\IndexController` with dots, which resulted to
"Home.IndexController" (step 1). Removed "Controller" from end of the result of step 1 which produced "Home.Index" and
finally turned everything to lowercase "home.index".

### How to use a custom view file for a controller
If you wish to share a view file among different controllers, you don't have to recreate the view with different names
for each controller. The workaround is to tell your controllers to use a custom view file instead of the default one.
Well this is how you tell your controllers to use a custom view file.

`$this->getView()->setContentFile( "view.file.name.without.php.extension" )`

### How to pass variables/objects from controllers to views
Let's say you want to pass `$date = new \DateTime()` to the view of your controller.

`$this->view->whatever = $date;`

You may be wondering how you can access it in the view file. Well it's EZ.

`$this->whatever`

Wasn't it? For an actual example have a look at the `Home\IndexController` which is the controller of the
homepage and its view file which is named "home.index.php"

### Mapping controllers to URIs
This is pretty straight forward. Replace backslashes in the fully qualified names of controller classes with
forward slashes, lowercase them, rip "Controller" from the end and you're looking at the URI.

Let's say you have a controller named `Client\Profile\EditController`. This controller will serve requests for
http://yourdomain/client/profile/edit

## Creating a template
It's as EZ as 1, 2

1. Create a PHP file in the "templates" directory.
2. Code your HTML template and place `<?php include_once PATH_TO_VIEWS . $this->getContentFile(); ?>`
wherever you want your content (actual view) to be placed.

For more help have a look at the _SampleTemplate.php_ template.

## EZ to access the request
`\Ez\Request` class gives you all you need. The key note to mention about this class is that it's a singleton one.
So to access a user input in the request object you need to call one of the following methods:

* `\Ez\Request::getInstance()->getPost("key")` if you want to access a user input in $_POST
* `\Ez\Request::getInstance()->getQuery("key")` if you want to access a user input in $_GET
* `\Ez\Request::getInstance()->getParam("key")` if you don't care about the request type and just
want to get the user input.

This class is the source to use in case you want to know anything about the request made to your application.
Let it be

* The name of the responsible controller to serve the request
* User inputs
* Type of request
* Uploaded files

You can even populate an entity object from the request. Amazing! Isn't it?

---
## EZ to access your database
EZ uses doctrine at its heart to access databases. In case you are not familiar with Doctrine,
you will soon find out that it is one of the best PHP ORM libraries out there. And the good news
is that it's open source with a huge and active community. Interested in doctrine?
[Read more](http://www.doctrine-project.org)

To access the built-in instance of doctrine entity manager to access your database from your controller,
model or utility classes or simply from any possible place in your project, all you need to do is to call
`\Ez\Registry::getDoctrineEntityManager()`


