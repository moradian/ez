#ez
####Easy to create a new controller
To create a new controller, create a new class file in the "controllers" directory and name the class file "XYZ.php" and code a class in that file named XYZController and make it extend `\Ez\Controller\AbstractController`
Example:
Let's say we want to create a registration page and the URI of the page will be /users/register
To make it happen create a directory named "Users" in the "controllers" directory and add a new php file named "Register.php"
We're half done. Next code the structure of the class as the following.

`namespace Users;

class RegisterContoller extends \Ez\Controller\AbstractController
{
  public function __construct()
  {
  
  }
  
  public function run()
  {
  
  }
  
  public function postRun()
  {
  
  }
}
`


####Easy to access the your database
To get the instance of built-in doctrine entity manager you can call the following line from your controllers and models.
`\Ez\Registry::getDoctrineEntityManager()`

