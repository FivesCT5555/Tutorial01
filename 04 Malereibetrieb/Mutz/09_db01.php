<?php
require("includes/config.inc.php");
require("includes/common.inc.php");

// ---- Schritt 1: Verbindung herstellen: ----
$conn = new MySQLi("localhost","root","","db_3443_2"); //versucht, eine Verbindung zu einem Datenbankserver herzustellen und eine Datenbank auf diesem Server auszuwählen. Dazu werden Host-Adresse (localhost), Username (root) und Passwort (leer) benötigt. Danach brauchen wir noch den Namen der Datenbank.
if($conn->connect_errno>0) {
	if(TESTMODUS) {
		die("Fehler im Verbindungsaufbau: " . $conn->connect_error);
	}
	else {
		//Praxis/Realbetrieb:
		header("Location: errors/db_connect.html");
	}
}
$conn->set_charset("utf8mb4");
ta($conn);
// ENDE Schritt 1: Verbindung herstellen: ----

// ---- Schritt 2: SQL-Statement formulieren ----
$sql = "
	SELECT * FROM tbl_user
";
// ENDE Schritt 2: SQL-Statement formulieren ----

// ---- Schritt 3: SQL-Statement übermitteln ----
// ... und die Antwort des DB-Servers entgegennehmen (hier: $daten)
$daten = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
ta($daten);
// ENDE Schritt 3: SQL-Statement übermitteln ----

// ---- Schritt 4: Daten verarbeiten (SELECT) ----
/*
$ds = $daten->fetch_object(); //liest den nächsten noch nicht gelesenen Datensatz aus dem Datensatzobjekt aus und liefert ein Objekt mit diesem Datensatz zurück
ta($ds);

$ds = $daten->fetch_object();
ta($ds);

$ds = $daten->fetch_object();
ta($ds);

$ds = $daten->fetch_object();
ta($ds);
*/
while($ds = $daten->fetch_object()) {
	ta($ds);
	echo("Email=" . $ds->Emailadresse . "<br>");
}
// ENDE Schritt 4: Daten verarbeiten (SELECT) ----
// ENDE Schritt 4: Daten verarbeiten (SELECT) ----
?>
<!doctype html>
<html lang="de">
	<head>
		<title>DB</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<p>Hat offensichtlich geklappt..</p>
	</body>
</html>