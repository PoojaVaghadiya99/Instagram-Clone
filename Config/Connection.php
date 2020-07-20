<?php

class Database
{
  
    private $host = "localhost";
    private $db_name = "instagram";
    private $username = "root";
    private $password = "";
    public $conn;
	
	function __construct()
	{
		$this->conn=$this->getConnection();
	}
  
    public function getConnection()
	{  
        $this->conn = null;  
        try
		{
            $this->conn = new mysqli($this->host,$this->username,$this->password,$this->db_name);
        }
		catch(Exception $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
	
	function countrow()
	{
        $query = "SELECT id FROM " . $this->table_name . "";
 
    	$stmt = $this->conn->query($query );
    	$num = $stmt->num_rows;
 
    	return $num;
    }
	
	function runBaseQuery($query)
	{
		$result=$this->conn->query($query);
		return $result;
	}

	function runBaseQuery1($query)
	{
		$this->conn->query($query);
	}
	
	function runQuery($query, $param_type, $param_value_array) 
	{
        $sql = $this->conn->prepare($query);
        $this->bindqueryparams($sql, $param_type, $param_value_array);
        $sql->execute();
        $result = $sql->get_result();
		return $result;
    }
	
	function bindqueryParams($sql, $param_type, $param_value_array) 
	{
       $param_value_reference[] = & $param_type;
        for($i=0; $i<count($param_value_array); $i++) 
		{
            $param_value_reference[] = & $param_value_array[$i];
        }
        call_user_func_array(array(
            $sql,
            'bind_param'
        ), $param_value_reference);
    }
	
	function insert($query,$param_type,$param_value_array)
	{
		$sql=$this->conn->prepare($query);
		$this->bindqueryParams($sql,$param_type,$param_value_array);
		$sql->execute();
		
	}

	function update($query,$param_type,$param_value_array)
	{
		$sql=$this->conn->prepare($query);
		$this->bindqueryParams($sql,$param_type,$param_value_array);
		$sql->execute();
	}

	function select($query,$param_type,$param_value_array)
	{
		$sql=$this->conn->prepare($query);
		$this->bindqueryParams($sql,$param_type,$param_value_array);
		$sql->execute();
	}
}

?>