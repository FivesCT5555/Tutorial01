<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");

$arr_geschlechter = [];
$sql = "
	SELECT
		*
	FROM tbl_geschlechter
";
$geschlechter = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
while($geschlecht = $geschlechter->fetch_object()) {
	$arr_geschlechter[$geschlecht->IDGeschlecht] = $geschlecht->Geschlecht;
}
ta($arr_geschlechter);
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
					// ---- so eventuell ----
					if(!is_null($user->FIDGeschlecht)) {
						$bezGeschlecht = $arr_geschlechter[$user->FIDGeschlecht];
					}
					else {
						$bezGeschlecht = "-";
					}
					// ----------------------
					
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