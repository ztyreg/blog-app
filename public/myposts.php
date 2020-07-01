<?php
require_once("../src/init.php");

$post_message = "";

// new post
if (isset($_POST['create']) && $session->verifyToken($_POST['token'])) {

    $title = trim($_POST['title']);
    $content = trim($_POST['body']);
    $user_id = $session->user_id;
    if (empty($title)) {
        $post_message = "Title cannot be empty!";
    } elseif (empty($content)) {
        $post_message = "Story cannot be empty!";
    } else {
        $id = Story::create_story($title, $content, $user_id);
        $post_message = "";
        redirect("stories.php?id=" . $id);
    }
}

// edit story
foreach (Story::select_story_by_user_id($session->user_id) as $story) {
    $button_clicked = 'editstory' . $story->getId();
    // take the user to edit page
    if (isset($_POST[$button_clicked])) {
        redirect("edit.php?type=story&id=" . $story->getId());
    }
}

// edit comment
foreach (Comment::select_comment_by_user_id($session->user_id) as $comment) {
    $button_clicked = 'editcomment' . $comment->getId();
    // take the user to edit page
    if (isset($_POST[$button_clicked])) {
        redirect("edit.php?type=comment&id=" . $comment->getId());
    }
}

// delete story
foreach (Story::select_story_by_user_id($session->user_id) as $story) {
    $button_clicked = 'deletestory' . $story->getId();
    // verify CSRF token before deleting
    if (isset($_POST[$button_clicked]) && $session->verifyToken($_POST['token'])) {
        Story::delete_story($story->getId());
        // to prevent the user from submitting the form again by refreshing the page
        redirect("process.php");
    }
}

// delete comment
foreach (Comment::select_comment_by_user_id($session->user_id) as $comment) {
    $button_clicked = 'deletecomment' . $comment->getId();
    // verify CSRF token before deleting
    if (isset($_POST[$button_clicked]) && $session->verifyToken($_POST['token'])) {
        Comment::delete_comment($comment->getId());
        // to prevent the user from submitting the form again by refreshing the page
        redirect("process.php");
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

        Manage your stories and comments here. Or, create a new story. <br><br>
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'Stories')" id="StoriesTab">My stories</button>
            <button class="tablinks" onclick="openTab(event, 'Comments')" id="CommentsTab">My comments</button>
            <button class="tablinks right" onclick="openTab(event, 'Write')" id="WriteTab">New story</button>
        </div>

        <div id="Stories" class="tabcontent">
            <table>
                <tr>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
                <?php
                foreach (Story::select_story_by_user_id($session->user_id) as $story) {
                    echo '<tr>';
                    echo '<td><a href = "stories.php?id=' . $story->getLink() . '" > ' . $story->getTitle() . '</a ></td>';
                    echo '<td style="width: 200px;"><form action="myposts.php" method="post">';
                    echo '<input type="submit" class="btn" value="Edit" name="editstory' . $story->getId() . '"/>';
                    echo '<input type="submit" class="btn" value="Delete" name="deletestory' . $story->getId() . '"/>';
                    echo '<input type="hidden" name="token" value="' . $session->getToken() . '">';
                    echo '</form></td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>

        <div id="Comments" class="tabcontent">
            <table>
                <tr>
                    <th>Story</th>
                    <th style="width: 500px;">Comment</th>
                    <th style="width: 200px;">Actions</th>
                </tr>
                <?php
                foreach (Comment::select_comment_by_user_id($session->user_id) as $comment) {
                    $story = Story::select_story_by_id($comment->getStoryId())[0];
                    echo '<tr>';
                    echo '<td><a href = "stories.php?id=' . htmlentities($story->getLink()) . '" > ' . $story->getTitle() . '</a ></td>';
                    echo '<td>' . $comment->getContent() . '</td>';
                    echo '<td style="width: 200px;"><form action="myposts.php" method="post">';
                    echo '<input type="submit" class="btn" value="Edit" name="editcomment' . $comment->getId() . '"/>';
                    echo '<input type="submit" class="btn" value="Delete" name="deletecomment' . $comment->getId() . '"/>';
                    echo '<input type="hidden" name="token" value="' . $session->getToken() . '">';
                    echo '</form></td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>

        <div id="Write" class="tabcontent">
            <form action="myposts.php" method="post">
                <div class="div-story-title">
                    <label for="title"></label>
                    <textarea class="story-title" id="title" name="title" placeholder="Untitled"><?php
                        if (isset($_POST['title'])) {
                            echo htmlentities($_POST['title']);
                        }
                        ?></textarea>
                </div>
                <div class="div-story-body">
                    <label for="body"></label>
                    <textarea class="story-body" id="body" name="body"
                              placeholder="Start your story here..."><?php
                        if (isset($_POST['body'])) {
                            echo htmlentities($_POST['body']);
                        }
                        ?></textarea>
                </div>
                <br>
                <?php
                echo $post_message;
                ?>
                <button class="btn right" name="create">Post</button>
                <input type="hidden" name="token" value="<?php $session->getToken(); ?>">
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
                localStorage.setItem("active", sectionName);
                evt.currentTarget.className += " active";
            }

            let activeTab = localStorage.getItem("active");
            if (activeTab == null) {
                activeTab = "Write";
            }

            document.getElementById(activeTab + "Tab").click();
        </script>


    </div>
</div>

</body>
</html>