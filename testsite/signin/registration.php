<?php
include("PHPconnectionDB.php");
?>
<html>
    <body>
       <?php
        
        if (isset ($_POST['validate'])){
            //get the input
            $user=$_POST['username'];
            $pswd=$_POST['password'];
            $fn=$_POST['firstname'];
            $ln=$_POST['lastname'];
            $address=$_POST['address'];
            $email=$_POST['email'];
            $phone=$_POST['phonenumber'];
            
            //if not all parts are filled, unsuccessful 
				if ($user==''or $pswd=='' or $fn=='' or $ln=='' or $address=='' or $email=='' or $phone==''){
				header("location:registration.html");	    
	    		exit;				
				}
				
	    ini_set('display_errors', 1);
	    error_reporting(E_ALL);
	    
            //establish connection
            $conn=connect();
	    if (!$conn) {
    		$e = oci_error();
    		trigger_error(htmlentities($e['Could not establish connection'], ENT_QUOTES), E_USER_ERROR);
	    }
 	///////////////////////////////////////////////////////////////////////////////////
 	//checking if username and password in system 
 		 $sql1='select count(*) from Users where user_name=\''.$user.'\' or password=\''.$pswd.'\'';
	    //Prepare sql using conn and returns the statement identifier
	    $stid = oci_parse($conn, $sql1);
	    
	    //Execute a statement returned from oci_parse()
	    $res=oci_execute($stid);
	    $r='1';
	    while ($row=oci_fetch_array($stid,OCI_BOTH)){$r= $row[0];}
	    //$row=oci_fetch_array($stid,OCI_BOTH)
	    oci_free_statement($stid);
	    oci_close($conn);
       // if username or password already exist in the database, error 
	    $result=FALSE;
	    if ($r!='0'){ $result=TRUE;}
	    if ($result){
	    	header("location:registration.html");
		 	echo "error";	    
	    	exit;
	    }
	    //insert into database 
	    else{
	    $sql2='insert into Users (user_name, password, date_registered) values (\''.$user.'\',\''.$pswd.'\',SYSDATE)';
 		 $sql3='insert into persons (user_name, first_name, last_name, address, email, phone) values (\''.$user.'\',\''.$fn.'\',\''.$ln.'\',\''.$address.'\',\''.$email.'\',\''.$phone.'\')';
	    $conn=connect();
	    execute_queries($conn, $sql2);
	    $conn=connect();
	    execute_queries($conn, $sql3);
	    
	    }
            header("location:signin.html");
	    //oci_close($conn);   
	}
	
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
	
	
	?>


	</body>

</html>