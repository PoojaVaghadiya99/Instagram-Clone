<?php

// id,username,gender,email,password,img,access,follower,following,created,modified

session_start();

class User
{ 
    private $con;
    private $table_name = "user";
	
    public function __construct($db)
	{
         $this->con = $db;
	}
	
	
    
    function getusername($email)
    {
        $sql="select * from user where email='$email'";
        $a=$this->con->runBaseQuery($sql);
        if (mysqli_num_rows($a) == 1) 
        {
            while($row = mysqli_fetch_assoc($a)) 
            {
               return $row["username"];
            }
        }
    }

    function dateDiff($date)
    {
        
        date_default_timezone_set('Asia/Kolkata');
        $mydate= date("Y-m-d H:i:s");
        $theDiff="";
        // echo $mydate."<br>";
        // echo $date."<br><br><br>";
        //echo $mydate;//2014-06-06 21:35:55
        $datetime1 = date_create($date);
        $datetime2 = date_create($mydate);
        $interval = date_diff($datetime1, $datetime2);
        // echo $interval->format('%s Seconds %i Minutes %h Hours %d days %m Months %y Year    Ago')."<br>";
        $min=$interval->format('%i');
        $sec=$interval->format('%s');
        $hour=$interval->format('%h');
        $mon=$interval->format('%m');
        $day=$interval->format('%d');
        $year=$interval->format('%y');

        if($interval->format('%i%h%d%m%y')=="00000")
        {
            return $sec." Seconds Ago";
        } 
        else if($interval->format('%h%d%m%y')=="0000")
        {
            return $min." Minutes Ago";
        }
        else if($interval->format('%d%m%y')=="000")
        {          
            return $hour." Hours Ago";
        }
        else if($interval->format('%m%y')=="00")
        {
            return $day." Days Ago";
        }
        else if($interval->format('%y')=="0")
        {    
            return $mon." Months Ago";
        }
        else
        {    
            return $year." Years Ago";
        }

    }

    function getuserdata($id)
    {
        $sql = "SELECT * FROM " . $this->table_name . " where id=".$id;
        $result = $this->con->runBaseQuery($sql);
       	return $result;
    }

    function finduserid($email)
    {
        $sql="select id from user where email='$email'";
        $a=$this->con->runBaseQuery($sql);
        if (mysqli_num_rows($a) == 1) 
        {
            while($row = mysqli_fetch_assoc($a)) 
            {
               return  $row["id"];
            }
        }
    }

    function findusername($id)
    {
        $sql="select username from user where id='$id'";
        $a=$this->con->runBaseQuery($sql);
        if (mysqli_num_rows($a) == 1) 
        {
            while($row = mysqli_fetch_assoc($a)) 
            {
               return  $row["username"];
            }
        }
    }

    function profilephoto($userid)
    {
        $sql="select img from user where id='$userid'";
        $a=$this->con->runBaseQuery($sql);
        if (mysqli_num_rows($a) == 1) 
        {
            while($row = mysqli_fetch_assoc($a)) 
            {
               return  $row["img"];
            }
        }
    }

    function changepassword($new,$id)
    {
        $newpass=md5($new);
        
        $query = "UPDATE user SET password = ? WHERE id = ?";
        $paramType = "si";
        $paramValue = array($newpass,$id);
        $this->con->update($query, $paramType, $paramValue);
    }

    function changeuserinfo($username,$gender,$id)
    {
        $query = "UPDATE user SET username=? , gender=?  WHERE id = ?";
        $paramType = "ssi";
        $paramValue = array($username,$gender,$id);
        $this->con->update($query, $paramType, $paramValue);
    }

    function changeuserprofile($img,$id)
    {
        $query = "UPDATE user SET img=?  WHERE id = ?";
        $paramType = "si";
        $paramValue = array($img,$id);
        $this->con->update($query, $paramType, $paramValue);
    }

    function checkaccountaccess($id)
    {
        $sql="select access from user where id='$id'";
        $a=$this->con->runBaseQuery($sql);
        if (mysqli_num_rows($a) == 1) 
        {
            while($row = mysqli_fetch_assoc($a)) 
            {
               return  $row["access"];
            }
        }
    }

    // Make Account Private

    function makeprivate($id)
    {
        $query = "UPDATE user SET access=1 WHERE id = ?";
        $paramType = "i";
        $paramValue = array($id);
        $this->con->update($query, $paramType, $paramValue);
    }

    // Make Account Public

    function makepublic($id)
    {
        $query = "UPDATE user SET access=0 WHERE id = ?";
        $paramType = "i";
        $paramValue = array($id);
        $this->con->update($query, $paramType, $paramValue);
    }

    // Register

    function ragister($username,$email,$password) 
	{
        $d="";
        $v=0;
        $p=md5($password); //encrypt Password
        $query = "insert into user (username,gender,email,password,img,access,follower,following,created,modified) VALUES (?,?,?,?,?,?,?,?,now(),now())";
        $paramType = "sssssiii";
        $paramValue = array($username,$d,$email,$p,$d,$v,$v,$v);
        $this->con->insert($query,$paramType,$paramValue);
       
            $_SESSION['email']=$email;
            $_SESSION['success']="Are You Now Login";
        
        
        if(isset($_SESSION['email']))
        {
            header('Location: Home.php');
        }
    }

    // Login
    
    function login($email,$password) 
	{
		$p=md5($password); //encrypt Password
        $query = "SELECT * FROM " . $this->table_name . " WHERE email=? AND password=?";
        $paramType = "ss";
        $paramValue = array($email,$p);
        $a=$this->con->runQuery($query,$paramType,$paramValue);
        
        if($a->num_rows==1)
        {
          $_SESSION['email']=$email;
          $_SESSION['success']="Are You Now Login";
          header('Location: Home.php');
        }
        else
        {
          header('Location: index.php');
        }
    }

    // Logout

    function logout() 
	{
        
        session_destroy();
        unset($_SESSION['username']);
        header('Location: login.php');
        
    }
	
}

?>

