<?php 
include("loggedIn.php"); 
include("PHPconnectionDB.php"); 


      if (isset ($_POST['validate'])){
            //get the input

            $user_name=$_SESSION["login_user"]; 
            $group_name=$_POST['group_name'];
            $member_name=$_POST["member_name"];  
      
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        
              //establish connection
              $conn=connect();
        if (!$conn) {
          $e = oci_error();
          trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    
              //sql command
              $sql = 'begin DELGROUPMEMBERPROC(:username, :memname, :groupname); end;';
        
        //Prepare sql using conn and returns the statement identifier
        $stid = oci_parse($conn, $sql);

        //bind the variables for the pl/sql procedure
        oci_bind_by_name($stid, ':username', $user_name);
        oci_bind_by_name($stid, ':groupname', $group_name);
        oci_bind_by_name($stid, ':memname', $member_name);
                
        //Execute a statement returned from oci_parse()
        $res=oci_execute($stid);
        
        
        //if error, retrieve the error using the oci_error() function & output an error message

          if (!$res) {
        $err = oci_error($stid); 
        echo htmlentities($err['message']);
          }
          else{
        header("location:groupManage.php");
          }
        
        // Free the statement identifier when closing the connection
        oci_free_statement($stid);
        oci_close($conn);
      
      // group_lists done by trigger
      }
  ?>