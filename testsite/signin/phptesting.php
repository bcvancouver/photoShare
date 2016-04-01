<?php 
		function reformat_keywords($keywordsraw){
		    //get the input

		    $keywords_array = (explode(' ', $keywordsraw));

		    $keywords = '\'';
		    foreach ($keywords_array as $key => $value) {
		    	if ($key > 0) {
		       		$keywords = $keywords . ', ';
		       	}
		       	$keywords = $keywords . $value;
		    }
		    $keywords = $keywords.'\'';
		    return $keywords;
		}

		function createsearchquery($order, $start, $end){


			switch ($order) {
				case 'norm':
					$sql = "SELECT SCORE(1)*6+SCORE(2)*3+SCORE(3) AS SCORE, photo_id
					FROM images i, group_lists gl
					WHERE (CONTAINS (i.subject, ".$keywords.", 1) > 0 
				   		OR CONTAINS (i.place, ".$keywords.", 2) > 0 
				   		OR CONTAINS (i.description, ".$keywords.", 3) > 0
				   	   ) AND";
					break;
				default :
					$sql = "SELECT photo_id from images WHERE";
			}

			/*
			if ($start!="") {
				$sql = $sql."(timing >= ".$start.") AND";
			}
			if ($start!="") {
				$sql = $sql."(timing <= ".$start.") AND";
			}
			*/

			/*
			    $sql = 'SELECT SCORE(1)*6+SCORE(2)*3+SCORE(3) AS SCORE, photo_id
				FROM images i, group_lists gl
				WHERE (CONTAINS (i.subject, keywords, 1) > 0 
			   		OR CONTAINS (i.place, keywords, 2) > 0 
			   		OR CONTAINS (i.description, keywords, 3) > 0
			   	   )
			 --OR (timing >= '01-DEC-90' AND timing <= '01-JAN-16')
			--AND (timing >= '01-JAN-16' AND timing <= '01-JAN-16')
			ORDER BY SCORE desc'
			  */
			$sql = $sql . " ((i.permitted = 1) 
							OR (i.owner_name=$username) 
							OR (gl.friend_id = $username AND i.permitted = gl.group_id)) ";
 			
 			switch ($order) {
				case 'norm':
 					$sql = $sql . "ORDER BY SCORE desc";
 					break;
				case 'new':
 					$sql = $sql . "ORDER BY timing desc";
 					break;
				case 'old':
 					$sql = $sql . "ORDER BY timing asc";
 					break;
 			}

 			return $sql;
		}



include('PHPconnectionDB.php');
session_start();
	if (isset ($_POST['validate'])){
		
		$username = $_SESSION['login_user'];

		print_r($_POST["keywords"]."<br>".$_POST["order"]."<br>".$username."<br>");

		$keywords = reformat_keywords($_POST["keywords"]);
		


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
        $sql = createsearchquery($_POST["order"], $_POST["start"], $_POST["end"]);

		print_r("<br>".$keywords."<br>".$sql."<br>");
        //Prepare sql using conn and returns the statement identifier
        $stid = oci_parse($conn, $sql );
/*
        //bind the variables for the pl/sql procedure
        oci_bind_by_name($stid, ':username', $username);
        oci_bind_by_name($stid, ':keywords', $keywords);
*/              
        //Based off of http://php.net/manual/en/oci8.examples.php example #7
		oci_execute($stid);
        
        print_r($sql);
        echo "<table border='1'>\n";
		while (($row = oci_fetch_array($stid, OCI_ASSOC))) {
		    $rc = $row['MFRC'];
		    oci_execute($rc);  // returned column value from the query is a ref cursor
		    print_r($rc.'<br>');
		    while (($rc_row = oci_fetch_array($rc, OCI_ASSOC))) {   
		        echo "<tr>";
		        echo"<td>" . $rc_row['SUBJECT'] . "</td>";
		        echo"</tr>";
		    }
		    oci_free_statement($rc);
		}
		echo "</table>\n";


/**/
         
	} else {
		echo 'post_validate not set';
	}
?>