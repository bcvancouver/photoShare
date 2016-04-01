<?php
    include("PHPconnectionDB.php");
    $conn=connect();
    // get the q parameter from URL
    $user = $_REQUEST["user"];
    $subj = $_REQUEST["subj"];
    $date = $_REQUEST["date"];
    $tdate = $date;
    $s = " select ";
    $g = " group by ";
    $w = " where ";
    //Group by User
    if ($user == "All") {
        $s.= " i.owner_name, ";
        $g.= " i.owner_name, ";
    }
    elseif ($user != "None"){
        $s.= " i.owner_name, ";
        $g.= " i.owner_name, ";
        $w.= " i.owner_name = '".$user."' and ";
    }

    //Group by Subject
    if ($subj == "All") {
        $s.= " i.subject, ";
        $g.= " i.subject, ";
    }
    elseif ($subj != "None"){
        $s.= " i.subject, ";
        $g.= " i.subject, ";
        $w.= " i.subject = '".$subj."' and";
    }

    //Group by Date
    if ($date == "Year") {
        $s .= ' to_char(i.timing,\'yyyy\') as tyear,';
        $g .= ' to_char(i.timing,\'yyyy\') ,';
    }
    elseif ($date == "Month") {
        $s .= ' to_char(i.timing,\'yyyy-MON\') as tmonth,';
        $g .= ' to_char(i.timing,\'yyyy-MON\') ,';
    }
    elseif ($date == "Week") {
        $s .= ' to_char(i.timing,\'yyyy-MON-IW\') as tweek,';
        $g .= ' to_char(i.timing,\'yyyy-MON-IW\') ,';
    }
    else {
    }
    $g = rtrim($g," ,");
    $w = rtrim($w," and");
    $w = rtrim($w," where");
    $stp.= $s.' count(i.photo_id) as image_count ';
    $stp.= " from images i ";
    $stp.= $w;
    $stp.= $g;
    $stid = oci_parse($conn,$stp);
    $res = oci_execute($stid);
    echo '<TABLE class="table table-bordered"><TR valign=top align=left>
            <td>Owner Name </td><td>Subject</td><td>Period '.$tdate."</td><td>Image Count</td>
        </tr>";
    while (($row = oci_fetch_array($stid, OCI_ASSOC))) {
        echo "<TR valign=top align=left>";
        if (isset($row["OWNER_NAME"])) {
            echo "<td>".$row["OWNER_NAME"]."</td>";
        }
        else {
            echo "<td> NONE </td>";
        }
        if (isset($row["SUBJECT"])) {
            echo "<td>".$row["SUBJECT"]."</td>";
        }
        else {
            echo "<td> NONE </td>";
        }
        if (isset($row["TYEAR"])) {
            echo "<td>".$row["TYEAR"]."</td>";
        }
        if (isset($row["TMONTH"])) {
            echo "<td>".$row["TMONTH"]."</td>";
        }
        if (isset($row["TWEEK"])) {
            echo "<td>".$row["TWEEK"]."W</td>";
        }
        if ($tdate == "None" ) {
            echo "<td> NONE </td>";
        }
        echo "<td>".$row["IMAGE_COUNT"]."</td>";
        echo "</tr>";
    }
    echo "</TABLE>";
    //print_r($stp);
?>