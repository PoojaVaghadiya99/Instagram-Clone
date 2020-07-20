<?php 
   // connect to database
   $conn = mysqli_connect('localhost', 'root', '', 'instagram');
   
   // lets assume a user is logged in with id $user_id
   $user = new User($db);
   $user_id=$user->finduserid($_SESSION['email']);
   
   if (!$conn) {
     die("Error connecting to database: " . mysqli_connect_error($conn));
     exit();
   }
   
   // if user clicks like or dislike button
   if (isset($_POST['action'])) {
     $post_id = $_POST['post_id'];
     $action = $_POST['action'];
     switch ($action) {
         case 'like':
            if(userDisliked($post_id))
            {
              $sql2="DELETE FROM like_report WHERE userid=$user_id AND postid=$post_id AND rating_action='dislike'";
              mysqli_query($conn, $sql2);
            }
            $sql="INSERT INTO like_report (userid, postid, rating_action) 
                   VALUES ($user_id, $post_id, 'like') 
                   ON DUPLICATE KEY UPDATE rating_action='like'";
            break;
         case 'dislike':
          if(userliked($post_id))
            {
              $sql2="DELETE FROM like_report WHERE userid=$user_id AND postid=$post_id AND rating_action='like'";
              mysqli_query($conn, $sql2);
            }
             $sql="INSERT INTO like_report (userid, postid, rating_action) 
                  VALUES ($user_id, $post_id, 'dislike') 
                   ON DUPLICATE KEY UPDATE rating_action='dislike'";
            break;
         case 'unlike':
             $sql="DELETE FROM like_report WHERE userid=$user_id AND postid=$post_id AND rating_action='like'";
             break;
         case 'undislike':
               $sql="DELETE FROM like_report WHERE userid=$user_id AND postid=$post_id AND rating_action='dislike'";
         break;

         case 'save':
          $sql="INSERT INTO save_report (userid, postid) 
          VALUES ($user_id, $post_id) ";
           break;
          case 'unsave':
            $sql="DELETE FROM save_report WHERE userid=$user_id AND postid=$post_id";
            break;
         default:
             break;
     }
   
     // execute query to effect changes in the database ...
     mysqli_query($conn, $sql);
     echo getRating($post_id);
     exit(0);
   }
   
   // Get total number of likes for a particular post
   function getLikes($id)
   {
     global $conn;
     $sql = "SELECT COUNT(*) FROM like_report
               WHERE postid = $id AND rating_action='like'";
     $rs = mysqli_query($conn, $sql);
     $result = mysqli_fetch_array($rs);
     return $result[0];
   }
   
   // Get total number of dislikes for a particular post
   function getDislikes($id)
   {
     global $conn;
     $sql = "SELECT COUNT(*) FROM like_report 
               WHERE postid = $id AND rating_action='dislike'";
     $rs = mysqli_query($conn, $sql);
     $result = mysqli_fetch_array($rs);
     return $result[0];
   }
   
   // Get total number of likes and dislikes for a particular post
   function getRating($id)
   {
     global $conn;
     $rating = array();
     $likes_query = "SELECT COUNT(*) FROM like_report WHERE postid = $id AND rating_action='like'";
     $dislikes_query = "SELECT COUNT(*) FROM like_report WHERE postid = $id AND rating_action='dislike'";
     $likes_rs = mysqli_query($conn, $likes_query);
     $dislikes_rs = mysqli_query($conn, $dislikes_query);
     $likes = mysqli_fetch_array($likes_rs);
     $dislikes = mysqli_fetch_array($dislikes_rs);
     $rating = [
         'likes' => $likes[0],
         'dislikes' => $dislikes[0]
     ];
     return json_encode($rating);
   }
   
   // Check if user already likes post or not
   function userLiked($post_id)
   {
     global $conn;
     global $user_id;
     $sql = "SELECT * FROM like_report WHERE userid=$user_id AND postid=$post_id AND rating_action='like'";
     $result = mysqli_query($conn, $sql);
     if (mysqli_num_rows($result) > 0) {
         return true;
     }else{
         return false;
     }
   }
   
   // Check if user already dislikes post or not
   function userDisliked($post_id)
   {
     global $conn;
     global $user_id;
     $sql = "SELECT * FROM like_report WHERE userid=$user_id AND postid=$post_id AND rating_action='dislike'";
     $result = mysqli_query($conn, $sql);
     if (mysqli_num_rows($result) > 0) {
         return true;
     }else{
         return false;
     }
   }

   function userSaved($post_id)
   {
     global $conn;
     global $user_id;
     $sql = "SELECT * FROM save_report WHERE userid=$user_id AND postid=$post_id";
     $result = mysqli_query($conn, $sql);
     if (mysqli_num_rows($result) > 0) {
         return true;
     }else{
         return false;
     }
   }

