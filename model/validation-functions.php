<?php

/**
 * Validate a color
 *
 * @param String $color
 * @return boolean
 */
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