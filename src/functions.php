<?php

/**
 * Redirect
 * @param string $location
 */
function redirect(string $location)
{
    header("Location: {$location}");
}

