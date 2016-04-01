<!DOCTYPE html>
<html lang="en">
<?php
session_start();
$user=$_SESSION['login_user'];

if ($user!="admin"){
    echo "<script>
        alert('You are kicked out because you are not admin. GG.!');
        location='signin.html';
    </script>";
}

include("PHPconnectionDB.php");

session_start();

function getTotalImageNum(){
    //session_start();
    $connect=connect();

    $sql='SELECT COUNT(*) AS NUMBER_OF_ROWS FROM images';
    $stmt = oci_parse($connect, $sql);
    oci_define_by_name($stmt, 'NUMBER_OF_ROWS', $number_of_rows);
    oci_execute($stmt);
    oci_fetch($stmt);

    oci_free_statement($stmt);
    return $number_of_rows;
}

function getTotalGroupNum(){
    //session_start();
    $connect=connect();

    $sql='SELECT COUNT(*) AS NUMBER_OF_ROWS FROM groups';
    $stmt = oci_parse($connect, $sql);
    oci_define_by_name($stmt, 'NUMBER_OF_ROWS', $number_of_rows);
    oci_execute($stmt);
    oci_fetch($stmt);

    oci_free_statement($stmt);
    return $number_of_rows;
}

function getTotalUserNum(){
    //session_start();
    $connect=connect();

    $sql='SELECT COUNT(*) AS NUMBER_OF_ROWS FROM users';
    $stmt = oci_parse($connect, $sql);
    oci_define_by_name($stmt, 'NUMBER_OF_ROWS', $number_of_rows);
    oci_execute($stmt);
    oci_fetch($stmt);

    oci_free_statement($stmt);
    return $number_of_rows;
}

function getTotalPersonNum(){
    $connect=connect();

    $sql='SELECT COUNT(*) AS NUMBER_OF_ROWS FROM persons';
    $stmt = oci_parse($connect, $sql);
    oci_define_by_name($stmt, 'NUMBER_OF_ROWS', $number_of_rows);
    oci_execute($stmt);
    oci_fetch($stmt);

    oci_free_statement($stmt);
    return $number_of_rows;
}
function getOptions($sql) {
    $connect=connect();
    $stid = oci_parse($connect,$sql);
    oci_execute($stid);
    while (($row = oci_fetch_array($stid, OCI_ASSOC))) {
        foreach($row as $item)   {
            echo '<option>'.$item.'</option>';
        }
    }
}

?>
<head>
<!--http://startbootstrap.com/template-overviews/sb-admin-2/-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Cheng Yao Hu" >
    <script src="admin.js"></script>

    <title>Admin Page</title>
    <link href="admin.css" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">ExclusivePic Admin Page</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Admin <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="main.php"><i class="fa fa-fw fa-gear"></i>My Gallery</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="signin.html" ><i class="fa fa-fw fa-gear" onclick="<?php session_destroy();?>"></i>Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo getTotalUserNum()?></div>
                                        <div>No of Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo getTotalImageNum()?></div>
                                        <div>No of Images</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <!--<div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>-->
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo getTotalGroupNum()?></div>
                                        <div>No of Groups</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <!--<div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>-->
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo getTotalPersonNum();?></div>
                                        <div>No of Persons</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <!--<div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>-->
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> OLAP Report</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group col-lg-4">
                                            <label>Users</label>
                                            <select id="user" class="form-control">
                                                <option>All</option>
                                                <option>None</option>
                                                <?php getOptions('SELECT user_name FROM users'); ?>
                                            </select>
                                        </div>
                                    <div class="form-group col-lg-4">
                                            <label>Subject</label>
                                            <select id="subj" class="form-control">
                                                <option>All</option>
                                                <option>None</option>
                                                <?php getOptions('SELECT DISTINCT subject FROM images',$connect); ?>
                                            </select>
                                        </div>
                                    <div class="form-group col-lg-4">
                                            <label>Period</label>
                                            <select id="period" class="form-control">
                                                <option>Year</option>
                                                <option>Month</option>
                                                <option>Week</option>
                                                <option>None</option>
                                            </select>
                                    </div>
                                <button class="btn btn-info btn-lg col-lg-12" onclick="ajaxgraph(this)">Graph</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Number of Images Chart</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-area-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
</body>



<script type="text/javascript">
function ajaxgraph(str) {
    $("#morris-area-chart").html("");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var txt = xmlhttp.responseText;
			
            $("#morris-area-chart").html(txt);


        }
    };
    var user = $('#user').find(":selected").text();
    var subj = $('#subj').find(":selected").text();
    var date = $('#period').find(":selected").text();
    xmlhttp.open("GET", "cube.php?user="+user+"&subj="+subj+"&date="+date, true);
    xmlhttp.send();

}

Morris.Area({
        element: 'morris-area-chart',
        data: [{
            period: '2010 Q1',
            iphone: 2666,
            ipad: null,
            itouch: 2647
        }, {
            period: '2010 Q2',
            iphone: 2778,
            ipad: 2294,
            itouch: 2441
        }, {
            period: '2010 Q3',
            iphone: 4912,
            ipad: 1969,
            itouch: 2501
        }, {
            period: '2010 Q4',
            iphone: 3767,
            ipad: 3597,
            itouch: 5689
        }, {
            period: '2011 Q1',
            iphone: 6810,
            ipad: 1914,
            itouch: 2293
        }, {
            period: '2011 Q2',
            iphone: 5670,
            ipad: 4293,
            itouch: 1881
        }, {
            period: '2011 Q3',
            iphone: 4820,
            ipad: 3795,
            itouch: 1588
        }, {
            period: '2011 Q4',
            iphone: 15073,
            ipad: 5967,
            itouch: 5175
        }, {
            period: '2012 Q1',
            iphone: 10687,
            ipad: 4460,
            itouch: 2028
        }, {
            period: '2012 Q2',
            iphone: 8432,
            ipad: 5713,
            itouch: 1791
        }],
        xkey: 'period',
        xLabels: 'month',
        ykeys: ['iphone', 'ipad', 'itouch'],
        labels: ['iPhone', 'iPad', 'iPod Touch'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

</script>

</html>
