<?php
require("includes/config.inc.php");
require("includes/common.inc.php");

$rootVZ = "userdaten/"; //Ausgangsverzeichnis für die Userdaten: ab hierin darf er fuhrwerken
$aktuellesVZ = $rootVZ;

ta($_POST);
//ta($_FILES);

if(count($_POST)>0) {
	if(isset($_POST["auszulesendesVZ"])) {
		$aktuellesVZ = $_POST["auszulesendesVZ"];
	}
	
	if(isset($_POST["loesche"])) {
		for($i=0; $i<count($_POST["Auswahl"]); $i++) {
			$pfad = $_POST["Auswahl"][$i];
			if(is_dir($pfad)) {
				//Verzeichnis löschen
				loescheVZ($pfad);
			}
			else {
				//ta("lösche ".$pfad);
				unlink($pfad);
			}
		}
	}
	
	if(isset($_POST["anlegen"])) {
		mkdir($aktuellesVZ.$_POST["VZNeu"],0755);
	}
}

if(count($_FILES)>0) {
	$f = $_FILES["upl"];
	for($i=0; $i<count($f["name"]); $i++) {
		if($f["error"][$i]==0) {
			move_uploaded_file($f["tmp_name"][$i],$aktuellesVZ.$f["name"][$i]);
		}
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
			echo('
				<tr>
			');
			switch(true) {
				case is_dir($vz.$d):
					echo('
						<td><input type="checkbox" name="Auswahl[]" value="' . $vz.$d . '/"></td>
						<td class="dir">' . $d . '</td>
					');
					break;
				case is_file($vz.$d):
					echo('
						<td><input type="checkbox" name="Auswahl[]" value="' . $vz.$d . '"></td>
						<td class="file">' . $d . '</td>
					');
					break;
				case is_link($vz.$d):
					echo('
						<td><input type="checkbox" name="Auswahl[]" value="' . $vz.$d . '"></td>
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

function loescheVZ($vz) {
	if(file_exists($vz)) {
		$inhalt = scandir($vz);
		foreach($inhalt as $d) {
			if($d!="." && $d!="..") {
				if(is_dir($vz.$d)) {
					loescheVZ($vz.$d."/");
				}
				else {
					//ta('lösche '.$vz.$d);
					unlink($vz.$d);
				}
			}
		}
		//ta("lösche ".$vz);
		rmdir($vz);
	}
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
		<form method="post" id="frm" enctype="multipart/form-data">
			<input type="text" name="auszulesendesVZ" value="<?php echo($aktuellesVZ); ?>">
			<section>
				<?php
				zeigeVZStruktur($rootVZ);
				?>
			</section>
			<section>
				<?php
				zeigeVZInhalt($aktuellesVZ);
				?>
				<fieldset>
					<label>
						Bitte Dateien auswählen:
						<input type="file" name="upl[]" multiple>
					</label>
					<input type="submit" value="hochladen">
				</fieldset>
				<fieldset>
					<label>
						Ausgewählte Dateien und Verzeichnisse löschen:
						<input type="submit" value="löschen" name="loesche">
				</fieldset>
				<fieldset>
					<label>
						Im ausgewählten Verzeichnis ein neues Verzeichnis anlegen:
						<input type="text" name="VZNeu">
					</label>
					<input type="submit" value="anlegen" name="anlegen">
			</section>
		</form>
	</body>
</html>