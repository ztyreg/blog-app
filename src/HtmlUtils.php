<?php

require_once ("User.php");

// create a user profile hyperlink
class HtmlUtils
{
    public static function createUserTag(User $user, string $class)
    {
        return '<a class="' . $class . '" href="profile.php?id=' . $user->getId() . '">' . $user->getUsername() . '</a>';
    }

}
