<?php 
  include("Config/Connection.php");
  $db = new Database();

  include('Object/User.php');
  include('Object/Report.php');
  include('Object/Post.php');
  include('Object/Like.php');

  $action=null;
	if(!empty($_GET["action"]))
	{
		$action=$_GET["action"];
  }
  
	switch($action)
	{
    case "follow_report":
      if(((null!=$_GET['userid']) AND (null!=$_GET['pageid'])) AND (null==$_GET['follow']))
      {
        $userid=$_GET['userid'];
        $pageid=$_GET['pageid'];
        $report = new Report($db);
        $report->addreport($userid,$pageid);
      }
      else if(((null!=$_GET['userid']) and (null!=$_GET['pageid']) and (null!=$_GET['follow'])))
      {
        $userid=$_GET['userid'];
        $pageid=$_GET['pageid'];
        $report = new Report($db);
        $report->deletereport($userid,$pageid);
      }
      else 
      {
        echo "Somthing Wents Wrong !!";    
      }
      break;
    default:
      break;
  }

  // Check User Login Or Not

  if(empty($_SESSION['email']))
  {
    header("Location: Login.php");
  }

  if(isset($_SESSION['email']))
  {
     header("Location: Home.php");
  }

  // Login

  if(isset($_POST['login']))
  {
    $email=$_POST['email'];
    $password=$_POST['pass'];
    $user = new User($db);
    $user->login($email,$password);
    
  }

  // Register

  if(isset($_POST['reg']))
  {
    $username=$_POST['user'];
    $email=$_POST['email'];
    $password=$_POST['pass'];

    $user = new User($db);
    $user->ragister($username,$email,$password);
    
    
    
  }

  // Logout

  if(isset($_GET['logout']))
  {
    $user = new User($db);
    $user->logout();
  }

  // Add Post
  
  if(isset($_POST["add_post"]))
	{
  
		$filename=$_FILES["img"]["name"];
		$tempname=$_FILES["img"]["tmp_name"];
		$folder="Src/Img/Post/".$filename;
    move_uploaded_file($tempname,$folder);
    // $imageFileType = strtolower(pathinfo($folder,PATHINFO_EXTENSION));
    
    $title=$_POST['title'];
    $description=$_POST['description'];

    $post= new Post($db);
    $user =new User($db);
    $userid=$user->finduserid($_SESSION['email']);
    $view=0;
    $post->addpost($title,$description,$folder,$userid,$view);
  }

  // Change Password

  if(isset($_POST['change_password']))
  {
    $old=$_POST['oldpass'];
    $new=$_POST['newpass'];
    $id=$_POST['userid'];

    $user =new User($db);
    $user->changepassword($new,$id);
  }

  // Set Profile 

  if(isset($_POST['change_profile']))
  {
    // $filename=$_FILES["img"]["name"];
		// $tempname=$_FILES["img"]["tmp_name"];
		// $folder="Src/Img/Profile/".$filename;
    // move_uploaded_file($tempname,$folder);

    $username=$_POST['username'];
    $gender=$_POST['inlineRadioOptions'];
    $id=$_POST['userid'];
    
    $user =new User($db);
    $user->changeuserinfo($username,$gender,$id);
    header("Location: Setting.php");
  }

  // Set Profile 

  if(isset($_POST['change_profile_img']))
  {
    $filename=$_FILES["img"]["name"];
		$tempname=$_FILES["img"]["tmp_name"];
		$folder="Src/Img/Profile/".$filename;
    move_uploaded_file($tempname,$folder);

    $id=$_POST['userid'];
    
    $user =new User($db);
    $user->changeuserprofile($folder,$id);
    header("Location: Setting.php");
  }

  ?>
  