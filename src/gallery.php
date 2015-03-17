<?php 
  include('include/header.php'); 
  include('../include/sql.php');
?>
<div align="center">
<p>
<?php
   
    $uploadpath = '../gallery/';      						                         // directory to store the uploaded files
    $allowtype = array('bmp', 'gif', 'jpg', 'jpe', 'png', 'JPG', 'JPEG', 'jpeg');    // allowed extensions
      
    if( (isset($_FILES['fileup'])) && (strlen($_FILES['fileup']['name']) > 1)  && (isset($_REQUEST['before_after'])) &&  ( (isset($_REQUEST['title']) && $_REQUEST['title'] !='new') ||  (strlen($_REQUEST['newTitle'])>1))    ) {
      
      $title = $_REQUEST['title'];

      if ($title == "new") {
        $title = str_replace(' ', '-', $_REQUEST['newTitle']);

        if (!mkdir($uploadpath.$title, 0755, true)) {
          die('Failed to create folders...');
        }
      }

      
      $filename             = basename($_FILES['fileup']['name']);
      $sepext               = explode('.', strtolower($_FILES['fileup']['name']));
      $type                 = end($sepext);      								// gets extension
      $err                  = '';       									// to store the errors

      // Checks if the file has allowed type, size, width and height (for images)
      if(!in_array($type, $allowtype)) $err .= 'The file: <b>'. $_FILES['fileup']['name']. '</b> is not an allowed extension type.';
 
      // If no errors, upload the image, else, output the errors
      if($err == '') {
     
        // gets the file name
        $fullUploadPath           = $uploadpath . "/". $title ."/". $filename;
        
        if(move_uploaded_file($_FILES['fileup']['tmp_name'], $fullUploadPath)) {
        
          include("include/resize-class.php");

	  // Create Full Size IMG
	  $resizeObj = new resize($fullUploadPath);
	  $resizeObj -> resizeImage(640, 480, 'crop');
	  $resizeObj -> saveImage($fullUploadPath, 100);
          
          // Create Thumbnail
          $thumbName = $uploadpath . "/". $title ."/". 'thumb_' . $filename;
	  $resizeObj = new resize($fullUploadPath);
	  $resizeObj -> resizeImage(202, 202, 'crop');
	  $resizeObj -> saveImage($thumbName, 100);

          
          //createThumb($uploadpath);
          
          echo '<b>'. $filename . '</b> uploaded!';
          
          //insert to db
        
          $table     = "gallery";
          $thumbName = "thumb_".$filename;
          
          $before_after = $_REQUEST['before_after'];
          
          if ($_REQUEST['title'] == "new") {
            $sql   ="INSERT INTO ".$table." (title, before_after, image, image_thumb) VALUES ('$title','0','$filename','$thumbName')";
          
            if (!mysqli_query($con,$sql)) {
              die('Error: ' . mysqli_error($con));
            }
          }
          
          $sql   ="INSERT INTO ".$table." (title, before_after, image, image_thumb) VALUES ('$title','$before_after','$filename','$thumbName')";
          
          if (!mysqli_query($con,$sql)) {
            die('Error: ' . mysqli_error($con));
          }
          
          mysqli_close($con);
      
        }
          else echo '<b>Unable to upload the file.</b><br>'.$err.'<br>';
        }
        
      else echo $err;
    } else {
      if ($_REQUEST['action'] != "") {  
        echo '<b>You must select a vehicle, image, and before/after.</b><br>';
      }
    }

?>

</p>
</div>


<form action="" method="POST" enctype="multipart/form-data">
<input type="hidden" name="action" value="submit">

<table width="80%" cellspacing="0" cellpadding="4" border="0" align="center">
  <tr>
    <td width="14%"><div class="text" align="left">Image:</div><br><br></td>
    <td width="49%"><div align="left"><input type="file" style="width:250px" class="text" name="fileup" /></div><br><br></td>
    <td width="16%"> </td>
    <td width="16%"><input type="submit" value="Upload"><br><br></td>
  </tr>
  
<?php

  include('../include/sql.php');
  $table = "gallery";
  $sql   = "SELECT * FROM ".$table." ORDER BY title";
  
  if(!$result = $con->query($sql)) {
    die('There was an error running the query [' . $con->error . ']');
    
  }
  
  $currentRow = '';
  
  while($row = $result->fetch_assoc()) {
      if ($row['title'] != $currentRow) {
        $currentRow = $row['title'];
        
        if ( ($_REQUEST['title'] == $currentRow) || (($_REQUEST['title'] =='new') &&  (($_REQUEST['newTitle']) == $currentRow)    ) ) {
            $titleChecked = 'checked';
            $tdColor      = 'bgcolor="#2F2F2F"';
            
            if ($_REQUEST['before_after'] == '1') {
                $beforeChecked = 'checked';
                $afterChecked  = '';
            } else if ($_REQUEST['before_after'] == '2') {
                $beforeChecked = '';
                $afterChecked  = 'checked';
            }
        }

        echo '<tr>';
        echo '  <td width="14%" '. $tdColor  . '><div align="left"><input type="radio" name="title" value="' . $currentRow . '" ' . $titleChecked . '></div></td>';
        echo '  <td width="54%" '. $tdColor  . '><div class="text">' . str_replace("-", " ", $currentRow) . '</div></td>';
        echo '  <td width="16%" '. $tdColor  . '><div align="left" class="text"><input type="radio" name="before_after" value="1"' . $beforeChecked . '> Before</div> </td>';
        echo '  <td width="16%" '. $tdColor  . '><div align="left" class="text"><input type="radio" name="before_after" value="2"' . $afterChecked . '> After</div></td>';
        echo '</tr>';
        
        $titleChecked  = '';
        $tdColor       = '';
        $beforeChecked = '';
        $afterChecked  = '';
      }
    
  }

  $con->close();
  
?>
  
  <tr>
    <td width="14%"><br><br><div align="left"><input type="radio" name="title" value="new"></td>
    <td width="54%"><br><br><input name="newTitle" type="text" placeholder="New vehicle title" size="30" style="width: 250px;" maxlength="50"/></td>
    <td width="16%"><br><br><div align="left" class="text"><input type="radio" name="before_after" value="1"> Before</div> </td>
    <td width="16%"><br><br><div align="left" class="text"><input type="radio" name="before_after" value="2"> After</div></td>
  </tr>
  

</table>


<?php include('include/footer.php'); ?>