<?php
    // the upload function
    function upload($filename){
      //echo "entering the upload function";
      $username = "team10";
      $password = "tangerine";
      $dbname = "team10_social";
      $maxsize = $_POST['MAX_FILE_SIZE'];

      if(is_uploaded_file($_FILES[$filename]['tmp_name'])) {
        //echo "passed is_uploaded_file check";

        // check the file is less than the maximum file size
        if($_FILES[$filename]['size'] < $maxsize) {
          //echo "passed file size check";
          // prepare the image for insertion
          $imgData =addslashes (file_get_contents($_FILES[$filename]['tmp_name']));
          // $imgData = addslashes($_FILES[$filename]);
   
          // get the image info..
          $size = getimagesize($_FILES[$filename]['tmp_name']);
   
          // put the image in the db...
          // database connection
          mysql_connect("localhost", "$username", "$password") OR DIE (mysql_error());
 
          // select the db
          mysql_select_db("$dbname") OR DIE ("Unable to select db".mysql_error());
 
          // our sql query
          $sql = "INSERT INTO images ".
                  "(IID, Type, Data, Dimensions, Name) ".
                  "VALUES ".
                  "(null, '{$size['mime']}', '{$imgData}', '{$size[3]}', '{$_FILES[$filename]['name']}')";
          //echo "the query is:\n$sql";
   
          // insert the image
          if(!mysql_query($sql)) {
            echo 'Unable to upload file';
            exit;
          }
          return mysql_insert_id();
        } else {
          echo "file size too big";
        }
          
      } else {
       // if the file is not less than the maximum allowed, print an error
       echo
        '<div>File exceeds the Maximum File limit</div>
        <div>Maximum File limit is '.$maxsize.'</div>
        <div>File '.$_FILES[$filename]['name'].' is '.$_FILES[$filename]['size'].' bytes</div>
        <hr />';
      }
    }
?>
