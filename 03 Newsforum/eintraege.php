<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");

function zeigeEintraege($fid=null) {
	global $conn;
	
	if(is_null($fid)) {
		$w = "FIDEintrag IS NULL";
	}
	else {
		$w = "FIDEintrag=" . $fid;
	}
	
	echo('<ul>');
	$sql = "
		SELECT
			tbl_eintraege.IDEintrag,
			tbl_eintraege.Eintrag,
			tbl_eintraege.Eintragezeitpunkt,
			tbl_user.Vorname,
			tbl_user.Nachname
		FROM tbl_eintraege
		LEFT JOIN tbl_user ON tbl_eintraege.FIDUser=tbl_user.IDUser
		ORDER BY tbl_eintraege.Eintragezeitpunkt ASC
	";
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Newsforum</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<h1>Newsforum</h1>
		<nav>
			<ul>
				<li><a href="index.html">Startseite</a></li>
				<li><a href="eintraege_user.php">User-Einträge</a></li>
				<li><a href="eintraege_suche.php">Suche nach Einträgen</a></li>
			</ul>
		</nav>
	
		<?php
		zeigeEintraege(); //Aufruf der Funktion, um sämtliche Einträge darzustellen
		?>
		
	</body>
</html>