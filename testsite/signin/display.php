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

</head>
<style type="text/css">
    #chickenbutt {
</style>
<body>
    <div id="contenedor">
        <div id="cabecera">
            <div id="logo">
                <h1><a id="top" href="mainpage.html">PHOTOSHARE</a></h1>
            </div>
            <div id="nav">
                <ul>
                    <li><a href="mainpage.html">HOME</a></li>
                    <li><a href="profilepage.php">PROFILE</a></li>
                    <li><a href="search.html">SEARCH</a></li>
                    <li><a href="new_index.html">LOGOUT</a></li>
                </ul>
            </div>
            <div id="search_form">
                <form action="search.php" method="get"><input name="s" type="text" size="9" maxlength="30">
                </form>
            </div>
        </div>
  <script>
  $(function() {
    $( "#date" ).datepicker();
  });
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
                try {//COUNTS DISTINCT USER VIEWS
                    $user_name = $_SESSION['user-name'];                    
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
                $sql = "select s.group_id, s.group_name from group_lists g,images i,groups s where i.photo_id = '".$id."' and g.friend_id = i.owner_name and s.group_id = g.group_id union select group_id, group_name from groups where group_id = 1 or group_id = 2";
                $fin  = "";
    		    $stid = oci_parse($conn,$sql);
    		    $res = oci_execute($stid);
    		    while (($row = oci_fetch_array($stid, OCI_ASSOC))) {
                    $selected = "";
                    if ($arr['PERMITTED'] == $row['GROUP_ID']) {$selected = "selected";}
    		        $fin.='<option value="'.$row['GROUP_ID'].'" '.$selected.'>'.$row['GROUP_NAME'].'</option>';
				    }
            oci_close($conn);
			?>
        </div>
        <div id="update">
            <form >
				<fieldset class="form-group" >
                <label for="exampleTextarea">Subject</label>
                <textarea class="form-control" name="subj" rows="1"
                    placeholder='<?php echo $arr["SUBJECT"];?>' value='<?php echo $arr["SUBJECT"];?>'></textarea>
                </fieldset>
               	<fieldset class="form-group" >
                <label for="exampleTextarea">Place</label>
                <textarea class="form-control" name="place" rows="1"
                    placeholder='<?php echo $arr["PLACE"];?>' value='<?php echo $arr["PLACE"];?>'></textarea>
                </fieldset>
               	<fieldset class="form-group" >
                <label for="exampleTextarea">Timing/When</label>
                <input class="form-control date" name="date" id="date" rows="1"
                    placeholder='<?php echo $arr["TIMING"];?>' ></input>
                </fieldset>
                <fieldset class="form-group" >
                <label for="exampleTextarea">Description</label>
                <textarea class="form-control" name="desc" rows="3"
                    placeholder='<?php echo $arr["DESCRIPTION"];?>' value='<?php echo $arr["DESCRIPTION"];?>'></textarea>
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
                <button type="submit" name="edit" value="true" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <form >
        <input type="hidden" name="id" value="<?php echo $id; ?>">
          <button type="submit" name="delete" value="true" class="btn btn-primary">Delete Photo</button>
        </form>
        <br>
        <div id="pie">
            <div id="pie_l">
                <ul>
                    <li><a href="mainpage.html">HOME</a></li>
                </ul>
            </div>
            <div id="pie_r">
                <a href="#">UP <span class="up">↑</span></a>
            </div>
        </div>
    </div>
</body>
</html>