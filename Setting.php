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

    
    $id=$user->finduserid($_SESSION['email']);

    $values;
    if($stmt=$db->runBaseQuery("select access from user where id='".$id."'"))
    {
        while($r=$stmt->fetch_array(MYSQLI_ASSOC))
        {
          $values=$r['access'];
        }
    }
    
    $data=$user->getuserdata($id);

?>

<nav class="container mb-3">
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-profile-tab_img" data-toggle="tab" href="#nav-profile_img" role="tab" aria-controls="nav-profile_img" aria-selected="false">Profile Photo</a>
    <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Personal</a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Password</a>
   <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Account</a>
  </div>
</nav>


<div class="tab-content container" id="nav-tabContent">

  <div class="tab-pane fade show active container" id="nav-profile_img" role="tabpanel" aria-labelledby="nav-profile_img">
  <form action="index.php" method="post"  enctype="multipart/form-data">
      <center>
      <?php while($row=mysqli_fetch_array($data)) { ?>
      <?php if($row['img'] == "") { ?>
      <img src="./Src/Img/c.png" id="profile" name="profile" class="avatar mb-3">
      <?php } else { ?>
      <img src="<?php echo $row['img']; ?>" id="profile" name="profile" class="avatar mb-3">
      <?php } ?>
      <div class="form-group m-2 p-2 h5 small  btn btn-primary m-2  btn-file">
        <label for="img">Change Profile</label>
        <input type="file" id="img" onchange="loadFile(event)" class="form-control" name="img" />
      </div>
      </center>  
      <input type="hidden" name="userid" value="<?php echo $id; ?>" />
      <center><button type="submit" name="change_profile_img" class="btn btn-primary m-2"><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;&nbsp; Save Changes</button></center>  
      <script>
      var loadFile = function(event) {
          var output = document.getElementById('profile');
          output.src = URL.createObjectURL(event.target.files[0]);
          output.onload = function() {
          URL.revokeObjectURL(output.src) // free memory
          }
      };
      </script>
      </form>
  </div> 


  <div class="tab-pane fade container" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
      <form action="index.php" method="post">
      <div class="form-group m-2 p-2 h5 small">
        <label for="exampleInputEmail1"><strong>Email</strong></label>
        <input type="email" name="email" value="<?php echo $_SESSION['email']; ?>" disabled="disabled"  class="form-control" id="exampleInputEmail1">
      </div>
      <div class="form-group m-2 p-2 h5 small">
        <label for="username"><strong>User Name</strong></label>
        <input type="text" name="username" value="<?php echo $row['username'];  ?>" class="form-control" id="username"  placeholder="UserName">
      </div>
      <div class="form-group m-2 p-2 h5 small">
      <?php $gender=$row['gender']; ?>
        <label for="username"><strong>Gender</strong></label>
        <?php if($gender == "") { ?>
        <div class="form-check form-check-inline m-2 p-2">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Male">
          <label class="form-check-label" for="inlineRadio1">Male</label>
        </div>
        <div class="form-check form-check-inline m-2 p-2">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Female">
          <label class="form-check-label" for="inlineRadio2">Female</label>
        </div>
        <?php } ?>
        <?php if($gender == "Male") { ?>
        <div class="form-check form-check-inline m-2 p-2">
          <input class="form-check-input" checked type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Male">
          <label class="form-check-label" for="inlineRadio1">Male</label>
        </div>
        <div class="form-check form-check-inline m-2 p-2">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Female">
          <label class="form-check-label" for="inlineRadio2">Female</label>
        </div>
        <?php } ?>
        <?php if($gender == "Female") { ?>
        <div class="form-check form-check-inline m-2 p-2">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Male">
          <label class="form-check-label" for="inlineRadio1">Male</label>
        </div>
        <div class="form-check form-check-inline m-2 p-2">
          <input class="form-check-input" checked type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Female">
          <label class="form-check-label" for="inlineRadio2">Female</label>
        </div>
        <?php } ?>
      </div>
      <input type="hidden" name="userid" value="<?php echo $id; ?>" />
      <center><button type="submit" name="change_profile" class="btn btn-primary m-2"><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;&nbsp; Save Changes</button></center>
    <?php } ?>
    </form>
  </div>



  <div class="tab-pane fade container" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
    <form action="index.php" method="post">
      <div class="form-group m-2 p-2 h5 small">
        <label for="OldPassword1">Old Password</label>
        <input type="password" name="oldpass" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
      <div class="form-group m-2 p-2 h5 small">
          <label for="NewexampleInputPassword1">New Password</label>
          <input type="password" name="newpass" class="form-control" id="NewOldexampleInputPassword1" placeholder="Password">
      </div>
      <div class="form-group m-2 p-2 h5 small">
          <label for="CNexampleInputPassword1">Conform New Password</label>
          <input type="password" name="cnewpass" class="form-control" id="CNexampleInputPassword1" placeholder="Password"> 
      </div>
      <input type="hidden" name="userid" value="<?php echo $id; ?>" />
      <center><button type="submit" name="change_password" class="btn btn-primary m-2"><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;&nbsp; Save Changes</button></center>
    </form>
  </div>



  <div class="tab-pane fade container" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
    <form action="action.php" method="post">
      <div class="form-group m-2 p-2 h5 small">
        <label for="access">Access</label><br>
        <?php if($values == 1) { ?>  
        <label class="switch"><input name="access" type="checkbox" checked id="togBtn"><div class="slider"><!--ADDED HTML --><span class="on">Private</span><span class="off">Public</span><!--END--></div></label>
        <?php } else { ?>
        <label class="switch"><input name="access" type="checkbox" id="togBtn"><div class="slider"><!--ADDED HTML --><span class="on">Private</span><span class="off">Public</span><!--END--></div></label>
        <?php } ?>
      </div>
      <center><button type="submit" name="save" class="btn btn-primary m-2"><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;&nbsp; Save Changes</button></center>
    </form>
  </div>


</div>

<?php
    include("Footer.php"); 
?>