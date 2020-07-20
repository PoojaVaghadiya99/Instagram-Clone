<?php
    include("Config/Connection.php");
    $db = new Database();
    include('Object/User.php');
    $user = new User($db);
    include('Object/Post.php');
    $post = new Post($db);

    // Get UserID By User EmailID 
    $userid=$user->finduserid($_SESSION['email']);
    $a=$post->findpost($userid);
?>


<div class="container">
    <table>
    
        <?php
           $c=mysqli_num_rows($a);
           if ($c > 0) 
           {
               while($row = mysqli_fetch_assoc($a)) 
               {
                   ?>
                        <div class="row justify-content-md-center">
                            <div class="col col-lg-10 col-md-12 col-12">
                                <img src="<?php echo $row['post_img']; ?>" class="img-fluid mb-1" height="300px" width="31%" />
                            </div>
                        </div>
                   <?php
               }
           }
        ?>    
    </table>
</div>

