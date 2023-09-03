<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");

// ---- Schritt 2: SQL-Statement formulieren ----
$sql = "
	SELECT * FROM tbl_user
";
// ENDE Schritt 2: SQL-Statement formulieren ----

// ---- Schritt 3: SQL-Statement übermitteln ----
// ... und die Antwort des DB-Servers entgegennehmen (hier: $daten)
$daten = $conn->query($sql);
if($daten===false) {
	if(TESTMODUS) {
		die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
	}
	else {
		header("Location: errors/db_query.html");
	}
}
ta($daten);
// ENDE Schritt 3: SQL-Statement übermitteln ----

// ---- Schritt 4: Daten verarbeiten (SELECT) ----
while($ds = $daten->fetch_object()) {
	ta($ds);
	echo("Email=" . $ds->Emailadresse . "<br>");
}
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