// // id,userid,pageid,date

// class Like
// { 
//     private $con;
//     // private like_report = "like_report";
	
//     public function __construct($db)
// 	{
// 		 $this->con = $db;
//     }

//     // Get total number of likes for a particular post
//     function getLikes($id)
//     {
//         // global $conn;
//         $sql = "SELECT COUNT(*) FROM like_report
//                 WHERE postid = $id AND rating_action='like'";
//         $rs = $this->con->runBaseQuery($sql);
//         $result = mysqli_fetch_array($rs);
//         return $result[0];
//         // $result = $this->con->runBaseQuery($sql);
//         // return $result;
//     }

//     // Get total number of dislikes for a particular post
//     function getDislikes($id)
//     {
//         // global $conn;
//         $sql = "SELECT COUNT(*) FROM like_report WHERE postid = $id AND rating_action='dislike'";
//         $rs = $this->con->runBaseQuery($sql);
//         // return $result[0];
//         // $rs = mysqli_query($conn, $sql);
//         $result = mysqli_fetch_array($rs);
//         return $result[0];
//     }

//     // Get total number of likes and dislikes for a particular post
//     function getRating($id)
//     {
//         // global $conn;
//         $rating = array();
        
//         $likes_query = "SELECT COUNT(*) FROM like_report WHERE postid = $id AND rating_action='like'";
//         $dislikes_query = "SELECT COUNT(*) FROM like_report WHERE postid = $id AND rating_action='dislike'";
        
//         $likes_rs = $this->con->runBaseQuery($likes_query);
//         $dislikes_rs = $this->con->runBaseQuery($dislikes_query);
        
//         $likes = mysqli_fetch_array($likes_rs);
//         $dislikes = mysqli_fetch_array($dislikes_rs);
//         $rating = [
//             'likes' => $likes[0],
//             'dislikes' => $dislikes[0]
//         ];
//         return json_encode($rating);
//     }

//     // Check if user already likes post or not
//     function userLiked($user_id,$post_id)
//     {
//         // global $conn;
//         // global $user_id;
//         $sql = "SELECT * FROM like_report WHERE userid=$user_id AND postid=$post_id AND rating_action='like'";
//         // $result = mysqli_query($conn, $sql);
//         $result = $this->con->runBaseQuery($sql);
        
//         if (mysqli_num_rows($result) > 0) {
//             return true;
//         }else{
//             return false;
//         }
//     }


//     // Check if user already dislikes post or not
//     function userDisliked($user_id,$post_id)
//     {
//         // global $conn;
//         // global $user_id;
//         $sql = "SELECT * FROM like_report WHERE userid=$user_id 
//                 AND postid=$post_id AND rating_action='dislike'";
//         $result = $this->con->runBaseQuery($sql);
        
//         if (mysqli_num_rows($result) > 0) {
//             return true;
//         }else{
//             return false;
//         }
//     }

//     function like($user_id,$post_id)
//     {
//         $sql="INSERT INTO like_report (userid, postid, rating_action) 
//                 VALUES ( $user_id , $post_id , 'like') 
//                 ON DUPLICATE KEY UPDATE rating_action='like'";
//         $result = $this->con->runBaseQuery($sql);
//         return $result;
//     }

//     function dislike($user_id,$post_id)
//     {
//         $sql="INSERT INTO like_report (userid, postid, rating_action) 
//                  VALUES ($user_id, $post_id, 'dislike') 
//                 ON DUPLICATE KEY UPDATE rating_action='dislike'";
//         $result = $this->con->runBaseQuery($sql);
//         return $result;
//     }

//     function unlike($user_id,$post_id)
//     {
//         $sql="DELETE FROM like_report WHERE userid=$user_id AND postid=$post_id";
//         $result = $this->con->runBaseQuery($sql);
//         return $result;
//     }

//     function undislike($user_id,$post_id)
//     {
//         $sql="DELETE FROM like_report WHERE userid=$user_id AND postid=$post_id";
//         $result = $this->con->runBaseQuery($sql);
//         return $result;
//     }
// }


?>

