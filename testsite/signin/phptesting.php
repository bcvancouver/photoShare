<?php 
include('PHPconnectionDB.php');
session_start();
	if (isset ($_POST['validate'])){
	    //get the input
	    $keywordsraw=$_POST["keywords"]; 
	    $username = $_SESSION['login_user'];

	    $keywords_array = (explode(' ', $keywordsraw));

	    $keywords = '\'';
	    foreach ($keywords_array as $key => $value) {
	    	if ($key > 0) {
	       		$keywords = $keywords . ', ';
	       	}
	       	$keywords = $keywords . $value;
	    }
	    $keywords = $keywords.'\'';

	    print_r($username.', '.$keywords);
	    echo "<br>";

		ini_set('display_errors', 1);
        error_reporting(E_ALL);
        
              //establish connection
              $conn=connect();
        if (!$conn) {
          $e = oci_error();
          trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    
        //sql command
        $sql = "SELECT SEARCHBASIC(:username, :keywords) AS mfrc FROM dual"; 
        
        //Prepare sql using conn and returns the statement identifier
        $stid = oci_parse($conn, $sql );

        //bind the variables for the pl/sql procedure
        oci_bind_by_name($stid, ':username', $username);
        oci_bind_by_name($stid, ':keywords', $keywords);
              
        //Based off of http://php.net/manual/en/oci8.examples.php example #7
		oci_execute($stid);
        
        echo "<table border='1'>\n";
		while (($row = oci_fetch_array($stid, OCI_ASSOC))) {
		    $rc = $row['MFRC'];
		    oci_execute($rc);  // returned column value from the query is a ref cursor
		    print_r($rc.'<br>');
		    while (($rc_row = oci_fetch_array($rc, OCI_ASSOC))) {   
		        echo "<tr>"
		        echo"<td>" . $rc_row['SUBJECT'] . "</td>"
		        echo"</tr>";
		    }
		    oci_free_statement($rc);
		}
		echo "</table>\n";



         
	} else {
		echo 'post_validate not set';
	}
?>