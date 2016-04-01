<?php include("loggedIn.php"); ?> 
<?php

function getGroups(){
    include("PHPconnectionDB.php");
    session_start();
    $user=$_SESSION["login_user"];
    $connect=connect();

    if ($user == 'admin') {
        $groups = '';
        $sql = 'SELECT g.group_id, g.group_name, g.user_name FROM groups g';
    }
    else {
        $groups = '<option value="2">private</option><option value="1">public</option>';
        $sql = 'SELECT g.group_id, g.group_name, g.user_name FROM groups g left outer join group_lists l on g.group_id=l.group_id WHERE g.user_name=\'' . $user . '\' or l.friend_id=\'' . $user . '\'';
    }
    $stid = oci_parse($connect, $sql);
    oci_execute($stid);
    while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $group_id = $row['GROUP_ID'];
        $group_name = $row['GROUP_NAME'];
        $group_owner = $row['USER_NAME'];
        $groups .= '<option value="'.$group_id.'">'.$group_name.' - ' . $group_owner .'</option>';
    }
    oci_free_statement($stid);
    oci_close($connect);
    return $groups;
}



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
    <script type="text/javascript" src="js/plupload.full.min.js"></script>
    
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
          <a class="navbar-brand" href="#">ExclusivePic</a>
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
                <li><a href="signin.html">Sign out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="image[]" multiple="multiple"/>
            <p ><b><font color="white">Picture Title:   </font></b><input type="text" id="title" name="title" placeholder=""></p>
            <p><b><font color="white">Picture Date: </font></b><input type="date" id="datepicker" name="datepicker" placeholder="YYYY-MM-DD"></p>
            <p><b><font color="white">Picture Location:</font> </b><input type="search" id="place" name="place" placeholder="location"></p>
            <p><b><font color="white">Comment: </font></b><input type="text" id="description" name="description" placeholder="Comment or Description"></p>

            <p><b><font color="white">Who can see?</font></b>
                <select name="privacy">
                    <?php
                        $groups=getGroups();
                        echo $groups;
                    ?>
                </select><br/>
            </p>
            
            <input type="submit"/>

        </form>

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
