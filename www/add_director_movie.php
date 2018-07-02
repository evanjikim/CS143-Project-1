<!DOCTYPE html>
<html>

<head>

    <title>CS143 Project 1C</title>
</head>

<body>
<?php
include('nav.html');
?>

<h1>Director to Movie Relation</h1>
<form method="GET" action="add_director_movie.php">
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
    <p>Directed by<br>

    Director:
        <select name="did" required>
            <?php
            $query="SELECT id,last, first, dob FROM Director ORDER BY last ASC;";
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
    </>
    <p><button type="submit">Submit</button></p>
</form>
<?php
$did = $_GET['did'];
$mid = $_GET['mid'];
if($did != "" && $mid != "")
    $db->query("insert into MovieDirector values('$mid','$did');");
$rs->free();
$db->close();
?>
</body>
</html>
