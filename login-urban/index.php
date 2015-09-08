<?php

// Urban config
require_once('config.php');

global $URBAN;

?>

<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<meta charset="UTF-8">
<title><?php echo $URBAN->str_title ?></title>
<link rel="stylesheet" href="css/inserver.css" media="screen" type="text/css" />
</head>

<body>

<div id="login">
  <h1>Demo Logo</h1>

  <!-- In case of error, apply  class "error" -->
  <?php 
    if (isset($_GET['errorcode']) && $_GET['errorcode'] == 3) {
      $error = " error ";
      ?>

      <div id="error-login">
        <img class="icon icon-pre" alt="Error" src="images/warning.png">
        <?php echo $URBAN->str_loginerror ?>
      </div>

      <?php 
    } else $error = "";
  ?>

  <form action="../login/index.php" method="post" id="form">
    <input class="<?php echo $error; ?>" type="text" name="username" placeholder="<?php echo $URBAN->str_username ?>" />
    <input class="<?php echo $error; ?>" type="password" name="password" placeholder="<?php echo $URBAN->str_password ?>" />
    <div id="remember">
      <input type="checkbox" value="1" />
      <label><?php echo $URBAN->str_remember ?></label>
    </div>
    <input type="submit" value="<?php echo $URBAN->str_loginbtn ?>" />
  </form>
  <div id="footer"> <a href="../login/forgot_password.php"><?php echo $URBAN->str_forgotten ?></a> </div>
</div>




<script src="js/jquery.js"></script> 
<script src="js/jquery.vegas.js"></script> 
<script>
$(function() {

<?php
  if (isset($URBAN->carousel) && $URBAN->carousel == 1) {
?>

  /* IMAGE CAROUSEL BACKGROUND */
    $.vegas('slideshow', {
        backgrounds:[
        { src:'images/bckgrnd1.jpg', fade:1000},
        { src:'images/bckgrnd2.jpg', fade:1000},
        { src:'images/bckgrnd3.jpg', fade:1000}
        ]
        })('overlay');

    $.vegas('overlay', {
        src:'overlays/01.png'
      });
  /* END OF IMAGE CAROUSEL BACKGROUND */

<?php
  } else {
?>

  /* FIXED IMAGE BACKGROUND */
    
    $.vegas({
      src:'images/bckgrnd1.jpg'
    });

    $.vegas('overlay', {
        src:'overlays/01.png'
    });

  /* END OF FIXED IMAGE BACKGROUND */

<?php 
  }
?>

  
});

</script>
<?php if (isset($URBAN->show_disclaimer) && $URBAN->show_disclaimer == 1 ) { ?>
	<div id="credits">Powered by <a href="http://www.inserver.es" title="Inserver">Inserver</a></div>
<?php } ?>

</body>
</html>