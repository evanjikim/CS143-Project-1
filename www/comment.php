<!DOCTYPE html>
<html>

<head>

    <title>CS143 Project 1C</title>
</head>

<body>
<?php
include('nav.html');
?>

<h1>Comment</h1>
<form method="GET" action="comment.php">
    <p>
        Reviewer Name:
        <input type="text" name="name" maxlength="20" required>
    </p>
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
    <p>Ratings:<br>
    <input type="radio" name="rating" value="1">1
        <input type="radio" name="rating" value="2">2
        <input type="radio" name="rating" value="3" checked>3
        <input type="radio" name="rating" value="4">4
        <input type="radio" name="rating" value="5">5
    </>
    <p>Comment:<br>
    <textarea name="comment" rows="5" cols="50"></textarea></p>
    <p><button type="submit">Submit</button></p>
</form>
<?php
$name = $_GET['name'];
$mid = $_GET['mid'];
$rate = $_GET['rating'];
$comment = $_GET['comment'];

if($mid != "" && $name != ""){
    $db->query("insert into Review values('$name',now(),'$mid','$rate','$comment');");
}

$rs->free();
$db->close();
?>
</body>
</html>
