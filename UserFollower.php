<?php
    include("Config/Connection.php");
    $db = new Database();
    include('Object/User.php');
    $user = new User($db);
    include('Object/Report.php');
    $report = new Report($db);

    // Get UserID By User EmailID 
    $userid=$user->finduserid($_SESSION['email']);
?>
<div class="container">
    <table class="table">
        <?php
            // User Follower List
            $report->findfollower($userid);
        ?>
    </table>
</div>

