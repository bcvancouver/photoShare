<?php
    include ("PHPconnectionDB.php");
?>
<html>
    <body>
        <?php
        $conn=connect();
        
        $subject=$_POST['title'];
        $date=$_POST['datepicker'];
        $place=$_POST['location'];
        $permitted=$_POST['privacy'];
        
        echo "The date=$date";
        echo "The title is=$title";
            
        //Check image file
        if(isset($_FILES['image'])){
              $errors= array();
              $file_name = $_FILES['image']['name'];
              $file_size =$_FILES['image']['size'];
              $file_tmp =$_FILES['image']['tmp_name'];
              $file_type=$_FILES['image']['type'];
              $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

              $expensions= array("jpeg","jpg","png","gif");

              if(in_array($file_ext,$expensions)=== false){
                 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
              }


              if(empty($errors)==true){
                 move_uploaded_file($file_tmp,"images/".$file_name);
                 echo "Success";
              }else{
                 print_r($errors);
              }
           }
            echo '<center><form method="post" action ="upload.html"><input type="submit" name="submit" value="continue" /> </form></center>';

        ?>
    </body>
</html>
