
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
        <form name="updateinfo" method="post" action="updateinfo.php" autocomplete="off">
            First Name : <input type="text" name="firstname"/><br/>
            Last Name : <input type="text" name="lastname"/><br/>
            Address : <input type="text" name="address"/><br/>
            Email : <input type="text" name="email"/><br/>
            Phone Number : <input type="text" name="phonenumber"/><br/>
            <input type="submit" name="validate" value="Update Info"/>
        </form>
                <?php echo "<a href='admin.php'>Admin</a>" ?>   <br> 
            

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
