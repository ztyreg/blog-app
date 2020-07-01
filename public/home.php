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
        The latest stories. <br><br>
        <table>
            <tr>
                <th>Title</th>
                <th style="width: 200px">Author</th>
            </tr>
            <?php
            foreach (Story::select_all_stories() as $story) {
                echo '<tr>';
                echo '<td><a href="stories.php?id=' . $story->getLink() . '">' . $story->getTitle() . '</a></td>';
                $username = User::find_username_from_id($story->getUserId());
                echo '<td>' . $username . '</td>
            </tr>';
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>