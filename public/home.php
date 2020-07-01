<?php
require_once ("../src/init.php");

if (!isset($_SESSION['number'])) {
    $_SESSION['number'] = 50;
}

if (isset($_POST['filter']) && $session->verifyToken($_POST['token'])) {
    $_SESSION['number'] = (int) $_POST['limit'];
    redirect("process.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stories</title>
    <link rel="stylesheet" href="css/default.css">
</head>
<body>

<?php
include_once("../src/header.php");
?>


<div class="div-wide">
    <div class="div-title">
        New Stories
    </div>

    <div class="div-gap">
        The latest stories.
        <form action="home.php" class="right" method="post">
            <label for="limit">Max number of stories: </label>
            <input type="number" id="limit" name="limit" style="width: 60px; font-size: 16px" value="<?php echo $_SESSION['number']?>">
            <input type="hidden" name="token" value="<?php $session->getToken(); ?>">
            <input type="submit" id="submit" name="filter" class="btn" value="Filter">
        </form>
        <br><br>
        <table>
            <tr>
                <th>Title</th>
                <th style="width: 200px">Author</th>
            </tr>
            <?php
            foreach (Story::select_all_stories($_SESSION['number']) as $story) {
                echo '<tr>';
                echo '<td><a href="stories.php?id=' . $story->getLink() . '">' . $story->getTitle() . '</a></td>';
                $username = HtmlUtils::createUserTag(User::select_user_by_id($story->getUserId())[0], "");
                echo '<td>' . $username . '</td>
            </tr>';
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>