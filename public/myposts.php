<?php
require_once("../src/init.php");

$post_message = "";

// new post
if (isset($_POST['create'])) {
    $title = trim($_POST['title']);
    $body = trim($_POST['body']);
    $user_id = $session->user_id;
    if (empty($title)) {
        $post_message = "Title cannot be empty!";
    } elseif (empty($body)) {
        $post_message = "Story cannot be empty!";
    } else {
        $id = Story::create_story($title, $body, $user_id);
        $post_message = "";
        redirect("stories.php?id=" . $id);
    }
}

// delete story
foreach (Story::select_story_by_user($session->user_id) as $story) {
    $button_clicked = 'delete' . $story->getId();
    if (isset($_POST[$button_clicked])) {
        Story::delete_story($story->getId());
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
        Hello, User!
    </div>


    <div class="div-gap">

        Manage your stories and comments here. Or, create a new story. <br><br>
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'Write')" id="WriteTab">New story</button>
            <button class="tablinks right" onclick="openTab(event, 'Comments')" id="CommentsTab">My comments</button>
            <button class="tablinks right" onclick="openTab(event, 'Stories')" id="StoriesTab">My stories</button>
        </div>

        <div id="Stories" class="tabcontent">
            <table>
                <?php
                foreach (Story::select_story_by_user($session->user_id) as $story) {
                    echo '<tr>';
                    echo '<td><a href = "stories.php?id=' . $story->getLink() . '" > ' . $story->getTitle() . '</a ></td>';
                    echo '<td><form action="myposts.php" method="post">';
                    echo '<input type="submit" class="btn" value="Edit" name="edit' . $story->getId() . '"/>';
                    echo '<input type="submit" class="btn" value="Delete" name="delete' . $story->getId() . '"/>';
                    echo '</form></td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>

        <div id="Comments" class="tabcontent">
            <h3>Paris</h3>
            <p>Paris is the capital of France.</p>
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