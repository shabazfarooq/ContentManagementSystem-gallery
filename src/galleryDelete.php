<?php include('include/header.php') ?>
      <table width="900px" border=0 cellpadding=0 cellspacing=20>
        <tr>
          <td>
          <form action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="action" value="submit">
          <?php
              //Retrieve rows testimonials from database
              include('../include/sql.php');
              $table = "gallery";
              
              $galleryFolder = "../gallery/";
              
              
              
              ///SQL FOR IF A DELETE FOLDER REQUEST IS SENT
  	      if ($_REQUEST['delete'] == 'Delete Entire Folder') {
                $title = $_GET['v'];
                 
                $sql   ="DELETE FROM gallery WHERE title='" . $title . "'";
  		  
  		if(!$result = $con->query($sql)) {
 		  die('There was an error running the query [' . $con->error . ']');
		}
                
                function rrmdir($dir) {
                  if (is_dir($dir)) {
                    $objects = scandir($dir);
                    foreach ($objects as $object) {
                      if ($object != "." && $object != "..") {
                        if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
                      }
                    }
                    reset($objects);
                    rmdir($dir);
                  }
                }
                
                $deleteFolder = $galleryFolder . $title . '/';
                rrmdir($deleteFolder);
                echo '<div align="center"><p><b>Deleted ' . $title . '</b></p></div>';
                
	      }
              //REQUEST FOR DELETE SELECTED IMAGES SENT
              else if ($_REQUEST['delete'] == 'Delete Selected Files') {
                  $fileNameArray = $_POST['fileName'];
                  
                  
                  for ($i=0; $i < sizeof($fileNameArray); $i++) {
                    //File Delete
                    $deleteFileLocation      = "../gallery/" . $_GET['v'] . '/' . $fileNameArray[$i];
                    $deleteFileThumbLocation = "../gallery/" . $_GET['v'] . '/thumb_' . $fileNameArray[$i];
                    
                    unlink($deleteFileLocation);
                    unlink($deleteFileThumbLocation);
                    
                    //SQL Delete
                    $sql   ="DELETE FROM gallery WHERE image='" . $fileNameArray[$i] . "'";
  		  
  		    if(!$result = $con->query($sql)) {
 		      die('There was an error running the query [' . $con->error . ']');
		    }
                  }
                  
                  echo '<div align="center"><p><b>Deleted selected images</b></p></div>';
              }
                       
              
              
              
              //Display Gallery Delete Page
              $sql   = "SELECT * FROM ".$table." ORDER BY title, before_after, id";
												
												
              if(!$result = $con->query($sql)) {
                die('There was an error running the query [' . $con->error . ']');
              }
              
              
              //fetch the data from the database
              $page                = $_GET['v'];
              $switch_first        = 0;
              $switch_before_after = 1;
              
              
              if ($page == '') {
                     echo '<h1><center>Click on a photo to start <i>DELETING...</i><center></h1>';
                     echo '<img src="images/bg.png" width="850px" height="1px"><br><br>';
              }
              
              
              //show, name, message
             
              
              while($row = $result->fetch_assoc()) {
                     $currentTitle        = $row['title'];
                     $before_after        = $row['before_after'];
                     $image               = $row['image'];
                     $image_thumb         = $row['image_thumb'];
                     
                     if ($page == "") {
                     //If the page is NOT SET, display all of the cars names
                            if ($before_after == 0) {
                                   echo '<a href="?v='.$currentTitle.'"><img src="../gallery/'.$currentTitle.'/'.$image_thumb.'" width="202px" height="202px" border="3" /></a> ';
                            }
                     } else {
                     //If the page IS SET, display the gallery for the specific car.
                            if ($before_after != 0) {
                            if ($currentTitle == $page) {
                                   if ($switch_first == 0) {
                                          $switch_first = 1;
                                          
                                          ?>
                                          <a href="?"><img src="../images/back.png" width="35px" height="35px"></a>
                                          <br><br><br>
                                          <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                            <td width="20%"><div align="left"><input type="submit" name="delete" value="Delete Entire Folder"></div></td>
                                            <td width="60%"><h1><div align="center"><?php echo str_replace('-', ' ', $currentTitle); ?></div></h1></td>
                                            <td width="20%"><div align="right"><input type="submit" name="delete" value="Delete Selected Files"></div></td>
                                            </tr>
                                          </table>
                                          
                                          <img src=".../images/bg.png" width="550px" height="1px">
                                          <br>
                                          <?php
                                          
                                          if ($before_after == 1) {
                                                 echo "<h2>&nbsp;Before:</h2>";
                                                 echo "\n";
                                                 $switch_before_after = 1;
                                          } else {
                                                 echo "<h2>&nbsp;After:</h2>";
                                                 echo "\n";
                                                 $switch_before_after = 2;
                                          }
                                          
                                   }

                                   if ( ($before_after != $switch_before_after) ) {
                                          $switch_before_after = $before_after;
                                          
                                          if ($before_after == 1) {
                                                 echo '<div style="clear:both;height:40px;"> </div>';
                                                 echo "<h2>&nbsp;Before:</h2>";
                                                 $switch_before_after = 1;
                                          } else {
                                                 echo '<div style="clear:both;height:40px;"> </div>';
                                                 echo "<h2>&nbsp;After:</h2>";
                                                 $switch_before_after = 2;
                                          }
                                   }
                                   
                                   ?>
                                   
                                   <table width="0" border="0" align="left" >
                                     <tr> 
                                       <td>
                                         <a href="../gallery/<?php echo $currentTitle . '/' . $image; ?>" rel="lightbox" ><img src="../gallery/<?php echo $currentTitle . '/' . $image_thumb; ?>" width="202px" height="202px" border="3" /></a>
                                       </td>
                                     </tr>
                                     <tr>
                                       <td>
                                         <div align="center">
                                         <input type="checkbox" name="fileName[]" style="margin: 0 auto;"id="<?php echo $image; ?>" value="<?php echo $image; ?>">
                                         </div>
                                       </td>
                                     </tr>
                                   </table>
                                   
                                   <?php
                            }
                            }

                     
                     }

              }
              

              if ($page != "") {
                     echo '<div style="clear:both;height:50px;"> </div>';
                     echo '<a href="?"><img src="../images/back.png" width="35px" height="35px"></a>';
              }
              
              $con->close();
              
          ?>
          
          </form>
          <br><br><br><br><br><br>
          </td>
        </tr>
      </table>
<?php include('include/footer.php') ?>
