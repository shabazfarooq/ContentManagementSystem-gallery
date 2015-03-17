<?php
		 //Include Header
			include('include/header.php');
			
   //Retrieve rows testimonials from database
			include('../include/sql.php');
			$table = "testimonials";
			
		 ///SQL FOR IF A DELETE REQUEST IS SENT
   $action=$_REQUEST['action'];
   
  		if ($action!="") {
  		  $submitValue = $_REQUEST['submitValue'];
  		  $id          = $_REQUEST['id'];

  		  if ($submitValue == "Update") {
  		  		$name    = $_REQUEST['name'];
  		  		$email   = $_REQUEST['email'];
  		  		$vehicle = $_REQUEST['vehicle'];
						$message = $_REQUEST['message'];
                        $message = str_replace("'", "\'", $message);
						$show    = $_REQUEST['show'];
						
						//echo $name . '<br>' . $email . '<br>' . $vehicle . '<br>' . $message . '<br>' . $show . '<br>';
						
						//$sql = "UPDATE ".$table." SET id=" . $id . " show=" . $show . " name=" . $name . " email=" . $email . " vehicle=" . $vehicle . " message=" . $message . "WHERE id=" . $id . " show=" . $show . " name=" . $name . " email=" . $email . " vehicle=" . $vehicle . " message=" . $message;
						$sql = "UPDATE `testimonials` SET `show` = '$show', `name` = '$name', `email` = '$email', `vehicle` = '$vehicle', `message` = '$message' WHERE `testimonials`.`id` = '$id';";
						
						// `name` = '$name' `email` = '$email' `vehicle` = '$vehicle' `message` = '$message'
  		  	} else if ($submitValue == "Delete") {
  		  		$sql = "DELETE FROM ".$table." WHERE id=" . $id;
  		  	}

  		  if(!$result = $con->query($sql)) {
 					  die('There was an error running the query [' . $con->error . ']');
			  }
			  
			  
			}
			
			
			//SQL FOR DISPLAYING ROWS
			$sql   ="SELECT * FROM ".$table." ORDER BY id DESC";

	  	if(!$result = $con->query($sql)) {
 					die('There was an error running the query [' . $con->error . ']');
			}
			
			//show, name, message
			while($row = $result->fetch_assoc()) {
				 echo '<form  action="" method="POST" enctype="multipart/form-data">';
				 echo '  <input type="hidden" name="action" value="submit">';
				 echo "  <input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\">";
				 echo '<table width="100%" cellspacing="25" cellpadding="0" style="border:0px solid transparent;">';
					echo '<tr valign="top">';
					echo '  <td width="175px"><div class="text">Name</div></td>';
					echo "  <td><div class=\"text\"><input name=\"name\" type=\"text\" value=\"" . $row['name'] . "\" size=\"30\" style=\"width: 100%\" maxlength=\"50\"/></div></td>";
					echo '</tr>';
					echo '<tr valign="top">';
					echo '  <td width="175px"><div class="text">Email</div></td>';
					echo "  <td><div class=\"text\"><input name=\"email\" type=\"text\" value=\"" . $row['email'] . "\" size=\"30\" style=\"width: 100%;\" maxlength=\"50\"/></div></td>";
					echo '</tr>';
					echo '<tr valign="top">';
					echo '  <td width="175px"><div class="text">Vehicle</div></td>';
					echo "  <td><div class=\"text\"><input name=\"vehicle\" type=\"text\" value=\"" . $row['vehicle'] . "\" size=\"30\" style=\"width: 100%;\" maxlength=\"50\"/></div></td>";
					echo '</tr>';
					echo '<tr valign="top">';
					echo '  <td width="175px"><div class="text">Message</div></td>';
					echo "  <td><div class=\"text\"><textarea name=\"message\" rows=\"7\" cols=\"30\" style=\"width: 100%;\" maxlength=\"3000\"/>" . $row['message'] . "</textarea></div></td>";
					echo '</tr>';
					echo '<tr valign="top">';
					echo '  <td width="175px"><div class="text">Display</div></td>';
					echo "  <td><div class=\"text\">";
					echo "  <input name=\"show\" type=\"radio\" value=\"1\""; if ($row['show'] == 1) { echo "checked"; } echo "/>  Approve for display &nbsp; &nbsp; &nbsp;";
					echo "  <input name=\"show\" type=\"radio\" value=\"0\""; if ($row['show'] == 0) { echo "checked"; } echo "/>  Do not display";
					echo "</div></td>";
					echo '</tr>';
					echo '<tr valign="top">';
					echo '  <td width="175px"></td>';
					echo '  <td align="center">';
					echo '  <input name="submitValue" type="submit" value="Update"/> &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; <input name="submitValue" type="submit" value="Delete"/>';
					echo '  </td>';
					echo '  </td>';
					echo '</tr>';
					echo '</table>';
					echo '</form>';
					echo '<br>';
				 echo '<img src="../../images/bg.png" width="100%" height="1px">';
 					echo '<br>';
			}	
			
				
			$con->close();
			
			
			//footer
			include('include/footer.php');
?>
