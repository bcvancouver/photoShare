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

        <font color='white'>Create a Group:<br></font>
	      <form name="creategroup" method="post" action="groupCreate.php">
              <font color='white'>New Group Name : </font><input type="text" name="group_name"/> <br/>
          <input type="submit" name="validate" value="OK"/>
        </form>

        <br>
        <font color='white'><br>Add a Member to a Group you made:<br></font>
        <form name="addmember" method="post" action="groupAddMember.php">
            <font color='white'>Group Name : </font><input type="text" name="group_name"/> <br/>
            <font color='white'>New Member : </font><input type="text" name="member_name"/> <br/>
          <input type="submit" name="validate" value="OK"/>
        </form>
        
        <br>
        <font color='white'><br>Delete a Member from a Group you made:<br></font>
        <form name="delmember" method="post" action="groupDelMember.php">
            <font color='white'>Group Name : </font><input type="text" name="group_name"/> <br/>
            <font color='white'>New Member : </form><input type="text" name="member_name"/> <br/>
        </font>
          <input type="submit" name="validate" value="OK"/>
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
