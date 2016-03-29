<?php
include("connection_database.php");
?>
<html>
    <body>
       <?php
        
        if (isset ($_POST['validate'])){
            //get the input
            $user=$_POST['username'];
            $pswd=$_POST['password'];
            //if($user==''||$pswd==''){echo 'error';}
			
	    ini_set('display_errors', 1);
	    error_reporting(E_ALL);
	    
            //establish connection
            $conn=connect();
	    if (!$conn) {
    		$e = oci_error();
    		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	    }
 	///////////////////////////////////////////////////////////////////////////////////
 	//checking if username and password in system 
 		 $sql='select count(*) from Users where user_name=\''.$user.'\' and password=\''.$pswd.'\'';
 		 //$sql='select count(*) from Users where user_name=\''.$user.'\'';
 		          
	    echo $sql;
	    //Prepare sql using conn and returns the statement identifier
	    $stid = oci_parse($conn, $sql);
	    
	    //Execute a statement returned from oci_parse()
	    $res=oci_execute($stid);
	    $r='1';
	    while ($row=oci_fetch_array($stid,OCI_BOTH)){$r= $row[1];}
	    //$row=oci_fetch_array($stid,OCI_BOTH)
	    //echo $r;
	    oci_free_statement($stid);
	    oci_close($conn);
	    echo "r is $r";
      
	    $result=FALSE;
	    if ($r=='0'){ $result=TRUE;}
	    echo $result;
	    if ($result){
	    	header("location:http://consort.cs.ualberta.ca/~jianle/database_site/391_photoshare/new_index.html");
		 	echo "error";	    
	    	exit;
	    }
	    
	    echo "good good";
	    
	    
	    
	    //if error, retrieve the error using the oci_error() function & output an error message
/*
	    if (!$res) {
		$err = oci_error($stid); 
		echo htmlentities($err['message']);
	    }
	    else{
		echo 'Row inserted';
	    }
*/ 
	    // Free the statement identifier when closing the connection
	}
	?>
    </body>
</html>