##EZ to create new controllers
The checklist to create a new controller is:

(Let's do an example. Let's create a new controller to handle new user registrations at the URL "/users/register" )

1. Create a new directory named "Users" in the "controllers" directory.
2. Create a PHP file in the "Users" directory from step 1 and name it "Register.php"
3. Code the class inside the "Register.php" file

```
namespace Users;

class UserController extends \Ez\Controller\AbstractController
{
}
```

As you may have found out

1. Controller class names MUST be postfixed with "Controller".
2. Controller class names MUST be matched case, not camel cased.
3. All controllers MUST be extended from the `\Ez\Controller\AbstractController` class.

That's it your're almost done. To code your logic in your new controller you need to implement 2 methods that `\Ez\Controller\AbstractController` enforces you to implement.

1. The run method. This method is where the execution of your controller starts.
2. The postRun method. This method is the very last piece of code that gets executed by EZ before firing response to the client.

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
  }
}
```
---
##EZ to access the your database
To access the built-in instance of doctrine entity manager to access your database from your controller, model or utility classes or simply from any possible place in your project, all you need to do is to call `\Ez\Registry::getDoctrineEntityManager()`

In case you are not familiar with Doctrine, you will soon find out that it is one of the best PHP ORM libraries out there. And the good news is that it's open source with a huge and active community. Interested in doctrine? [Read more](http://www.doctrine-project.org)
