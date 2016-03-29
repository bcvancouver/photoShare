<?php
    
    include ("PHPconnectionDB.php");
    sesstion_start();
    $user=$_SESSION['login_user'];
?>
<html>
    <body>
        <?php
       
        
        $connection=connect();
        
        $subject=$_POST['title'];
        $date=$_POST['datepicker'];
        $place=$_POST['keysearch'];
        $permitted=$_POST['privacy'];
        
        echo "The date=$date<br>";
        echo "The title is=$subject<br>";
        echo "The place is=$place<br>";
        echo "The permission is=$permitted<br>";
            
        //Check image file
        if(isset($_FILES['image'])){
              $errors= array();
              $file_name = $_FILES['image']['name'];
              $file_size =$_FILES['image']['size'];
              $file_tmp =$_FILES['image']['tmp_name'];
              $file_type=$_FILES['image']['type'];
              $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

              $expensions= array("jpeg","jpg","png","gif");

           if ($file_size==0){
                $errors[]="Plz select a file.";   
           }elseif(in_array($file_ext,$expensions)=== false){
                 $errors[]="extension not allowed, please choose a JPEG, PNG or GIF file.";
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
