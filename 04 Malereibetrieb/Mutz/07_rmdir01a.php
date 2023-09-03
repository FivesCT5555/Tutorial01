<?php
require("includes/config.inc.php");
require("includes/common.inc.php");

function loescheVZ($vz) {
	$r = true;
	if(file_exists($vz)) {
		//ok, Verzeichnis(pfad) existiert --> gehen wir's an mit dem Auslesen des Verzeichnisses
		$inhalt = scandir($vz);
		foreach($inhalt as $d) {
			if($d!="." && $d!="..") {
				if(is_dir($vz.$d)) {
					$r = $r && loescheVZ($vz.$d."/");
				}
				else {
					$r = $r && unlink($vz.$d);
				}
			}
		}
		$r = $r && rmdir($vz);
	}
	
	return $r;
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
		$geloescht = loescheVZ("a/");
		echo("gelöscht? --> ".$geloescht);
		?>
	</body>
</html>