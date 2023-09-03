<?php
session_start();

if(!(isset($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"])) {
	header("Location: 05_login02.php");
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Geschützt</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<h1>Geschützt</h1>
		<p>Ich bin eine geschützte Seite! Wirklich!</p>
	</body>
</html>