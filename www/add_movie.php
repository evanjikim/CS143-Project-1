<!DOCTYPE html>
<html>

<head>

    <title>CS143 Project 1C</title>
</head>

<body>
<?php
include('nav.html');
?>

<h1>Add new Movie</h1>
<form method="GET" action="add_movie.php">
    <p>Title:
        <input type="text" name="title" maxlength="100" required></p>
    <p>Released Year:
        <input type="number" name="year" min="1900" max="2099" step="1" value="2018"> </p>
    <p>
        Genre:
        <input type="checkbox" name="genre[]" value="Action">Action</input>
        <input type="checkbox" name="genre[]" value="Adult">Adult</input>
        <input type="checkbox" name="genre[]" value="Adventure">Adventure</input>
        <input type="checkbox" name="genre[]" value="Animation">Animation</input>
        <input type="checkbox" name="genre[]" value="Comedy">Comedy</input><br>
        <input type="checkbox" name="genre[]" value="Crime">Crime</input>
        <input type="checkbox" name="genre[]" value="Documentary">Documentary</input>
        <input type="checkbox" name="genre[]" value="Drama">Drama</input>
        <input type="checkbox" name="genre[]" value="Family">Family</input>
        <input type="checkbox" name="genre[]" value="Fantasy">Fantasy</input><br>
        <input type="checkbox" name="genre[]" value="Horror">Horror</input>
        <input type="checkbox" name="genre[]" value="Musical">Musical</input>
        <input type="checkbox" name="genre[]" value="Mystery">Mystery</input>
        <input type="checkbox" name="genre[]" value="Romance">Romance</input>
        <input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi</input><br>
        <input type="checkbox" name="genre[]" value="Short">Short</input>
        <input type="checkbox" name="genre[]" value="Thriller">Thriller</input>
        <input type="checkbox" name="genre[]" value="War">War</input>
        <input type="checkbox" name="genre[]" value="Western">Western</input>

        </select>
    </p>
    <p><input type="radio" name="rating" value="G" checked=>G
        <input type="radio" name="rating" value="PG">PG
        <input type="radio" name="rating" value="PG-13">PG-13
        <input type="radio" name="rating" value="R">R
        <input type="radio" name="rating" value="NC-17">NC-17
    </p>
    <p>Production Company:
        <input type="text" name="company" maxlength="50" required></p>
    <p><button type="submit">Submit</button></p>
</form>
<?php

$db = new mysqli('localhost','cs143', '', 'CS143');
if($db->connect_errno>0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
}
$title = $_GET['title'];
$year = $_GET['year'];
$rating = $_GET['rating'];
$comp = $_GET['company'];
$genre = $_GET['genre'];

if($title != "" && $comp != "") {
    $rs = $db->query("select id from MaxMovieID;");
    $row = $rs->fetch_assoc();
    $newID = $row["id"] + 1;
    $db->query("update MaxMovieID set id = id+1;");

    $db->query("insert into Movie values($newID,'$title','$year','$rating','$comp');");

    foreach($genre as $key => $value){
        $db->query("insert into MovieGenre values($newID,'$value');");
    }
}
$rs->free();
$db->close();
?>
</body>
</html>
