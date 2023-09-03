<?php
require("includes/config.inc.php");
require("includes/common.inc.php");

$msg = "";

if(count($_POST)>0) {
	$vz = trim($_POST["VZNeu"]); //Hilfsvariable; elimiert Leerzeichen am Anfang und am Ende des Inhalts von $vz
	
	if(strlen($vz)>0) {
		if(!file_exists($vz)) {
			$ok = mkdir($vz,0755); //legt das Verzeichnis a im aktuellen Verzeichnis an und vergibt die Verzeichnisrechte 0755
			if($ok) {
				$msg = '<p class="success">Das Wunschverzeichnis wurde erfolgreich angelegt.</p>';
			}
			else {
				$msg = '<p class="error">Das Wunschverzeichnis konnte leider nicht angelegt werden.</p>';
			}
		}
		else {
			$msg = '<p class="error">Dieses Verzeichnis existiert bereits.</p>';
		}
	}
	else {
		$msg = '<p class="error">Leider ist dies kein gültiger Verzeichnisname.</p>';
	}
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Anlegen von Verzeichnissen</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php echo($msg); ?>
		<form method="post">
			<label>
				Bitte geben Sie einen Pfad ein:
				<input type="text" name="VZNeu" required>
			</label>
			<input type="submit" value="Verzeichnis anlegen">
		</form>
	</body>
</html>