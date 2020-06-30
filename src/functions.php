<?php

function redirect(string $location)
{
    header("Location: {$location}");
}

