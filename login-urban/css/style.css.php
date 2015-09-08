<?php

/*
------------------------------------------------------


	URBAN - Moodle Alternate Login 
	by Inserver Elearning Factory
	http://www.inserver.es


------------------------------------------------------
----------------------- STYLES -----------------------
------------------------------------------------------
*/

	header("Content-type: text/css");
	require_once('../config.php');
	global $URBAN;
?>

body {
	background: #EEEEEE;
	font-family: 'Arial';
}
#login {
	position:absolute;
	top:50%;
	left:50%;
	width:80%px;
    max-width:400px;
	height:380px;
	margin:-190px 0 0 -200px;
	transition: opacity 1s;
	-webkit-transition: opacity 1s;
}
h1 {
	padding: 30px 0;
	font-size: 140%;
	font-weight: 300;
	text-align: center;
	color: #444;
	border-bottom: 1px solid <?php 
		if (isset($URBAN->headerbordercolor))
			echo $URBAN->headerbordercolor; ?>;

	background-color: <?php echo $URBAN->headerbgcolor; ?>;
	opacity: <?php echo $URBAN->headerbgcolor_o; ?>;

	text-indent: -9999px;
	background-image: url(../images/logo.png);
	background-repeat: no-repeat;
	background-position: center center;
}

#error-login{
	background-color:#f00;
    text-align:center;
    color:#FFF;
    padding:10px 0;
    }

form {
	background-color: <?php echo $URBAN->formbgcolor; ?>;
	opacity: <?php echo $URBAN->formbgcolor_o; ?>;
	padding: 6% 4%;
}
#remember {
	margin-bottom: 4%;
}
#remember label {
	font-size: 12px;
	color: #444;
}
#footer {
	text-align: right;
	padding: 8px 15px 10px 0;
	border-top: 1px solid <?php 
		if (isset($URBAN->footerbordercolor))
			echo $URBAN->footerbordercolor; ?>;

	background-color: <?php echo $URBAN->footerbgcolor; ?>;
	opacity: <?php echo $URBAN->footerbgcolor_o; ?>;
}
#footer a {
	color: <?php 
		if (isset($URBAN->footertextcolor))
			echo $URBAN->footertextcolor; ?>;

	font-size: 12px;
	text-decoration: none;
}
#footer a:hover {
	color: <?php 
		if (isset($URBAN->footerhovertextcolor))
			echo $URBAN->footerhovertextcolor; ?>;;
}
input[type="email"], input[type="text"], input[type="password"] {
	width: 92%;
	background: #fff;
	margin-bottom: 4%;
	border: 1px solid #ccc;
	padding: 4%;
	font-family: 'Arial';
	font-size: 95%;
	color: #555;
}
input[type="submit"] {
	width: 100%;
	background: <?php 
		if (isset($URBAN->buttonbgcolor))
			echo $URBAN->buttonbgcolor; ?>;
	border: 0;
	padding: 4%;
	font-family: 'Arial';
	font-size: 100%;
	color: <?php 
		if (isset($URBAN->buttontextcolor))
			echo $URBAN->buttontextcolor; ?>;
	cursor: pointer;
	transition: background .3s;
	-webkit-transition: background .3s;
}
input[type="submit"]:hover {
	color: <?php 
		if (isset($URBAN->buttonhovertextcolor))
			echo $URBAN->buttonhovertextcolor; ?>;
	background: <?php 
		if (isset($URBAN->buttonhoverbgcolor))
			echo $URBAN->buttonhoverbgcolor; ?>;
}

#credits {
    background-color: #ffffff;
    bottom: 0;
    color: #333;
    display: block;
    font-size: 9px;
    height: 14px;
    line-height: 13px;
    opacity: 0.8;
    position: absolute;
    text-align: right;
    width: 100%;
}
#credits a {
    color: #333;
    margin-right: 5px;
    text-decoration: none;
}
#credits a:hover {
    color: #ff6600;
    text-decoration: none;
}