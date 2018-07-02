<!DOCTYPE html>
<html>

<head>

    <title>CS143 Project 1C</title>
</head>

<body>
<?php
include('nav.html');
?>

<h1>Add new Actor/Director</h1>
<form method="GET" action="add_person.php">
    <p><input type="radio" name="person" value="actor" checked>Actor
        <input type="radio" name="person" value="director">Director</p>
    <p>First Name:
        <input type="text" name="firstname" maxlength="20" required></p>
    <p>Last Name:
        <input type="text" name="lastname" maxlength="20" required></p>
    <p><input type="radio" name="gender" value="Male" checked=>Male
        <input type="radio" name="gender" value="Female">Female</p>
    <p>Date of Birth:
        <input type="date" name="dob" required></p>
    <p>Date of Death:
        <input type="date" name="dod"></p>
    <p><button type="submit">Submit</button></p>
</form>
<?php

$db = new mysqli('localhost','cs143', '', 'CS143');
if($db->connect_errno>0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
}
$person = $_GET['person'];
$firstName = $_GET['firstname'];
$lastName = $_GET['lastname'];
$gender = $_GET['gender'];
$dob = $_GET['dob'];
$dod = $_GET['dod'];

if($firstName != "" && $lastName != "" && $dob != ""){
$rs = $db->query("select id from MaxPersonID;");
$row = $rs->fetch_assoc();
$newID = $row["id"] + 1;
$db->query("update MaxPersonID set id = id+1;");

if($person == 'actor'){
    if($dod != '')
        $db->query("insert into Actor values($newID,'$lastName','$firstName','$gender', '$dob', '$dod');");
    else
        $db->query("insert into Actor values($newID,'$lastName','$firstName','$gender', '$dob', NULL);");
}
else {
    if ($dod != '')
        $db->query("insert into Director values($newID,'$lastName','$firstName', '$dob', '$dod');");
    else
        $db->query("insert into Director values($newID,'$lastName','$firstName', '$dob', NULL);");
}
$rs->free();
}
$db->close();
?>
</body>
</html>
