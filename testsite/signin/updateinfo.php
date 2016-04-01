<?php
      //////////////////////get user's information///////////////////////////
			include("PHPconnectionDB.php");
			session_start();
	      $conn=connect();
           $user=$_SESSION['login_name'];
          $a = $_POST['first'];
          $b = $_POST['last'];
          $c = $_POST['addr'];
          $d = $_POST['email'];
          $e = $_POST['phone'];
    print($a);
    
            $sql = 'update persons set first_name = \''.$a.'\', last_name = \''.$b.'\', address = \''.$c.'\', email = \''.$d.'\',phone  = \''.$e.'\' 
            where user_name = \''.$user.'\'';
            $stid = oci_parse($conn, $sql);        
            //Execute a statement returned from oci_parse()
            $res=oci_execute($stid);
	      
	      if (!$conn) {
    		$e = oci_error();
    		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	    }
			//echo "hello $user";
			
			$sql='select * from Persons where user_name=\''.$user.'\'';
			//echo $sql;
	    //Prepare sql using conn and returns the statement identifier
	    $stid = oci_parse($conn, $sql);
	    
	    //Execute a statement returned from oci_parse()
	    $res=oci_execute($stid);
	    
	    while ($row=oci_fetch_array($stid,OCI_BOTH)){
	    	//echo "good";
	    	$username= $row[0]; 
	    	$firstname=$row[1];
	    	$lastname=$row[2];
	    	$address=$row[3];
	    	$email=$row[4];
	    	$phone=$row[5];
	    	}
	    //$row=oci_fetch_array($stid,OCI_BOTH)
	    oci_free_statement($stid);
	    oci_close($conn);			
	    header("location: main.php");// Redirecting back to log in page
        
?>