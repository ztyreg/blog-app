<?php
require_once("../src/init.php");

$title = "";
$user_id = "";
$body = "";
if (isset($_GET['id']) && $story = Story::select_story_by_id((int)$_GET['id'])[0]) {
    $title = $story->getTitle();
    $user_id = $story->getUserId();
    $body = $story->getContent();
    $title = str_replace(array("\r\n", "\r", "\n", "\\r", "\\n", "\\r\\n"), "<br/>", $title);
    $body = str_replace(array("\r\n", "\r", "\n", "\\r", "\\n", "\\r\\n"), "<br/>", $body);
} else {
    $title = "Ooops...";
    $user_id = "";
    $body = "Story not found";
    redirect("index.php");
}

if (isset($_POST['submit']) && $session->verifyToken($_POST['token'])) {
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

    <div class="div-title2">
        <?php
        echo "By " . HtmlUtils::createUserTag(User::select_user_by_id($user_id)[0], "title2");
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
        $clean_comment = str_replace(array("\r\n", "\r", "\n", "\\r", "\\n", "\\r\\n"), "<br/>", $comment->getContent());
        echo $clean_comment;
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
        // pass CSRF token
        echo '<input type="hidden"  name="token" value="' . $session->getToken() . '">';
        echo '</form>';
        echo '</div>';
    }
    ?>


</div>

</body>
</html>