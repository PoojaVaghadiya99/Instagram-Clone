<?php
    include("Config/Connection.php");
    $db = new Database();
    include('Object/User.php');
    $user = new User($db);
    include('Object/Report.php');
    $report = new Report($db);
    include('Object/Post.php');
    $post = new Post($db);

    
    include("Header.php");

    
    // Get UserID By User EmailID 
    $userid=$user->finduserid($_SESSION['email']);
    // Find User Following
    $following=$report->totalfollowing($userid);
    // Find User Follower
    $follower=$report->totalfollower($userid);
    // Find User Post
    $totalpost=$post->totalpost($userid);
    // Find Profile Photo
    $photo=$user->profilephoto($userid);

    
    // Print UserName and EmailID 
    $username=$user->getusername($_SESSION['email']); 
?>
<style>

.t{
  text-align:center;
}
a{
  text-decoration:none;
}
</style>

<script>
function UserPost() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("data").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "UserPost.php", true);
  xhttp.send();
}

function UserFollower() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("data").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "UserFollower.php", true);
  xhttp.send();
}

function UserFollowing() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("data").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "UserFollowing.php", true);
  xhttp.send();
}
</script>


<div class="container mt-3 t">
  <div class="row justify-content-md-center">

    <div class="col col-lg-2 col-md-2 col-12">
      <?php if($photo == "") { ?>
        <img src="./Src/Img/c.png" class="img-fluid avatar">
      <?php } else { ?>
        <img src="<?php echo $photo; ?>" class="img-fluid avatar">
      
      <?php } ?>
    </div>

    <br>

    <div class="col col-lg-5 col-md-5 col-12">
    
      <div class="row justify-content-md-center mt-3">
        <div class="col col-lg-12 col-md-12 col-12 t">
          <strong><?php echo $username; ?></strong>
        </div>
      </div>
      
      <br>
      
      <div class="row justify-content-md-center">
        <div class="col col-lg-4 col-md-4 col-4 t">
          <a href="#" class="text-secondary t" id="load" onclick="UserPost()">
            <h6 class="t">Post</h6>
            <h6 class='t'><?php echo $totalpost; ?></h6>
          </a>
          <hr width="80%" class="mt-0">
        </div>

        <div class="col col-lg-4 col-md-4 col-4 t mb-0">
          <a href="#content" class="text-secondary t" onclick="UserFollowing()">
            <h6 class="t">Following</h6>
            <h6 class='t'><?php echo $following; ?></h6>
          </a>
          <hr width="80%" class="mt-0">
        </div>

        <div class="col col-lg-4 col-md-4 col-4 t">
          <a href="#content" class="text-secondary t" onclick="UserFollower()">
            <h6 class="t">Follower</h6>
            <h6 class='t'><?php echo $follower; ?></h6>
          </a>
          <hr width="80%" class="mt-0">
        </div>
      </div>

     </div>
   </div>
</div>

  
    <div class="mb-2 text-center mt-3">
      <i class="fa fa-th-large mr-4 ml-4" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;
      <i class="fa fa-bookmark mr-4 ml-4" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;
      <i class="fa fa-heart mr-4 ml-4" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;
    </div>  
    <div id="data" class="mt-3">
  </div>


<?php
    include("Footer.php"); 
?>

