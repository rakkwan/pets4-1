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
    // require validation file
    require_once('model/validation-functions.php');

    // create an instance of the base class
    $f3 = Base::instance();

    // Turn on Fat-free error reporting
    $f3->set('DEBUG', 3);

    $f3->set('colors', array('pink', 'green', 'blue'));
    //set traits array to make checkboxes
    $f3->set('traits', array('fat','skinny','featherless', 'large', 'medium',
    'small','lazy','active','hyper','slimey','fluffy'));

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
        //$_SESSION = array();
        // If form has been submitted, validate
        if(!empty($_POST))
        {
            //Get data from form
            $animal = $_POST['animal'];
            $qty = $_POST['qty'];

            //Add data to the hive
            $f3->set('animal', $animal);
            $f3->set('qty', $qty);

            // if data is valid
            if(validString($animal) && validQty($qty))
            {
                // Write data to Session
                $_SESSION['animal'] = $animal;
                $_SESSION['qty'] = $qty;
                $f3->reroute('/order2');
            }
            if(!validString($animal))
            {
                $f3->set("errors['animal']", "Please enter an animal");
            }
            if(!validQty($qty))
            {
                $f3->set("errors['qty]", "Please enter a valid quantity");
            }
        }

        $view = new Template();
        echo $view->render("views/form1.html");
    });

    $f3->route('GET|POST /order2', function($f3)
    {
        //if post array is not empty -> do all the things below
        if(!empty($_POST))
        {
            //Get the data from form
            $color = $_POST['color'];
            $trait= $_POST['trait'];

            //store data in the hive
            $f3->set('color',$color);
            $f3->set('trait',$trait);

            //check if form is valid
            if(validForm())
            {
                //add data to session
                $_SESSION['color'] = $color;
                $_SESSION['trait'] = $trait;

                if(empty($trait))
                {
                    $_SESSION['trait'] = "No trait selected";
                }
                else
                {
                    $_SESSION['trait'] =  implode(', ', $trait);
                }

                //Redirect to results, if all is running well
                $f3->reroute('/results');
            }
            else
            {
                $f3->set("errors['color']", "Please pick a color");
                //$f3->set("errors['trait']", "No trait selected");
            }
        }
        //if form is not filled out properly, display form2 again. FORM IS STICKY!
        $view = new Template();
        echo $view->render("views/form2.html");
    });

    $f3->route('GET /results', function()
    {
       // $_SESSION['color'] = $_POST['color'];
        $view = new Template();
        echo $view->render("views/results.html");
    });

    // Run Fat-Free
    $f3->run();