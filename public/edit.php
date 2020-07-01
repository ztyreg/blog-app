<?php
require_once("../src/init.php");

$post_message = "";

// what are we editing?
$edit_type = $_GET['type'];
$edit_id = (int)$_GET['id'];
if ($edit_type == null || $edit_id == null) {
    redirect("index.php");
}


//TODO
// cannot edit other's


$title = $content = "";
if ($edit_type == "story") {
    $story = Story::select_story_by_id($edit_id)[0];
    if ($story->getUserId() != $session->user_id) {
        redirect("index.php");
    }
    $title = $story->getTitle();
    $content = $story->getContent();
} elseif ($edit_type == "comment") {
    $comment = Comment::select_comment_by_id($edit_id)[0];
    if ($comment->getUserId() != $session->user_id) {
        redirect("index.php");
    }
    $title = "Below is your comment";
    $content = $comment->getContent();
}

// abort
if (isset($_POST['cancel'])) {
    redirect("myposts.php");
}

// update post
if (isset($_POST['create']) && $session->verifyToken($_POST['token'])) {

    $title = trim($_POST['title']);
    $content = trim($_POST['body']);

    if ($edit_type == "story") {
        // update story
        if (empty($title)) {
            $post_message = "Title cannot be empty!";
        } elseif (empty($content)) {
            $post_message = "Story cannot be empty!";
        } else {
            Story::update_story($title, $content, $edit_id);
            $post_message = "";
            redirect("stories.php?id=" . $edit_id);
        }
    } elseif ($edit_type == "comment") {
        // update comment
        if (empty($content)) {
            $post_message = "Comment cannot be empty!";
        } else {
            Comment::update_comment($content, $edit_id);
            $post_message = "";
            redirect("stories.php?id=" . Comment::select_comment_by_id($edit_id)[0]->getStoryId());
        }
    }
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
        <?php
        echo 'Hello, ' . User::find_username_from_id($session->user_id) . '!';
        ?>
    </div>


    <div class="div-gap">

        <?php
        echo 'You are editing ';
        if ($edit_type == "story") {
            echo htmlentities($edit_type) . ' the following story: ' . htmlentities(Story::select_story_by_id($edit_id)[0]->getTitle());
        } elseif ($edit_type == "comment") {
            $story_id = Comment::select_comment_by_id($edit_id)[0]->getStoryId();
            $story_title = Story::select_story_by_id($story_id)[0]->getTitle();
            echo htmlentities($edit_type) . ' of the following story: ' . htmlentities($story_title);
        }
        ?>
        <br><br>
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'Write')" id="WriteTab">Edit</button>
        </div>


        <div id="Write" class="tabcontent">
            <form action="edit.php?type=<?php echo $edit_type ?>&id=<?php echo $edit_id ?>" method="post">
                <div class="div-story-title">
                    <label for="title"></label>
                    <textarea class="story-title" id="title" name="title" placeholder="Untitled"><?php
                        if (isset($_POST['title'])) {
                            echo htmlentities($_POST['title']);
                        } else {
                            echo $title;
                        }
                        ?></textarea>
                </div>
                <div class="div-story-body">
                    <label for="body"></label>
                    <textarea class="story-body" id="body" name="body"
                              placeholder="Start your story here..."><?php
                        if (isset($_POST['body'])) {
                            echo htmlentities($_POST['body']);
                        } else {
                            echo $content;
                        }
                        ?></textarea>
                </div>
                <br>
                <?php
                echo $post_message;
                ?>
                <button class="btn right" name="create" style="margin-left: 10px">Post</button>
                <button class="btn right" name="cancel">Cancel</button>
                <input type="hidden"  name="token" value="<?php $session->getToken(); ?>">
            </form>
        </div>

        <script>

            function openTab(evt, sectionName) {
                let i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(sectionName).style.display = "block";
                localStorage.setItem("editactive", sectionName);
                evt.currentTarget.className += " active";
            }

            let activeTab = localStorage.getItem("editactive");
            if (activeTab == null) {
                activeTab = "Write";
            }

            document.getElementById(activeTab + "Tab").click();
        </script>


    </div>
</div>

</body>
</html>