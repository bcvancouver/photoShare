<?php
    
    include ("PHPconnectionDB.php");
    session_start();
    $user=$_SESSION['login_user'];
    $connection=connect();
    //$file_count=count($file_post['image[]']);
    //echo "$file_count files found!<br>";
    if (!$user){
        echo "<script>
            alert('Please Sign In!');
            location='signin.html';
        </script>";
    }/*elseif (count($_FILES['image']['name'])==0){
        //Reference: http://stackoverflow.com/questions/11869662/display-alert-message-and-redirect-after-click-on-accept
        echo "<script>
            alert('No images found!');
            location='uploadfrontend.php';
        </script>";*/


//Function to turn picture into thumbnail
function getThumbnail($file) {
    //$source_pic = $file;
    $max_width = 200;
    $max_height = 200;
    echo "<center>processing image...</center><br/>";
    list($width, $height, $image_type) = getimagesize($file);
    switch ($image_type)
    {
        case 1: $src = imagecreatefromgif($file); break;
        case 2: $src = imagecreatefromjpeg($file);  break;
        case 3: $src = imagecreatefrompng($file); break;
        default: return '';  break;
    }
    $x_ratio = $max_width / $width;
    $y_ratio = $max_height / $height;
    if( ($width <= $max_width) && ($height <= $max_height) ){
        $tn_width = $width;
        $tn_height = $height;
    }elseif (($x_ratio * $height) < $max_height){
        $tn_height = ceil($x_ratio * $height);
        $tn_width = $max_width;
    }else{
        $tn_width = ceil($y_ratio * $width);
        $tn_height = $max_height;
    }
    $tmp = imagecreatetruecolor($tn_width,$tn_height);
    /* Check if this image is PNG or GIF, then set if Transparent*/
    if(($image_type == 1) OR ($image_type==3))
    {
        imagealphablending($tmp, false);
        imagesavealpha($tmp,true);
        $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
        imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
    }
    imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);
    /*
     * imageXXX() only has two options, save as a file, or send to the browser.
     * It does not provide you the oppurtunity to manipulate the final GIF/JPG/PNG file stream
     * So I start the output buffering, use imageXXX() to output the data stream to the browser,
     * get the contents of the stream, and use clean to silently discard the buffered contents.
     */
    ob_start();
    switch ($image_type)
    {
        case 1: imagegif($tmp); break;
        case 2: imagejpeg($tmp, NULL, 100);  break; // best quality
        case 3: imagepng($tmp, NULL, 0); break; // no compression
        default: echo ''; break;
    }
    $final_image = ob_get_contents();
    ob_end_clean();
    return $final_image;
}
echo count($_FILES['image']['name']);
for ($i=0; $i<count($_FILES['image']['name']); $i++){
    //Check each image file
    if (isset($_FILES['image'][$i])) {
        $errors = array();
        $file_name = $_FILES['image']['name'][$i];
        $file_size = $_FILES['image']['size'][$i];
        $file_tmp = $_FILES['image']['tmp_name'][$i];
        $file_type = $_FILES['image']['type'][$i];
        $file_ext = strtolower(end(explode('.', $_FILES['image']['name'][$i])));
        $extension = array("jpeg", "jpg", "png", "gif");
        if ($file_size == 0) {
            $errors[] = "Plz select a file.";
        } elseif (in_array($file_ext, $extension) === false) {
            $errors[] = "extension not allowed, please choose a JPEG, PNG or GIF file.";
        }
    }
    // If image file is okay, upload
    if (empty($errors) == true) {
        echo " image exist<br>";
        $image = file_get_contents(addslashes($_FILES['image']['tmp_name'][$i]));
        $thumbnail = getThumbnail($_FILES['image']['tmp_name'][$i]);
        //Reference: http://php.net/manual/en/function.oci-new-descriptor.php
        $connection = connect();
        $curr_id = hexdec(uniqid());
        $message = '<p>Building query</p>';
        $user = $_SESSION['login_user'];
        $subject = $_POST['title'];
        $date = $_POST['datepicker'];
        $date=str_replace('-','/',$date);
        $place = $_POST['place'];
        $description = $_POST['description'];
        $permitted=$_POST['privacy'];
        $sql = 'INSERT INTO images VALUES '
            . '(' . $curr_id . ',\'' . $user . '\',\'' . $permitted . '\',\'' . $subject . '\',\'' . $place . '\','
            . 'TO_DATE(\'' . $date . '\', \'yyyy/mm/dd\'),\'' . $description . '\',empty_blob(),empty_blob()) '
            . 'RETURNING thumbnail, photo INTO :thumbnail, :photo';
        $stid = oci_parse($connection, $sql);
        // Create blobs from photo and thumbnail
        $thumbnail_blob = oci_new_descriptor($connection, OCI_D_LOB);
        $photo_blob = oci_new_descriptor($connection, OCI_D_LOB);
        oci_bind_by_name($stid, ':thumbnail', $thumbnail_blob, -1, OCI_B_BLOB);
        oci_bind_by_name($stid, ':photo', $photo_blob, -1, OCI_B_BLOB);
        $res = oci_execute($stid, OCI_NO_AUTO_COMMIT);
        if (!$thumbnail_blob->save($thumbnail) || !$photo_blob->save($image)) {
            oci_rollback($connection);
        } else {
            oci_commit($connection);
            echo "<center>Images Sucessfully Uploaded!<center><br>";
        }
        if (!$res) {
            $err = oci_error($stid);
            echo htmlentities($err['message']);
        }
        oci_free_statement($stid);
        oci_close($connection);
    } else {
        print_r($errors);
    }
}
echo '<center><form method="post" action ="main.php"><input type="submit" name="submit" value="continue" /> </form></center>';
?>