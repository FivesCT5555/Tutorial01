<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");

// ---- Schritt 2: SQL-Statement formulieren ----
// wähle nur ausgewählte Spalten je Datensatz:
$sql = "
	SELECT
		IDUser,
		Emailadresse,
		Passwort,
		RegZeitpunkt
	FROM tbl_user
";

// wähle alle Spalten aus und filtere wie folgt: entweder muss die Person im Nachnamen das Wort "Müller" an irgendeiner Stelle stehen haben und ein leeres Geburtsdatum besitzen ODER im Vornamen Silvia heißen
$sql = "
	SELECT
		*
	FROM tbl_user
	WHERE (
		Nachname LIKE '%Müller%' AND
		GebDatum IS NULL OR
		Vorname='Silvia'
	)
";

// wähle alle Spalten aus und sortiere nach dem Nachnamen absteigend und innerhalb der sortierten Nachnamen nach dem Vornamen aufsteigend
$sql = "
	SELECT
		*
	FROM tbl_user
	ORDER BY Nachname DESC, Vorname ASC
";

//
$sql = "
	SELECT
		*
	FROM tbl_user
	LIMIT 3,4
";
// ENDE Schritt 2: SQL-Statement formulieren ----

// ---- Schritt 3: SQL-Statement übermitteln ----
// ... und die Antwort des DB-Servers entgegennehmen (hier: $daten)
$daten = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
// ENDE Schritt 3: SQL-Statement übermitteln ----

?>
<!doctype html>
<html lang="de">
	<head>
		<title>DB</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<table>
			<thead>
				<tr>
					<th scope="col">IDUser</th>
					<th scope="col">Emailadresse</th>
					<th scope="col">Passwort</th>
					<th scope="col">Vorname</th>
					<th scope="col">Nachname</th>
					<th scope="col">Geb-Datum</th>
					<th scope="col">Reg-Zeitpunkt</th>
				</tr>
			</thead>
			<tbody>
				<?php
				// ---- Schritt 4: Daten verarbeiten (SELECT) ----
				while($ds = $daten->fetch_object()) {
					echo('
						<tr>
							<td>' . $ds->IDUser . '</td>
							<td>' . $ds->Emailadresse . '</td>
							<td>' . $ds->Passwort . '</td>
							<td>' . $ds->Vorname . '</td>
							<td>' . $ds->Nachname . '</td>
							<td>' . $ds->GebDatum . '</td>
							<td>' . $ds->RegZeitpunkt . '</td>
						</tr>
					');
				}
				// ENDE Schritt 4: Daten verarbeiten (SELECT) ----
				
				?>
			</tbody>
		</table>
					
	</body>
</html>