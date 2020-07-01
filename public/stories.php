<?php
require_once("../src/init.php");

$title = "";
$body = "";
if (isset($_GET['id']) && $story = Story::select_story_by_id((int)$_GET['id'])[0]) {
    $title = $story->getTitle();
    $body = $story->getContent();
} else {
    $title = "Ooops...";
    $body = "Story not found";
    redirect("home.php");
}

if (isset($_POST['submit'])) {
    $content = $_POST['comment'];
    if (!empty($content)) {
        $story_id = $_POST['pageId'];
        Comment::create_comment($session->user_id, $story_id, $content);
        redirect("process.php");
    } else {
        redirect("process.php");
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


    <?php
    foreach (Comment::select_comment_by_story_id($_GET['id']) as $comment) {
        echo '<div class="div-comment">';
        echo User::find_username_from_id($comment->getUserId()) . ': ';
        echo $comment->getContent();
        echo '</div>';
    }
    ?>

    <?php
    if ($session->is_signed_in()) {
        echo '<div class="div-comment">';
        echo '<form action="stories.php" method="post">';
        echo '<div class="div-section-small">';
        echo 'New Comment';
        echo '<input type="submit" id="submit" name="submit" class="btn right" value="Post">';
        echo '</div>';
        echo '<label for="comment"></label>';
        echo '<textarea class="story-comment" id="comment" name="comment" placeholder="Start your comment here...">';
        if (isset($_POST['comment'])) {
            echo htmlentities($_POST['comment']);
        }
        echo '</textarea>';
        echo '<input type="hidden" id="pageId" name="pageId" value="' . htmlentities($_GET['id']) . '">';
        echo '</form>';
        echo '</div>';
    }
    ?>


</div>

</body>
</html>