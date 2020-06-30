<?php
ob_start();
require_once("init.php");


if (!$session->is_signed_in()) {
    echo '<div class="topnav">
    <a href="home.php">Home</a>
    <a href="about.php">About</a>

    <a class="right" href="signup.php">Sign up</a>
    <a class="right" href="login.php">Login</a>
    </div>';
} else {
    echo '<div class="topnav">
    <a href="home.php">Home</a>
    <a href="about.php">About</a>

    <a class="right" href="logout.php">Logout</a>
    <a class="right" href="myposts.php">My posts</a>
</div>';
}
