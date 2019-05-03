<?php

/**
 * Validate a color
 *
 * @param String $color
 * @return boolean
 */
function validForm()
{
    global $f3;
    $isValid = true;
  /*  if(!validString($f3->get('animal')))
    {
        $isValid = false;
        //$_SESSION['animal'] = $animal;
        //$f3->reroute('/order2');
        $f3->set("errors['animal']", "Please enter an animal.");
    }*/
    if (!validColor($f3->get('color')))
    {
        $isValid = false;

        $f3->set("errors['color']", "Please enter a color.");
    }

    if (!validTraits($f3->get('trait'))) {
        $isValid = false;
        $f3->set("errors['trait']", "Invalid selection");
    }

    return $isValid;

}
function validTraits($trait)
{
    global $f3;
    //traits are optional
    if (empty($trait)) {
        return true;
    }
    //But if there are traits, we need to make sure they're valid
    foreach ($trait as $traits) {
        if (!in_array($traits, $f3->get('trait'))) {
            return false;
        }
    }
    //If we're still here, then we have valid traits
    return true;
}
function validColor($color)
{
    global $f3;
    return in_array($color, $f3->get('colors'));
}

function validString($string)
{
    return (!empty($string) && ctype_alpha($string));
}

function validQty($qty)
{
    return (!empty($qty) && ctype_digit($qty) && $qty >= 1);
}