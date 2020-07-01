<?php
require_once("../src/init.php");

$user_id = $_GET['id'];
if ($user_id == null || empty(User::select_user_by_id($user_id))) {
    redirect("home.php");
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
        echo 'The profile of ' . HtmlUtils::createUserTag(User::select_user_by_id($user_id)[0], "title");
        ?>
    </div>


    <div class="div-gap">

        See what they have written. <br><br>
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'Stories')" id="StoriesTab">Their stories</button>
            <button class="tablinks" onclick="openTab(event, 'Comments')" id="CommentsTab">Their comments</button>
        </div>

        <div id="Stories" class="tabcontent">
            <table>
                <tr>
                    <th>Title</th>
                </tr>
                <?php
                foreach (Story::select_story_by_user_id($user_id) as $story) {
                    echo '<tr>';
                    echo '<td><a href = "stories.php?id=' . $story->getLink() . '" > ' . $story->getTitle() . '</a ></td>';
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
                </tr>
                <?php
                foreach (Comment::select_comment_by_user_id($user_id) as $comment) {
                    $story = Story::select_story_by_id($comment->getStoryId())[0];
                    echo '<tr>';
                    echo '<td><a href = "stories.php?id=' . htmlentities($story->getLink()) . '" > ' . $story->getTitle() . '</a ></td>';
                    echo '<td>' . $comment->getContent() . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
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
                activeTab = "Stories";
            }

            document.getElementById(activeTab + "Tab").click();
        </script>


    </div>
</div>

</body>
</html>