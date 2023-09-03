<?php
session_start(); //sollte immer der erste (oder einer der ersten) Befehl(e) sein, der ausgeführt wird; in jedem Fall darf davor KEIN Eintrag in den Ausgabebuffer erfolgen

function ta($in) {
	echo('<pre class="ta">');
	print_r($in);
	echo('</pre>');
}

ta($_POST);

if(count($_POST)>0) {
	if(isset($_POST["btnLogout"]) && $_POST["btnLogout"]=="ausloggen") {
		//User möchte sich ausloggen
		$_SESSION = []; //überschreibt sämtlichen Inhalt des bestehenden Arrays mit einem leeren Array --> "Löschen des Inhalts"

		if(ini_get("session.use_cookies")) {
			$params = session_get_cookie_params(); //Einlesen des bestehenden Cookies, um daraufhin ein neues Cookie mit den alten Werten zu schreiben
			setcookie(
				session_name(),
				'',
				time() - 86400,
				$params["path"],
				$params["domain"],
				$params["secure"],
				$params["httponly"]
			);
		}

		session_destroy(); //löscht die Session-ID
	}
}

if(!(isset($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"])) {
	header("Location: 06_login02.php");
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
		<form method="post">
			<input type="submit" value="ausloggen2" name="btnLogout2">
			<input type="submit" value="ausloggen" name="btnLogout">
		</form>
		<p>Ich bin eine geschützte Seite! Wirklich!</p>
		<form method="post">
			<input type="text" name="N">
			<input type="submit" name="btnKontakt" value="Kontakt aufnehmen">
		</form>
	</body>
</html>