<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");
?>
<!doctype html>
<html lang="de">
	<head>
		<title>JOINS</title>
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
					<th scope="col">Geschlecht</th>
					<th scope="col">Reg-Zeitpunkt</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = "
					SELECT
						*
					FROM tbl_user
				";
				$userliste = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
				while($user = $userliste->fetch_object()) {
					// ---- so sicher nicht! ----
					// Grund: viel zu ineffizient, da pro User erneut die DB abgefragt werden muss
					if(!is_null($user->FIDGeschlecht)) {
						$sql = "
							SELECT
								Geschlecht
							FROM tbl_geschlechter
							WHERE(
								IDGeschlecht=" . $user->FIDGeschlecht . "
							)
						";
						$geschlechter = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
						$geschlecht = $geschlechter->fetch_object();
						$bezGeschlecht = $geschlecht->Geschlecht;
					}
					else {
						$bezGeschlecht = "-";
					}
					// --------------------------
					
					echo('
						<tr>
							<td>' . $user->IDUser . '</td>
							<td>' . $user->Emailadresse . '</td>
							<td>' . $user->Passwort . '</td>
							<td>' . $user->Vorname . '</td>
							<td>' . $user->Nachname . '</td>
							<td>' . $user->GebDatum . '</td>
							<td>' . $user->FIDGeschlecht . ' | ' . $bezGeschlecht . '</td>
							<td>' . $user->RegZeitpunkt . '</td>
						</tr>
					');
				}
				?>
			</tbody>
		</table>
	</body>
</html>