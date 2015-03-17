<?php
		 //Include Header
			include('include/header.php');
			
   //Retrieve rows testimonials from database
			include('../include/sql.php');
			$table = "contact_form";
			
		 ///SQL FOR IF A DELETE REQUEST IS SENT
   $action=$_REQUEST['action'];
  		if ($action!="") {
  		  
  		
  		  $sql   ="DELETE FROM ".$table." WHERE id=" . $_REQUEST['id'];
  		  
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
				 echo '<table width="700px" border="0" cellspacing="2" cellpadding="2">';
					echo '<tr valign="top">';
					echo '  <td width="175px"><p>Name</p></td>';
					echo "  <td><p>" . $row['name'] . "</p></td>";
					echo '</tr>';
					echo '<tr valign="top">';
					echo '  <td width="175px"><p>Contact</p></td>';
					echo "  <td><p>" . $row['contact'] . "</p></td>";
					echo '</tr>';
					echo '<tr valign="top">';
					echo '  <td width="175px"><p>Message</p></td>';
					echo "  <td><p>" . $row['message'] . "</p></td>";
					echo '</tr>';
					echo '<tr valign="top">';
					echo '  <td width="175px"></td>';
					echo '  <td><input type="submit" value="Delete"/></td>';
					echo '</tr>';
					echo '</table>';
					echo '</form>';
				        echo '<div align="center"><img src="../../images/bg.png" width="80%" height="1px"></div>';
 					echo "<br>";
			}	
				
			$con->close();
			
			
			//footer
			include('include/footer.php');
?>
