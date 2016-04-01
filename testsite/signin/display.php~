<?php include("loggedIn.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="st1.css">
    <link rel="stylesheet" type="text/css" href="lightview.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style></style>
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
<style type="text/css">
    #chickenbutt {
</style>
<body>
  <script>
  $(function() {
    $( "#date" ).datepicker();
  });
  </script>
        <script type="text/javascript">
            function fivethumb(str) {
                $("#demo").html("");
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var txt = xmlhttp.responseText;
                        $("#demo").html(txt);
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
            if (!isset($_SESSION['login_user'])) { //checks if there's a user
                die();
            }
            
    
            $id = $_GET['id'];
            include("PHPconnectionDB.php");
            $conn=connect();
            //DELETES IMAGE
            if (isset($_REQUEST['delete'])) {
            $query = "delete FROM photo_visit where photo_id = '".$id."'";
              $stmt = oci_parse ($conn, $query);
              $res = oci_execute($stmt);         
              $query = "delete FROM images where photo_id = '".$id."'";
              $stmt = oci_parse ($conn, $query);
              $res = oci_execute($stmt);         
              header("Location: ./main.php");
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
            $user_name = $_SESSION['login_user'];                           
                try {//COUNTS DISTINCT USER VIEWS
                    $query = "select * from photo_visit where owner_name = '$user_name' and photo_id = '$id'";
                    $stmt = oci_parse ($conn, $query);              
                    oci_execute($stmt);
                    $res = oci_fetch_array($stmt);
                    if (!$res['PHOTO_ID']) {
                        $query = "INSERT into photo_visit(owner_name,photo_id) 
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
                echo '<img src="getimage.php?id='.$id.'&type=photo" />';
                
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
                elseif ($user_name == 'admin') {
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
         elseif ($user_name == 'admin') {
                     echo '<button type="submit" name="delete" value="true" class="btn btn-primary">Delete Photo</button>';
                }
                oci_close($conn);
                ?>
        </form>

    </div>
</body>
</html>