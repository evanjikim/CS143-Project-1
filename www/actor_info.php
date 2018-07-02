<!DOCTYPE html>
<html>

<head>

    <title>CS143 Project 1C</title>

</head>

<body>
<?php
include('nav.html');
?>

<h1>Actor/Actress Information</h1>
<form method="GET" action="actor_info.php">
    <div align="center">Actor:
        <select name="aid" required>
            <?php

            $db = new mysqli('localhost','cs143', '', 'CS143');
            if($db->connect_errno>0) {
                die('Unable to connect to database [' . $db->connect_error . ']');
            }
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
        <button type="submit">Submit</button>
    </div>
</form>
<?php

$aid = $_GET['aid'];

if($aid != "") {
    $query = "select concat(first, ' ', last) as name, sex, dob, dod from Actor where id = $aid";
    $rs = $db->query($query);
    $row = $rs->fetch_assoc();
    echo "<p>Name: " . $row['name'] . "</p>";
    echo "<p>Gender: " . $row['sex'] . "</p>";
    echo "<p>Date of Birth: " . $row['dob'] . "</p>";
    if($row['dod'] != "")
        echo "<p>Date of Death: " . $row['dod'] . "</p>";
    else
        echo "<P>Date of Death: N/A</P>";

    $rs->free();

    echo "<h2>Movies in as</h2>";
    $query = "select title, role,id from Movie, MovieActor where aid = $aid and mid = id";
    $rs = $db->query($query);
    echo "<table>";
    echo "<tr><th>Title</th><th>Role</th></tr>";
    while ($row = $rs->fetch_assoc()) {
        echo "<tr>";
        echo "<td><a href = 'movie_info.php?mid=";
        echo $row['id'];
        echo "'>" . $row['title'] . "</a></td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "</tr>";
    }

}

$rs->free();
$db->close();
?>
</body>
</html>
