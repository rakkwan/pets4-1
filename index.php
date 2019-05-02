<?php
/**
 * Created by PhpStorm.
 * User: jrakk
 * Date: 4/8/2019
 * Time: 2:16 PM
 */

    // Start seesion
    session_start();

    // Turn on error reporting
    ini_set('display_error', 1);
    error_reporting(E_ALL);

    //require autoload file
    require_once ('vendor/autoload.php');

    // create an instance of the base class
    $f3 = Base::instance();

    // Turn on Fat-free error reporting
    $f3->set('DEBUG', 3);

    $f3->set('colors', array('pink', 'green', 'blue'));

    // require validation file
    require_once('model/validation-functions.php');

    // define a default route
    $f3->route('GET /@pet', function($f3, $param)
    {
        $pet = $param['pet'];
        echo "<h1>$pet</h1>";

        switch ($pet)
        {
            case 'dog':
                echo "<h3>Woof</h3>";
                break;
            case 'chicken':
                echo "<h3>Cluck</h3>";
                break;
            case 'cat':
                echo "<h3>Meow</h3>";
                break;
            case 'horse':
                echo "<h3>Neigh</h3>";
                break;
            case 'cow':
                echo "<h3>Moo</h3>";
                break;
            default:
                $f3->error(404);
        }
    });

    $f3->route('GET /', function()
    {
        echo "<h1>My pets</h1>";
        echo "<a href='order'>Order a Pet</a>";
    });

    $f3->route('GET|POST /order', function($f3)
    {
        $_SESSION = array();

        if(isset($_POST['animal']))
        {
            $animal = $_POST['animal'];
            if(validString($animal))
            {
                $_SESSION['animal'] = $animal;

                $f3->reroute('/order2');
            }
            else
            {
                $f3->set("errors['animal']", "Please enter an animal.");
                $f3->set("previousAnimal", $animal);
            }
        }

        if(isset($_POST['qty']))
        {
            $qty = $_POST['qty'];
            if(validQty($qty))
            {
                $_SESSION['qty'] = $qty;

                $f3->reroute('/order2');
            }
            else
            {
                $f3->set("errors['qty']", "Quantity must be larger than 0");
                $f3->set("previousQty", $qty);
            }
        }



        $view = new Template();
        echo $view->render("views/form1.html");
    });

    $f3->route('GET|POST /order2', function($f3)
    {
        //$_SESSION = array();
        if (isset($_POST['color']))
        {
            $color = $_POST['color'];
            if (validColor($color))
            {
                $_SESSION['color'] = $color;
                $f3->reroute('/results');
            }
            else
            {
                $f3->set("errors['color']", "Please enter a color.");
            }
        }
        $view = new Template();
        echo $view->render("views/form2.html");
    });


    $f3->route('GET|POST /results', function()
    {
       // $_SESSION['color'] = $_POST['color'];
        $view = new Template();
        echo $view->render("views/results.html");
    });

    // Run Fat-Free
    $f3->run();
