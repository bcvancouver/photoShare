 <?php include("loggedIn.php"); ?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../Image/favicon%20(1).ico">

    <title>ExclusivePic</title>

    <!-- Bootstrap core CSS -->
    <link href="../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="../dist/css/bootstrap-theme.min.css" rel="stylesheet">


    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body role="document">
      <!-- Fixed navbar -->
      <?php include("navi.php"); ?> 
    <div class="container">


<?php 

		function reformat_keywords($keywordsraw){
		    
			//split up the keywords
		    $keywords_array = (explode(' ', $keywordsraw));

		    // fix the key words with 's and ,s
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

		function reformatdate ($date){
		$date_arr = explode("-", $date);

		//just made my own translator
		switch ($date_arr[1]) {
			case '01': $mon = "-JAN-";	break;
			case '02': $mon = "-FEB-";	break;
			case '03': $mon = "-MAR-";	break;
			case '04': $mon = "-APR-";	break;
			case '05': $mon = "-MAY-";	break;
			case '06': $mon = "-JUN-";	break;
			case '07': $mon = "-JUL-";	break;
			case '08': $mon = "-AUG-";	break;
			case '09': $mon = "-SEP-";	break;
			case '10': $mon = "-OCT-";	break;
			case '11': $mon = "-NOV-";	break;
			case '12': $mon = "-DEC-";	break;
		}

		$retdate = "'".$date_arr[2] . $mon . $date_arr[0]."'";
		return $retdate;
	}

		function createsearchquery($keywords, $order, $start, $end){
			$username = "'".$_SESSION['login_user']."'";

			//The big query
			$sql = "SELECT DISTINCT photo_id, SCORE(1)*6+SCORE(2)*3+SCORE(3) AS SCORE, timing
			FROM images i, group_lists gl
			WHERE (CONTAINS (i.subject, ".$keywords.", 1) > 0 
				OR CONTAINS (i.place, ".$keywords.", 2) > 0 
				OR CONTAINS (i.description, ".$keywords.", 3) > 0
			    ) AND ((i.permitted = 1) 
					OR (i.owner_name=$username) 
					OR (gl.friend_id = $username AND i.permitted = gl.group_id)
					OR ($username='admin')) ";

			//Timing
			if ($start!="") {
				$begin = reformatdate($start);
				$sql = $sql."AND (timing >= ".$begin.") ";
			}
			if ($end!="") {
				$stop = reformatdate($end);
				$sql = $sql."AND (timing <= ".$stop.") ";
			}
			
 			//Ordering
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

	if (isset ($_GET['validate'])){


		$keywords = reformat_keywords($_GET["keywords"]);
		


		ini_set('display_errors', 1);
        error_reporting(E_ALL);
        
              //establish connection
              $conn=connect();
        if (!$conn) {
          $e = oci_error();
          trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    
        //sql command
        $sql = createsearchquery($keywords, $_GET["order"], $_GET["start"], $_GET["end"]);

        //Prepare sql using conn and returns the statement identifier
        $stid = oci_parse($conn, $sql);

        //Based off of http://php.net/manual/en/oci8.examples.php example #7
		oci_execute($stid);
        
		while ($arr = oci_fetch_array($stid, OCI_ASSOC)){
			$id = $arr['PHOTO_ID'];
			echo '<a href="display.php?id='.$id.'"><img src="getimage.php?id='.$id.'&type=thumbnail" width="200" height="200" /></a>';
		}

/**/
         
	} else {
		echo 'GET_validate not set';
	}
?>


    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
       <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
