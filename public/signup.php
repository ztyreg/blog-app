<?php
require_once("../src/init.php");

if ($session->is_signed_in()) {
    redirect("home.php");
}

$signup_message = "";
if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (User::create_user($username, $password)) {
        $signup_message = "Successfully created account, taking you back to the home page...";
        header( "refresh:1;url=home.php" );
    } else {
        $signup_message = "This user already exists.";
    }

} else {
    $username = "";
    $password = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/default.css">
</head>
<body>

<div class="div-form">
    Create your account <br><br>
    <form action="signup.php" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlentities($username); ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="<?php echo htmlentities($password); ?>">
        </div>
        <br>
        <div class="form-group">
            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
        </div>
    </form>
    <?php
    echo $signup_message;
    ?>
</div>



</body>
</html>