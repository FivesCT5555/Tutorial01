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
					<th scope="col">Geb-Land</th>
					<th scope="col">Reg-Zeitpunkt</th>
				</tr>
			</thead>
			<tbody>
				<?php
				// INNER JOIN:
				$sql = "
					SELECT
						tbl_user.*,
						tbl_geschlechter.Geschlecht
					FROM tbl_user
					INNER JOIN tbl_geschlechter ON tbl_geschlechter.IDGeschlecht=tbl_user.FIDGeschlecht
				";
				$userliste = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
				while($user = $userliste->fetch_object()) {
					echo('
						<tr>
							<td>' . $user->IDUser . '</td>
							<td>' . $user->Emailadresse . '</td>
							<td>' . $user->Passwort . '</td>
							<td>' . $user->Vorname . '</td>
							<td>' . $user->Nachname . '</td>
							<td>' . $user->GebDatum . '</td>
							<td>' . $user->Geschlecht . '</td>
							<td></td>
							<td>' . $user->RegZeitpunkt . '</td>
						</tr>
					');
				}
				
				echo('<tr><td colspan="8">-----</td></tr>');
				
				// LEFT JOIN:
				$sql = "
					SELECT
						tbl_user.*,
						tbl_geschlechter.Geschlecht,
						tbl_staaten.Staat
					FROM tbl_user
					LEFT JOIN tbl_geschlechter ON tbl_geschlechter.IDGeschlecht=tbl_user.FIDGeschlecht
					INNER JOIN tbl_staaten ON tbl_staaten.IDStaat=tbl_user.FIDGebLand
				";
				$userliste = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
				while($user = $userliste->fetch_object()) {
					echo('
						<tr>
							<td>' . $user->IDUser . '</td>
							<td>' . $user->Emailadresse . '</td>
							<td>' . $user->Passwort . '</td>
							<td>' . $user->Vorname . '</td>
							<td>' . $user->Nachname . '</td>
							<td>' . $user->GebDatum . '</td>
							<td>' . $user->Geschlecht . '</td>
							<td>' . $user->Staat . '</td>
							<td>' . $user->RegZeitpunkt . '</td>
						</tr>
					');
				}
				
				echo('<tr><td colspan="8">-----</td></tr>');
				
				// RIGHT JOIN:
				$sql = "
					SELECT
						tbl_user.*,
						tbl_geschlechter.Geschlecht
					FROM tbl_user
					RIGHT JOIN tbl_geschlechter ON tbl_geschlechter.IDGeschlecht=tbl_user.FIDGeschlecht
				";
				$userliste = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
				while($user = $userliste->fetch_object()) {
					echo('
						<tr>
							<td>' . $user->IDUser . '</td>
							<td>' . $user->Emailadresse . '</td>
							<td>' . $user->Passwort . '</td>
							<td>' . $user->Vorname . '</td>
							<td>' . $user->Nachname . '</td>
							<td>' . $user->GebDatum . '</td>
							<td>' . $user->Geschlecht . '</td>
							<td></td>
							<td>' . $user->RegZeitpunkt . '</td>
						</tr>
					');
				}
				?>
			</tbody>
		</table>
	</body>
</html>