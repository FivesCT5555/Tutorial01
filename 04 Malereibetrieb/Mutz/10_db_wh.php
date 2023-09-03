<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");

$sql = "
	SELECT
		*
	FROM tbl_user
	WHERE(
		Nachname LIKE '%Müller%'
	)
	ORDER BY RegZeitpunkt DESC
	LIMIT 1,2
";
$datensaetze = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
?>
<!doctype html>
<html lang="de">
	<head>
		<title>DB</title>
		<meta charset="utf-8">
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
				while($ds = $datensaetze->fetch_object()) {
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
				?>
			</tbody>
		</table>
	</body>
</html>