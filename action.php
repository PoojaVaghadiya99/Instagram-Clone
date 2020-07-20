<?php
include("Config/Connection.php");
$db = new Database();
include('Object/User.php');
$user = new User($db);


// Get UserID By User EmailID 
$userid=$user->finduserid($_SESSION['email']);


if(!empty($_POST['access'])) 
{
    $user->makeprivate($userid);
    header("Location: Setting.php");
} 
else 
{
    $user->makepublic($userid);
    header("Location: Setting.php");
}

?>