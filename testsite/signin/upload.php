<?php
    
    include ("PHPconnectionDB.php");
    session_start();
    $user=$_SESSION['login_user'];
    $connection=connect();
    define('MAX_THUMBNAIL_DIMENSION',100);


    /*
    if ($user == 'admin') {
        $groups = '';
        $sql = 'SELECT g.group_id, g.group_name, g.user_name FROM groups g';
    }
    else {
        $groups = '<option value="2">private</option><option value="1">public</option>';
        $sql = 'SELECT g.group_id, g.group_name, g.user_name FROM groups g left outer join group_lists l on g.group_id=l.group_id WHERE g.user_name=\'' . $user . '\' or l.friend_id=\'' . $user . '\'';
    }

    while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $group_id = $row['GROUP_ID'];
        $group_name = $row['GROUP_NAME'];
        $group_owner = $row['USER_NAME'];
        $groups .= '<option value="'.$group_id.'">'.$group_name.' - ' . $group_owner .'</option>';
    }
    oci_free_statement($stid);
    oci_close($conn);

    $stid=oci_parse($connection,$sql);
    oci_execute($stid);
    */

    //$subject=$_POST['title'];
    //$date=$_POST['datepicker'];
    //$place=$_POST['place'];
    //$description=$_POST['description'];
    //$permitted=$_POST['privacy'];


    //Function to turn picture into thumbnail
    function getThumbnail($imgfile)
    {
        list($w, $h, $type) = getimagesize($imgfile);

        // Retrieve old image
        switch ($type) {
            case IMAGETYPE_GIF:
                $src_img = imagecreatefromgif($imgfile);
                break;
            case IMAGETYPE_JPEG:
                $src_img = imagecreatefromjpeg($imgfile);
                break;
            default:
                throw new Exception('Unrecognized image type ' . $type);
        }

        if ($w > MAX_THUMBNAIL_DIMENSION || $h > MAX_THUMBNAIL_DIMENSION) {
            // Rescale image to thumbnail size
            $scale = MAX_THUMBNAIL_DIMENSION / (($h > $w) ? $h : $w);
            $nw = $w * $scale;
            $nh = $h * $scale;
            $dest_img = imagecreatetruecolor($nw, $nh);
            imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $nw, $nh, $w, $h);
            // Create new thumbnail from old image
            switch ($type) {
                case IMAGETYPE_JPEG:
                    // overwrite file with new thumbnail
                    imagejpeg($dest_img, $imgfile);
                    break;
                case IMAGETYPE_GIF:
                    imagegif($dest_img, $imgfile);
                    break;
                default:
                    throw new Exception('Unrecognized image type ' . $type);
            }
            // Clean up
            imagedestroy($src_img);
            imagedestroy($dest_img);
        }
    }

     //Check image file
    if (isset($_FILES['image'])) {
            $errors = array();
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];

            $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));

            $extension = array("jpeg", "jpg", "png", "gif");

            if ($file_size == 0) {
                $errors[] = "Plz select a file.";
            } elseif (in_array($file_ext, $extension) === false) {
                $errors[] = "extension not allowed, please choose a JPEG, PNG or GIF file.";
            }


            if (empty($errors) == true) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
                $thumbnail = getThumbnail($_FILES['image']['tmp_name']);

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
                #$permitted=$_POST['privacy'];
                $permitted = 1;

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
                    ecco "Images Sucessfully Uploaded!<br>";
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
        echo '<center><form method="post" action ="upload.html"><input type="submit" name="submit" value="continue" /> </form></center>';

    ?>