<?php include("loggedIn.php"); ?> 
<?php
      //////////////////////get user's information///////////////////////////
			include("PHPconnectionDB.php");
			session_start();
	      $conn=connect();
           $user=$_SESSION['login_user'];
          $up = $_POST['update'];
          $a = $_POST['first'];
          $b = $_POST['last'];
          $c = $_POST['addr'];
          $d = $_POST['email'];
          $e = $_POST['phone'];
          if ($up) {
            $sql = 'update persons set first_name = \''.$a.'\', last_name = \''.$b.'\', address = \''.$c.'\', email = \''.$d.'\',phone  = \''.$e.'\' 
            where user_name = \''.$user.'\'';
            $stid = oci_parse($conn, $sql);        
            //Execute a statement returned from oci_parse()
            $res=oci_execute($stid);
          }
	      
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
	    /////////////////////end get user's info///////////////////////////////
?>
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


      <h1><font color="white">My Exclusive Pic<br></font></h1>
        <form action="uploadfrontend.php">
            <input type="submit" value="Upload a picture"><br/>
        </form>
        <h3> <form method="post">
                <?php
                    echo "<font color='white'>Welcome Back $user !</font>";
                    echo "<br><font color='white'>First name: </font><input name='first' value='$firstname'>";
                    echo "<br><font color='white'>Last name: </font><input name='last' value='$lastname'>";
                    echo "<br><font color='white'>Address: </font><input name='addr' value='$address'>";
                    echo "<br><font color='white'>Email: </font><input name='email' value='$email'>";
                    echo "<br><font color='white'>Phone: </font><input name='phone' value='$phone'>";?>
                    <input type="submit" name="update" value="Update Info"> </form><br>
                    </h3>
                <?php
                    if($user == 'admin'){
                    echo "<a href='admin.php'>Admin</a><br>";}
                ?>
            

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

 
<script type="text/javascript">
            function loadDoc(str) {
                $("#demo").html("");
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var txt = xmlhttp.responseText;
                        $("#demo").html(txt);
                    }
                };
                var thumb = "thumb.php";
                if (location.search) thumb += location.search + "&" + str;
                else {
                    thumb += "?" + str;
                }
                xmlhttp.open("GET", thumb, true);
                xmlhttp.send();
            };
            loadDoc("main=true");            
            function loadDoc2(str) {
                $("#demo").html("");
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var txt = xmlhttp.responseText;
                        $("#demo").html(txt);
                    }
                };
                var thumb = "thumb.php";
                if (location.search) thumb += location.search + "&option=" + str;
                else {
                    thumb += "?n=" + str;
                }
                xmlhttp.open("GET", thumb, true);
                xmlhttp.send();
            };
            //popularity of an image is specified by the number of distinct users that have ever viewed the image
        </script>

        <font color='white'><h2>Image Gallery</h2></font>   
        <form id="gform" action="thumb.php" method="get" name="jumpto">
                    <select name="c" onchange="javascript: loadDoc2(this.value);">
                    <option value="0">Own photos</option>
                    <option value="1">Most Recent</option>
                    <option value="2">Oldest</option>
                    <option value="3">Top Five</option>
                    <option value="admin">Admin--only admin will work</option>
            </select>
      </form>
  <div id="demo" class="column">
      

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
