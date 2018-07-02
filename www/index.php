<!DOCTYPE html>
<html>

<head>

    <title>CS143 Project 1C</title>
</head>


<body>
<?php
include('nav.html');
?>

<h1>Search</h1>
<form method="GET" action="search.php">
    <div align="center">
        Search:
        <input type="text" name="input">
        <button type="submit">Submit</button>
    </div>
</form>

<?php

$db = new mysqli('localhost','cs143', '', 'CS143');
if($db->connect_errno>0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
}
$input = $_GET['input'];
$each = explode(" ",$input);
$query = "SELECT id,concat(first,' ',last) as name, sex, dob FROM Actor WHERE";
for($i = 0; $i < count($each); $i++) {
    $query = $query." concat(first,' ',last) LIKE '%".$each[$i]."%'";
    if($i != count($each) - 1) {
        $query = $query." AND ";
    }else {
        $query = $query.";";
    }
}
if($input != ""){
    print "<h2>Matching Actor/Actress</h2>";
    $rs = $db->query($query);
    if($rs->num_rows != 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>First Name</th><th>Gender</th><th>Date of Birth</th>";
        echo "</tr>";
        while ($row = $rs->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href = 'actor_info.php?aid=";
            echo $row['id'];
            echo "'>" . $row['name'] . "</a></td>";
            echo "<td>" . $row['sex'] . "</td>";
            echo "<td>" . $row['dob'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    else
        echo "<h4>None</h4>";

}
$rs->free();
$query = "SELECT title, year, id FROM Movie WHERE";
for($i = 0; $i < count($each); $i++) {
    $query = $query." title LIKE '%".$each[$i]."%'";
    if($i != count($each) - 1) {
        $query = $query." AND ";
    }else {
        $query = $query.";";
    }
}
if($input != ""){
    print "<h2>Matching Movie</h2>";
    $rs = $db -> query($query);
    if($rs -> num_rows != 0){
        echo "<table>";
        echo "<tr>";
        echo "<th>Title</th><th>Released Year</th>";
        echo "</tr>";
        while ($row = $rs->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href = 'movie_info.php?mid=";
            echo $row['id'];
            echo "'>" . $row['title'] . "</a></td>";
            echo "<td>" . $row['year'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    else
        echo "<h4>None</h4>";

}
$rs->free();
$db->close();
?>



</body>
</html>
