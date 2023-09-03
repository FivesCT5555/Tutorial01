<?php
require("includes/config.inc.php");
require("includes/common.inc.php");

function loescheVZ($vz) {
	echo('
		<ul>
			<li>zu löschendes Verzeichnis: ' . $vz . '</li>
	');
	if(file_exists($vz)) {
		//ok, Verzeichnis(pfad) existiert --> gehen wir's an mit dem Auslesen des Verzeichnisses
		echo('<li>ja, dieses Verzeichnis existiert</li>');
		$inhalt = scandir($vz);
		foreach($inhalt as $d) {
			if($d!="." && $d!="..") {
				if(is_dir($vz.$d)) {
					echo('<li>Verzeichnis ' . $vz.$d . ' --> muss ausgelesen werden...');
					loescheVZ($vz.$d."/");
					echo('</li>');
				}
				else {
					echo('<li>Datei/Verknüpfung ' . $vz.$d . ' --> löschen</li>');
					unlink($vz.$d);
				}
			}
		}
		echo('<li>alles leer --> Verzeichnis ' .$vz . ' löschen</li>');
		rmdir($vz);
	}
	echo('</ul>');
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Löschen von Verzeichnissen</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php
		loescheVZ("a/");
		?>
	</body>
</html>