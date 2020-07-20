<?php
    include("Config/Connection.php");
    $db = new Database();
    include('Object/User.php');
    $user = new User($db);

    
    include("Header.php");

    $id=$user->finduserid($_SESSION['email']);

    $values=array();
    if($stmt=$db->runBaseQuery("select * from follow_report where userid='".$id."'"))
    {
        while($r=$stmt->fetch_array(MYSQLI_ASSOC))
        {
            $values[]=$r['pageid'];
        }
    }
?>

<script>
function unsub()
{
    var ans=confirm("Are You sure You want to unsubscribe !!");
    if(ans==true)
    {
        return true;
    }
    else
    {
        return false;
    }
    return false;
}

function sub()
{
    var ans=confirm("Are You sure You want to Subscribe !!");
    if(ans==true)
    {
        return true;
    }
    else
    {
        return false;
    }
    return false;
}
</script>
<style>
.active-pink-4 input[type=text]:focus:not([readonly]) {
  border: 1px solid #f48fb1;
  box-shadow: 0 0 0 1px #f48fb1;
}
.active-pink-3 input[type=text] {
  border: 1px solid #f48fb1;
  box-shadow: 0 0 0 1px #f48fb1;
}
.active-purple-4 input[type=text]:focus:not([readonly]) {
  border: 1px solid #ce93d8;
  box-shadow: 0 0 0 1px #ce93d8;
}
.active-purple-3 input[type=text] {
  border: 1px solid #ce93d8;
  box-shadow: 0 0 0 1px #ce93d8;
}
.active-cyan-4 input[type=text]:focus:not([readonly]) {
  border: 1px solid #4dd0e1;
  box-shadow: 0 0 0 1px #4dd0e1;
}
.active-cyan-3 input[type=text] {
  border: 1px solid #4dd0e1;
  box-shadow: 0 0 0 1px #4dd0e1;
}
</style>


<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#user tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>



<div class="container">

<div class="active-pink-4 mb-4">
  <input class="form-control" type="text" id="myInput" placeholder="Search" aria-label="Search">
</div>

<table class="table" id="user">
    

<?php
   // $c=0;
    if($stmt=$db->runBaseQuery("select * from user where id!=".$id))
    {
        while($r=$stmt->fetch_array(MYSQLI_ASSOC))
        {
           // $c++;
?>
            <tr>
                <td>
                <?php if($r['img'] == "") { ?>
                  <img src="./Src/Img/c.png" class="post-avatar">
                <?php } else { ?>
                  <img src="<?php echo $r['img']; ?>" class="post-avatar">
                <?php } ?>
                <!-- <img src="<?php echo $r['img']; ?>" class="post-avatar"> -->
                </td>
                <td><?php echo $r['username'] ?></td>
                <?php
                    if(in_array($r['id'],$values))
                    {
                ?>
                    <td>
                        <a href="index.php?action=follow_report&userid=<?php echo $id; ?>&pageid=<?php echo $r['id']; ?>&follow=<?php echo $r['follower']; ?>" onClick="return unsub();"><?php echo "UnFollow"; ?></a>
                    </td>
                <?php
                    }
                    else
                    {
                ?>
                    <td>
                        <a href="index.php?action=follow_report&userid=<?php echo $id; ?>&pageid=<?php echo $r['id']; ?>" onClick="return sub();"><?php echo "Follow"; ?></a>
                    </td>
                <?php
                    }
                ?>
            </tr>
        <?php
        }
    } 
?>
</table>
</div>

<?php
    include("Footer.php");
?>