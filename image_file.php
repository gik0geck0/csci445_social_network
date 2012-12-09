<?php
    // just so we know it is broken
    error_reporting(E_ALL);
    // some basic sanity checks
    if(isset($_GET['image_id']) && is_numeric($_GET['image_id'])) {
        //connect to the db
        $link = mysql_connect("localhost", "team10", "tangerine") or die("Could not connect: " . mysql_error());
        $id = $_GET['image_id'];
        // select our database
        mysql_select_db("team10_social") or die(mysql_error());
 
        // get the image from the db
        $sql = "SELECT Data FROM images WHERE IID=$id";
 
        // the result of the query
        $result = mysql_query("$sql") or die("Invalid query: " . mysql_error());
 
        // set the header for the image
        header("Content-type: image");
        echo mysql_result($result, 0);
 
        // close the db link
        mysql_close($link);
    }
    else {
        echo 'Please use a real id number';
    }
?>