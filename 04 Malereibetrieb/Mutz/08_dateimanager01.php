<?php
require("includes/config.inc.php");
require("includes/common.inc.php");

$rootVZ = "userdaten/"; //Ausgangsverzeichnis für die Userdaten: ab hierin darf er fuhrwerken
$aktuellesVZ = $rootVZ;

if(count($_POST)>0) {
	ta($_POST);
	if(isset($_POST["auszulesendesVZ"])) {
		$aktuellesVZ = $_POST["auszulesendesVZ"];
	}
}

function zeigeVZStruktur($vz) {
	$inhalt = scandir($vz);
	echo('<ul>');
	foreach($inhalt as $d) {
		if($d!="." && $d!="..") {
			if(is_dir($vz.$d)) {
				//Verzeichnis gefunden -> anzeigen
				echo('<li><span onclick="merkeVZ(\''.$vz.$d.'/\');">' . $d . '</span>');
				zeigeVZStruktur($vz.$d."/");
				echo('</li>');
			}
		}
	}
	echo('</ul>');
}

function zeigeVZInhalt($vz) {
	$inhalt = scandir($vz);
	echo('
		<table>
			<thead>
				<tr>
					<th scope="col"></th>
					<th scope="col">Name</th>
				</tr>
			</thead>
			<tbody>
	');
	foreach($inhalt as $d) {
		if($d!="." && $d!="..") {
			echo('<tr>');
			switch(true) {
				case is_dir($vz.$d):
					echo('
						<td></td>
						<td class="dir">' . $d . '</td>
					');
					break;
				case is_file($vz.$d):
					echo('
						<td></td>
						<td class="file">' . $d . '</td>
					');
					break;
				case is_link($vz.$d):
					echo('
						<td></td>
						<td class="link">' . $d . '</td>
					');
					break;
			}
			echo('</tr>');
		}
	}
	echo('
			</tbody>
		</table>
	');
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Dateimanager</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
		<script>
		function merkeVZ(pfad) {
			console.log("Funktion aufgerufen: ",pfad);
			document.querySelector("[name=auszulesendesVZ]").value = pfad;
			document.querySelector("#frm").submit();
		}
		</script>
	</head>
	<body>
		<form method="post" id="frm">
			<input type="text" name="auszulesendesVZ">
			<section>
				<?php
				zeigeVZStruktur($rootVZ);
				?>
			</section>
			<section>
				<?php
				zeigeVZInhalt($aktuellesVZ);
				?>
			</section>
		</form>
	</body>
</html>