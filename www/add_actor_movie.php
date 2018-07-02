<!DOCTYPE html>
<html>

<head>

    <title>CS143 Project 1C</title>
</head>

<body>
<?php
include('nav.html');
?>

<h1>Actor to Movie Relation</h1>
<form method="GET" action="add_actor_movie.php">
    <p>Movie:
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
    </p>
    <p>Starring<br>
    Actor:
        <select name="aid" required>
            <?php

            $query="SELECT id,last, first, dob FROM Actor ORDER BY last ASC;";
            $rs = $db->query($query);
            while($row = $rs->fetch_assoc()) {
                $id = $row['id'];
                $last = $row['last'];
                $first = $row['first'];
                $dob = $row['dob'];
                echo '<option value="' . $id . '">' . $last . ', '. $first . ', DOB: '. $dob .'</option>';
            }
            $rs->free();
            ?>
        </select>
    </p>
    <p>AS<br>
    Role:
        <input type="text" name="role" maxlength="50" required>
    </>
    <p><button type="submit">Submit</button></p>
</form>
<?php

$aid = $_GET['aid'];
$mid = $_GET['mid'];
$role = $_GET['role'];

if($role != "")
{
    $db->query("insert into MovieActor values('$mid','$aid','$role');");
}

$rs->free();
$db->close();
?>
</body>
</html>
