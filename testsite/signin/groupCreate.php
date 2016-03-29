<?php session_start();
include("PHPconnectionDB.php"); 


      if (isset ($_POST['validate'])){
            //get the input
            $group_name=$_POST['group_name'];
            $user_name=$_SESSION["username"];  //Might get renamed   needs a check
      
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        
              //establish connection
              $conn=connect();
        if (!$conn) {
          $e = oci_error();
          trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    
              //sql command
              $sql = 'INSERT INTO groups VALUES (seq_group_id.nextVal,\''.$user_name.'\',\''.$group_name.'\',sysdate)'; 
        
        //Prepare sql using conn and returns the statement identifier
        $stid = oci_parse($conn, $sql );
        
        //Execute a statement returned from oci_parse()
        $res=oci_execute($stid);

        
        //if error, retrieve the error using the oci_error() function & output an error message

          if (!$res) {
        $err = oci_error($stid); 
        echo htmlentities($err['message']);
          }
          else{
        echo 'Row inserted';
          }
        
        // Free the statement identifier when closing the connection
        oci_free_statement($stid);
        oci_close($conn);
      
      }
  ?>