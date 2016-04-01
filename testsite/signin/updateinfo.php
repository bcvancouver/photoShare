<?php
      //////////////////////get user's information///////////////////////////
			include("PHPconnectionDB.php");
			session_start();
	      $conn=connect();
           $user=$_SESSION['login_name'];
          $a = $_POST['firstname'];
          $b = $_POST['lastname'];
          $c = $_POST['address'];
          $d = $_POST['email'];
          $e = $_POST['phonenumber'];
    
            $sql = 'update persons set first_name = \''.$a.'\', last_name = \''.$b.'\', address = \''.$c.'\', email = \''.$d.'\',phone  = \''.$e.'\' 
            where user_name = \''.$user.'\'';
            $stid = oci_parse($conn, $sql);        
            //Execute a statement returned from oci_parse()
            $res=oci_execute($stid);
	      
	      if (!$conn) {
    		$e = oci_error();
    		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	    }
			
        execute_queries($conn,$sql);
	    oci_free_statement($stid);
	    oci_close($conn);			

function execute_queries($conn, $sql)	{
		 
		 $stid = oci_parse($conn, $sql);
		 echo "the conn is $conn ";
	    echo "inserting $sql \n";
	    //Execute a statement returned from oci_parse()
	    $res=oci_execute($stid);
	    if (!$res) {
		 $err = oci_error($stid); 
		 echo htmlentities($err['message']);
		 
	    }
	    oci_free_statement($stid);
	    oci_close($conn);
}
	    
//header("location: main.php");// Redirecting back to log in page
        
?>