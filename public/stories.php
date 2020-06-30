<?php
require_once ("../src/init.php");

$title = "";
$body = "";
if (!isset($_GET['id'])) {
    redirect("home.php");
} else {
    $story_id = $_GET['id'];
    if ($story = Story::select_story_by_id($story_id)[0]) {
        $title = $story->getTitle();
        $body = $story->getBody();
    } else {
        $title = "Ooops...";
        $body = "Story not found";
    }
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

<?php
include_once("../src/header.php");
?>


<div class="div-narrow">
    <div class="div-title">
        <?php
        echo $title;
        ?>
    </div>

    <div class="div-article">
        <?php
        echo $body;
        ?>
    </div>

    <div class="div-section">
        Comments
    </div>

    <div class="div-comment">
        test
    </div>
</div>

</body>
</html>