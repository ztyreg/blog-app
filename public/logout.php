<?php
require_once ("../src/init.php");
$session->logout();
redirect("home.php");
