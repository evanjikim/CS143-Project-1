<!DOCTYPE html>
<html>

<head>

    <title>CS143 Project 1C</title>

</head>

<body>
<?php
include('nav.html');
?>

<h1>Movie Information</h1>
<form method="GET" action="movie_info.php">
    <div align="center">Movie:
        <select name="mid" required>
            <?php
            $db = new mysqli('localhost','cs143', '', 'CS143');
            if($db->connect_errno>0) {
                die('Unable to connect to database [' . $db->connect_error . ']');
            }

            $query="SELECT id, title FROM Movie ORDER BY title;";
            $rs = $db->query($query);
            while($row = $rs->fetch_assoc()) {
                $title = $row['title'];
                $id = $row['id'];
                echo '<option value="' . $id . '">'. $title .'</option>';
            }
            $rs->free();
            ?>
        </select>
        <button type="submit">Submit</button>
    </div>
</form>
<?php

$mid = $_GET['mid'];

if($mid != "") {
    $query = "select title, year, rating, company from Movie where id = $mid;";
    $rs = $db->query($query);
    $row = $rs->fetch_assoc();
    echo"<p>Title: " .$row['title']."</p>";
    echo"<p>Released Year: " .$row['year']."</p>";
    echo"<p>Rating: " .$row['rating']."</p>";
    echo"<p>Producer: " .$row['company']."</p>";
    $rs->free();
    $query = "select concat(first, ' ',last) as name from Director, MovieDirector where mid=$mid and id = did;";
    $rs = $db->query($query);
    echo"<p>Director: ";
    $more = false;
    while ($row = $rs->fetch_assoc()) {
        if($more)
            echo ", ";
        else
            $more = true;
        echo $row['name'];
    }
    $query = "select genre from MovieGenre where mid = $mid;";
    $rs = $db->query($query);
    echo"<p>Genre: ";
    $more = false;
    while ($row = $rs->fetch_assoc()) {
        if($more)
            echo ", ";
        else
            $more = true;
        echo $row['genre'];
    }
    $rs->free();
    echo "<h2>Actors</h2>";
    $query = "select concat(first, ' ',last) as name, role,id from Actor, MovieActor where mid = $mid and id = aid";
    $rs = $db->query($query);
    echo "<table>";
    echo "<tr><th>Name</th><th>Role</th></tr>";
    while ($row = $rs->fetch_assoc()) {
        echo "<tr>";
        echo "<td><a href = 'actor_info.php?aid=";
        echo $row['id'];
        echo "'>" . $row['name'] . "</a></td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    $rs->free();
    echo "<p>Average Rating: ";
    $query = "select avg(rating)as average from Review where mid = $mid;";
    $rs = $db -> query($query);
    $row = $rs->fetch_assoc();
    echo $row['average'];
    echo "</p>";
    $rs->free();
    echo "<h2>Reviews</h2>";
    $query = "select name, time, rating, comment from Review where mid = $mid";
    $rs = $db->query($query);
    while($row = $rs->fetch_assoc()){
        echo "<p>" . $row['name'] . " rates " . $row['rating'] . " at " .$row['time'] ."<br>";
        echo "comment: <br>";
        echo $row['comment'];
        echo "</p>";
    }
    echo "<form action='comment.php'><p><button type='submit'>Comment</button></p></form>";
}

$rs->free();
$db->close();
?>
</body>
</html>
