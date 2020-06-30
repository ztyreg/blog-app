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
            <button class="tablinks" onclick="openTab(event, 'Write')" id="defaultOpen">New story</button>
            <button class="tablinks right" onclick="openTab(event, 'Comments')">My comments</button>
            <button class="tablinks right" onclick="openTab(event, 'Stories')">My stories</button>
        </div>

        <div id="Stories" class="tabcontent">
            <table>
                <tr>
                    <th><a href="stories.php">Company</a></th>
                    <th>Contact</th>
                    <th>Country</th>
                </tr>
                <tr>
                    <td>Alfreds Futterkiste</td>
                    <td>Maria Anders</td>
                    <td>Germany</td>
                </tr>
                <tr>
                    <td>Centro comercial Moctezuma</td>
                    <td>Francisco Chang</td>
                    <td>Mexico</td>
                </tr>
                <tr>
                    <td>Ernst Handel</td>
                    <td>Roland Mendel</td>
                    <td>Austria</td>
                </tr>
                <tr>
                    <td>Island Trading</td>
                    <td>Helen Bennett</td>
                    <td>UK</td>
                </tr>
                <tr>
                    <td>Laughing Bacchus Winecellars</td>
                    <td>Yoshi Tannamuri</td>
                    <td>Canada</td>
                </tr>
                <tr>
                    <td>Magazzini Alimentari Riuniti</td>
                    <td>Giovanni Rovelli</td>
                    <td>Italy</td>
                </tr>
            </table>
        </div>

        <div id="Comments" class="tabcontent">
            <h3>Paris</h3>
            <p>Paris is the capital of France.</p>
        </div>

        <div id="Write" class="tabcontent">
            <form action="myposts.php" method="post">
                <div class="div-textarea">
                    <label for="story"></label>
                    <textarea id="story" placeholder="Start your story here..."></textarea>
                </div>
                <br>
                <button class="btn right" name="create">Post</button>
            </form>
        </div>

        <script>
            function openTab(evt, cityName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(cityName).style.display = "block";
                evt.currentTarget.className += " active";
            }

            document.getElementById("defaultOpen").click();
        </script>


    </div>
</div>

</body>
</html>