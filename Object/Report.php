<?php

// id,userid,pageid,date

class Report
{ 
    private $conn;
    private $table_name = "follow_report";
	
    public function __construct($db)
	{
		 $this->conn = $db;
    }
	
	function addreport($userid,$pageid) 
	{
        $query = "INSERT INTO " . $this->table_name . " (userid,pageid,date) VALUES (?, ?,now())";
        $paramType = "ii";
        $paramValue = array($userid,$pageid);
        $this->conn->insert($query,$paramType,$paramValue);
        header("Location: Page.php");
    }
    
	function deletereport($userid,$pageid) 
	{
        $query = "DELETE FROM " . $this->table_name . " WHERE userid = ? AND pageid = ?";
        $paramType = "ii";
        $paramValue = array($userid,$pageid);
        $this->conn->update($query, $paramType, $paramValue);
        header("Location: Page.php");
    }

    function findfollowing($userid)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE userid = ?";
        $paramType = "i";
        $paramValue = array($userid);
        $a=$this->conn->runQuery($query, $paramType, $paramValue);
        
        if($a)
        {
            $c=mysqli_num_rows($a);
            if ($c > 0) 
            {
                while($row = mysqli_fetch_assoc($a)) 
                {
                    $query1 = "SELECT * FROM user WHERE id = ?";
                    $paramType1 = "i";
                    $paramValue1 = array($row["pageid"]);
                    $a1=$this->conn->runQuery($query1, $paramType1, $paramValue1);
                    if($a1)
                    {
                        $c1=mysqli_num_rows($a1);
                        if ($c1 > 0) 
                        {
                            while($row1 = mysqli_fetch_assoc($a1)) 
                            { 
                                ?>
                                    <tr><td> 
                                <?php
                                    echo  $row1["username"]; 
                                ?> 
                                    </td></tr> 
                                <?php
                            }
                        }
                    }
                }
            }
        }
        
      //  $this->totalfollowing($counter);
    }

    function findfollowingid($userid)
    {
        $data =array();
        $query = "SELECT * FROM " . $this->table_name . " WHERE userid = ?";
        $paramType = "i";
        $paramValue = array($userid);
        $a=$this->conn->runQuery($query, $paramType, $paramValue);
        
        if($a)
        {
            $c=mysqli_num_rows($a);
            if ($c > 0) 
            {
                while($row = mysqli_fetch_assoc($a)) 
                {
                    $query1 = "SELECT * FROM user WHERE id = ?";
                    $paramType1 = "i";
                    $paramValue1 = array($row["pageid"]);
                    $a1=$this->conn->runQuery($query1, $paramType1, $paramValue1);
                    if($a1)
                    {
                        $c1=mysqli_num_rows($a1);
                        if ($c1 > 0) 
                        {
                            while($row1 = mysqli_fetch_assoc($a1)) 
                            { 
                                $data[] = $row1["id"]; 
                                    
                               
                            }
                        }
                    }
                }
            }
        }
        return $data;
      //  $this->totalfollowing($counter);
    }

    function totalfollowing($userid)
    {
        $counter=0;
        $query = "SELECT * FROM " . $this->table_name . " WHERE userid = ?";
        $paramType = "i";
        $paramValue = array($userid);
        $a=$this->conn->runQuery($query, $paramType, $paramValue);
        
        if($a)
        {
            $c=mysqli_num_rows($a);
            if ($c > 0) 
            {
                while($row = mysqli_fetch_assoc($a)) 
                {
                    $counter++;
                }
            }
        }
        return $counter;
    }


    function findfollower($userid)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE pageid = ?";
        $paramType = "i";
        $paramValue = array($userid);
        $a=$this->conn->runQuery($query, $paramType, $paramValue);
        
        if($a)
        {
            $c=mysqli_num_rows($a);
            if ($c > 0) 
            {
                while($row = mysqli_fetch_assoc($a)) 
                {
                    $query1 = "SELECT * FROM user WHERE id = ?";
                    $paramType1 = "i";
                    $paramValue1 = array($row["userid"]);
                    $a1=$this->conn->runQuery($query1, $paramType1, $paramValue1);
                    if($a1)
                    {
                        $c1=mysqli_num_rows($a1);
                        if ($c1 > 0) 
                        {
                            while($row1 = mysqli_fetch_assoc($a1)) 
                            {
                                ?>
                                    <tr><td> 
                                <?php
                                    echo  $row1["username"];
                                ?> 
                                    </td></tr> 
                                <?php
                            }
                        }
                    }
                }
            }
        }
        
      //  $this->totalfollowing($counter);
    }

    function totalfollower($userid)
    {
        $counter=0;
        $query = "SELECT * FROM " . $this->table_name . " WHERE pageid = ?";
        $paramType = "i";
        $paramValue = array($userid);
        $a=$this->conn->runQuery($query, $paramType, $paramValue);
        
        if($a)
        {
            $c=mysqli_num_rows($a);
            if ($c > 0) 
            {
                while($row = mysqli_fetch_assoc($a)) 
                {
                    $counter++;
                }
            }
        }
        return $counter;
    }

}

?>

