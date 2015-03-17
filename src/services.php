<?php

  //Include Header
  include('include/header.php');
  include('../include/sql.php');
  
  $table  = "services";
  
  //IF Action= UPDATE
  if ($_REQUEST['action'] != "") {

    $text = $_REQUEST['text'];
    $text = str_replace("'", "\'", $text);
    //$text = str_replace("\n", "<br>", $text);
    $text = str_replace("  ", "&nbsp;&nbsp;", $text);
    $text = str_replace("<bar>", '<img src="images/bg.png" width="850px" height="1px">', $text);
    
    $sql = "UPDATE `services` SET `text` = '$text' WHERE `id`=0;";

    if(!$result = $con->query($sql)) {
      die('There was an error running the query [' . $con->error . ']');
    } else {
      $text = $text = str_replace("\'", "'", $text);
      ?>
      <div align="center">
      <p><b>Services page updated</b><br><br></p>
      </div>
      <table width ="900px">
        <tr>
          <td width ="30px"> </td>
          <td width ="880px"><?php echo $text; ?></td>
          <td width ="10px"> </td>
        </tr>
      </table>
      <?php
    }

  } else {  

    $sql   ="SELECT id,text FROM ".$table." WHERE id=0";

    if(!$result = $con->query($sql)) {
      die('There was an error running the query! [' . $con->error . ']');
    }

    while($row = $result->fetch_assoc()) {
      $text = $row['text'];
      //$text = str_replace("<br>", "\n", $text);
      $text = str_replace("&nbsp;&nbsp;", "  ", $text);
      $text = str_replace('<img src="images/bg.png" width="850px" height="1px">', '<bar>', $text);
      
      // alink h1
      ?>
        <table width="100%" cellspacing="0" cellpadding="8" border="0">
          <tr>
            <td width="35%"><div class="text"><b>Key:<br><br></b></div></td>
            <td width="65%"> </td>
          </tr>

          <tr>
            <td width="35%"><div class="text">Regular white text:</div></td>
            <td width="65%"><div class="text">
             <?php echo htmlentities('<p>Text</p>'); ?>
            </div></td>
          </tr>

          <tr>
            <td width="35%"><div class="text">Link to Contact Page</div></td>
            <td width="65%"><div class="text">
             <?php echo htmlentities('<a href="contact.php">Contact us</a>'); ?>
            </div></td>
          </tr>

          <tr>
            <td width="35%"><div class="text">Red Title Text</div></td>
            <td width="65%"><div class="text">
             <?php echo htmlentities('<h1>Text</h1>'); ?>
            </div></td>
          </tr>
          
          <tr>
            <td width="35%"><div class="text">White Title Text</div></td>
            <td width="65%"><div class="text">
             <?php echo htmlentities('<h2>Text</h2>'); ?>
            </div></td>
          </tr>

          <tr>
            <td width="35%"><div class="text">Bar</div></td>
            <td width="65%"><div class="text">
             <?php echo htmlentities('<bar>'); ?>
            </div></td>
          </tr>
          
          <tr>
            <td width="35%"><div class="text" style="color:red;">Change Color:</div></td>
            <td width="65%"><div class="text">
             <?php echo htmlentities('<font color="red">Text</font>'); ?>
            </div></td>
          </tr>
          <tr>
            <td width="35%"><div class="text" style="color:red;font-size: 15px;">Change color and size:</div></td>
            <td width="65%"><div class="text">
             <?php echo htmlentities('<font color="red" size="14">Text</font>'); ?>
            </div></td>
          </tr>
          <tr>
            <td width="35%"><div class="text"><b>Bold:</b></div></td>
            <td width="65%"><div class="text">
             <?php echo htmlentities('<b>Text</b>'); ?>
            </div></td>
          </tr>
          <tr>
            <td width="35%"><div class="text"><i>Italics:</i></div></td>
            <td width="65%"><div class="text">
             <?php echo htmlentities('<i>Text</i>'); ?>
            </div></td>
          </tr>
        </table>

        <br><br>

        <form  action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="action" value="submit">
          <div class="text" align="center">
          <input name="submit" type="submit" value="Update Services Page"/>
          <br><br>
          <textarea name="text" rows="300" cols="10" style="width: 870px" maxlength="16777215"/><?php echo $text; ?></textarea>
          <br><br>
          <input name="submit" type="submit" value="Update Services Page"/>
          </div>
        </form>
    <?php  
    }
  }		

  $con->close();

  //footer
  include('include/footer.php');
?>