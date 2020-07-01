<?php
require_once("../src/init.php");

if ($session->is_signed_in()) {
    redirect("index.php");
}

$login_message = "";
if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($user_id = User::verify_user($username, $password)) {
        $session->login($user_id);
        redirect("index.php");
    } else {
        $login_message = "Your password or username are incorrect";
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
    <form action="login.php" method="post">
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
</div>


</body>
</html>