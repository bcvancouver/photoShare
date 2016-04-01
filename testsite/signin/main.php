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
    <meta name="author" content="Wan Kin Vinson Lai" >
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
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="main.html">ExclusivePic</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="signin.html">Sign in</a></li>
                <li><a href="logout.php">Sign out</a></li>
                <li><a href="registration.html">Sign up</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">


      <h1><font color="white">Main Page<br></font></h1>
        <form action="uploadfrontend.php">
            <input type="submit" value="Upload a picture"><br/>
        </form>
        <h3> <form method="post">
                <?php echo "Username: $user"; ?><br>
                <?php echo "First name: <input name='first' value='$firstname'></input>"; ?> <br>
                <?php echo "Last name: <input name='last' value='$lastname'></input>"; ?>   <br>         
                <?php echo "Address: <input name='addr' value='$address'></input>"; ?>  <br>             
                <?php echo "Email: <input name='email' value='$email'></input>"; ?>  <br> 
                <?php echo "Phone: <input name='phone' value='$phone'></input>"; ?>   <br> 
                <input type="submit" name="update" value="Update Info"> </form> <br>
                </h3>    
                <?php echo "<a href='admin.php'>Admin</a>" ?>   <br> 
            

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

   </script>
        <script type="text/javascript">
            function fivethumb(str) {
                $("#chickenbutt").html("");
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var txt = xmlhttp.responseText;
                        $("#chickenbutt").html(txt);
                    }
                };
                xmlhttp.open("GET", "thumb.php?freq=" + str, true);
                xmlhttp.send();
            };
        </script>
        <div id="chickenbutt" class="text-center"><br>
          <?php
            if(!isset($_SESSION)) { //check if sessions has been initialized
                 session_start();   //initialize session
            }
            if (!isset($_SESSION['user-name'])) { //checks if there's a user
                die();
            }
			
	
			$id = $_GET['id'];
			include("connection_database.php");
			$conn=connect();
            //DELETES IMAGE
            if (isset($_REQUEST['delete'])) {
   	        $query = "delete FROM photo_count where photo_id = '".$id."'";
              $stmt = oci_parse ($conn, $query);
              $res = oci_execute($stmt);         
              $query = "delete FROM images where photo_id = '".$id."'";
              $stmt = oci_parse ($conn, $query);
              $res = oci_execute($stmt);         
              header("Location: ./mainpage.html");
              die();
            }
            //UPDATES IMAGE
            elseif (isset($_REQUEST['edit'])) {
              $query = "UPDATE images SET ";
              if (isset($_REQUEST['subj'])) $query.= " subject = '".$_REQUEST['subj']."',";
              if (isset($_REQUEST['date'])) $query.= " timing = TO_DATE('".$_REQUEST['date']."','MM/DD/YYYY'),";
              if (isset($_REQUEST['place'])) $query.= " place = '".$_REQUEST['place']."',";
              if (isset($_REQUEST['desc'])) $query.= " description = '".$_REQUEST['desc']."',";
              if (isset($_REQUEST['group'])) $query.= " permitted = '".$_REQUEST['group']."'";
              $query.=" WHERE photo_id='$id' ";
              $stmt = oci_parse ($conn, $query);
              oci_execute($stmt);
            }
            $user_name = $_SESSION['user-name'];                    		
                try {//COUNTS DISTINCT USER VIEWS
                    $query = "select * from photo_count where user_name = '$user_name' and photo_id = '$id'";
                    $stmt = oci_parse ($conn, $query);              
                    oci_execute($stmt);
                    $res = oci_fetch_array($stmt);
                    if (!$res['PHOTO_ID']) {
                        $query = "INSERT into photo_count(user_name,photo_id) 
                        values ( '$user_name','$id')";
                        $stmt = oci_parse ($conn, $query);              
                        oci_execute($stmt);                
                    }
                }
                catch (Exception $e) {}
                //DISPLAYS IMAGE
                $query = "SELECT * FROM images where photo_id = '$id'";
                $stmt = oci_parse ($conn, $query);
                oci_execute($stmt);
    			$arr = oci_fetch_array($stmt, OCI_ASSOC);
    			echo '<img src="pullimage.php?id='.$id.'&type=photo" />';
    			
                //GETS IMAGE GROUPS     
                $sql = "select s.group_id, s.group_name from group_lists g,images i,groups s where i.photo_id = '".$id."' and g.friend_id = i.owner_name and s.group_id = g.group_id 
                union select group_id, group_name from groups where group_id = 1 or group_id = 2 or user_name = '$user_name' ";
                $fin  = "";
    		    $stid = oci_parse($conn,$sql);
    		    $res = oci_execute($stid);
    		    while (($row = oci_fetch_array($stid, OCI_ASSOC))) {
                    $selected = "";
                    if ($arr['PERMITTED'] == $row['GROUP_ID']) {$selected = "selected";}
    		        $fin.='<option value="'.$row['GROUP_ID'].'" '.$selected.'>'.$row['GROUP_NAME'].'</option>';
				    }
			?>
        </div>
        <div id="update">
            <form >
				<fieldset class="form-group" >
                <label for="exampleTextarea">Subject</label>
                <textarea class="form-control" name="subj" rows="1"
                    placeholder='<?php echo $arr["SUBJECT"];?>' value='<?php echo $arr["SUBJECT"];?>'><?php echo $arr["SUBJECT"];?></textarea>
                </fieldset>
               	<fieldset class="form-group" >
                <label for="exampleTextarea">Place</label>
                <textarea class="form-control" name="place" rows="1"
                    placeholder='<?php echo $arr["PLACE"];?>' value='<?php echo $arr["PLACE"];?>'><?php echo $arr["PLACE"];?></textarea>
                </fieldset>
               	<fieldset class="form-group" >
                <label for="exampleTextarea">Timing/When</label>
                <input class="form-control date" name="date" id="date" rows="1"
                    placeholder='<?php echo $arr["TIMING"];?>' value='<?php $time = strtotime($arr["TIMING"]); echo date("m\/d\/Y",$time); ?>'></input>
                </fieldset>
                <fieldset class="form-group" >
                <label for="exampleTextarea">Description</label>
                <textarea class="form-control" name="desc" rows="3"
                    placeholder='<?php echo $arr["DESCRIPTION"];?>' value='<?php echo $arr["DESCRIPTION"];?>'><?php echo $arr["DESCRIPTION"];?></textarea>
                </fieldset>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="">
                    <label>
				      Permitted
				    </label>
				    <select class="c-select" name="group">
				        <?php echo $fin; ?>
					</select>
                </div>
                <?php
						$sql = "select * from images where photo_id = '$id' and owner_name = '$user_name' ";
 					 	$stmt = oci_parse ($conn, $sql);
            		$res = oci_execute($stmt); 
            		                     
 						$res = oci_fetch_array($stmt, OCI_ASSOC);    
						if ($res['OWNER_NAME'] == $user_name ) {
                	 echo '<button type="submit" name="edit" value="true" class="btn btn-primary">Submit</button>';
                }
                else if ($_SESSION['admin']) {
                	 echo '<button type="submit" name="edit" value="true" class="btn btn-primary">Submit</button>';
                }
                ?>
            </form>
        </div>
        <form >
        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <?php
						if ($res['OWNER_NAME'] == $user_name ) {
                	 echo '<button type="submit" name="delete" value="true" class="btn btn-primary">Delete Photo</button>';
                	 oci_free_statement($stmt);
                }
         else if ($_SESSION['admin']) {
                	 echo '<button type="submit" name="delete" value="true" class="btn btn-primary">Submit</button>';
                }
                oci_close($conn);
                ?>
        </form>
        <br>

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

  <h2>Image Gallery</h2>   
        <form id="gform" action="thumb.php" method="get" name="jumpto">
                    <select name="c" onchange="javascript: loadDoc2(this.value);">
                    <option value="0">Own photos</option>
                    <option value="1">Most Recent</option>
                    <option value="2">Oldest</option>
                    <option value="3">Top Five</option>
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
