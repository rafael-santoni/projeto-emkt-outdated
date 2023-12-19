<?php
include_once '/home/rafasan/public_html/EMkt/includes/config.php';

if(isset($_SESSION)){
    require("login.php");
    echo "Existe sessão";
}
else{
    echo "Não existe sessão";
}
?>
<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0" />
	<title>E-Mkt Sender 1.0 - By Rafasantoni</title>
	<!-- Start css3menu.com HEAD section -->
	<link rel="stylesheet" href="CSS/main.css" type="text/css" />
	<!-- End css3menu.com HEAD section -->

	
</head>
<body>
<CENTER>
<H1>E-Mkt Sender 1.0</H1>
<?php
include(DIR.INCLUDES.'menu.html');
?>
</CENTER>

</body>
</html>
