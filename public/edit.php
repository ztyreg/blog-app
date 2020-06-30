<?php
require_once("../src/init.php");

$post_message = "";

// what are we editing?
$edit_type = $_GET['type'];
$edit_id = $_GET['id'];
if ($edit_type == null || $edit_id == null) {
    redirect("home.php");
}


if (isset($_POST['cancel'])) {
    redirect("myposts.php");
}

//TODO
// cannot edit other's


$title = $content = "";
if ($edit_type == "story") {
    $story = Story::select_story_by_id($edit_id)[0];
    $title = $story->getTitle();
    $content = $story->getContent();
}

// new post
//if (isset($_POST['create'])) {
//    $title = trim($_POST['title']);
//    $body = trim($_POST['body']);
//    $user_id = $session->user_id;
//    if (empty($title)) {
//        $post_message = "Title cannot be empty!";
//    } elseif (empty($body)) {
//        $post_message = "Story cannot be empty!";
//    } else {
//        $id = Story::create_story($title, $body, $user_id);
//        $post_message = "";
//        redirect("stories.php?id=" . $id);
//    }
//}



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
        echo htmlentities($edit_type) . ' ' . htmlentities(Story::select_story_by_id($edit_id)[0]->getTitle());
        ?>
        <br><br>
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'Write')" id="WriteTab">Edit</button>
        </div>



        <div id="Write" class="tabcontent">
            <form action="edit.php" method="post">
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