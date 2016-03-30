<!DOCTYPE html>

<?php
    
    include ("PHPconnectionDB.php");
    session_start();
    $user=$_SESSION['login_user'];
?>
<html>
    <body>
        <?php
        
        $connection=connect();
        
        $subject=$_POST['title'];
        $date=$_POST['datepicker'];
        $place=$_POST['place'];
        $description=$_POST['description'];
        $permitted=$_POST['privacy'];
        $description=$_POST['description'];
        
        

        echo "The user is $user<br>";
        echo "The date $date<br>";
        echo "The title is $subject<br>";
        echo "The place is $place<br>";
        echo "The permission is $permitted<br>";
        
        //Function to turn picture into thumbnail
        function img_resize($target, $newcopy, $w, $h) {
            list($w_orig, $h_orig) = getimagesize($target);
            $scale_ratio = $w_orig / $h_orig;
            if (($w / $h) > $scale_ratio) {
                $w = $h * $scale_ratio;
            } else {
                $h = $w / $scale_ratio;
            }
            $img = imagecreatefromjpeg($target);
            $tci = imagecreatetruecolor($w, $h);
            imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
            imagejpeg($tci, $newcopy, 80);
        }
            
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
                //$tmp_name=$_FILES['images']['name'];
               list($width,$height)=getimagesize($file_anme);
               
               $image= addslashes($_FILES['image']['name']);
               $image=file_get_contents($image);
                
               $thumbnail=img_resize($_FILES['images']['name'],200,200);
                
                //Reference: http://php.net/manual/en/function.oci-new-descriptor.php
                
                $uniid=uniqid();
                
                $lob=oci_new_descriptor($connection, OCI_D_LOB);
                $lobimage=oci_new_descriptor($connection,OCI_D_LOB);
                
                $stmt = oci_parse($conn, 'insert into images (photo_id, owner_name, permitted, subject, place, timing, description, thumbnail, photo) values    (:php_id, :owner_name, :permitted, :subject, :location, TO_DATE( :time, \'mm/dd/yyyy\'), :description, EMPTY_BLOB(), EMPTY_BLOB()) returning thumbnail, photo into :thumbnail, :photo');
                
                oci_bind_by_name($stmt, 'owner_name', $user);
                oci_bind_by_name($stmt, 'permitted', $permitted);
                oci_bind_by_name($stmt, 'php_id', $uniid);
                oci_bind_by_name($stmt, 'subject', $subject);
                oci_bind_by_name($stmt, 'location', $place);
                oci_bind_by_name($stmt, 'description', $description);
                oci_bind_by_name($stmt, 'thumbnail', $lob, -1, OCI_B_BLOB);
               oci_bind_by_name($stmt, 'thumbnail', $lob, -1, OCI_B_BLOB); 
                
                //Reference: http://www.php-tutorials.com/oracle-blob-insert-php-bind-variables/
                if (!oci_execute($stmt, OCI_DEFAULT)){
                    $e=error_get_last();
                    $f=oci_error();
                    echo "Message: ".$e['message']."\n";
                    echo "File: ".$e['file']."\n";
                    echo "Line: ".$e['line']."\n";
                    echo "Oracle Message: ".$f['message'];
                    
                    echo "<table align='center'> <tr><td>Couldn't upload image. </td></tr> <tr><td>Please check you have correct sensor id.</td></tr> </table><br/>";

                }else{
                    $lob->save($thumbnail);
                    $lobimage->save($image);
                    
                    oci_commit($connection);
                    
                    $lob->free();
                    $lobimage->free();
                    echo "Image uploaded!<br/>";
                }
                //move_uploaded_file($file_tmp,"images/".$file_name);
                 echo "Success";
              }else{
                 print_r($errors);
              }
           }
            echo '<center><form method="post" action ="upload.html"><input type="submit" name="submit" value="continue" /> </form></center>';

        ?>
    </body>
</html>
