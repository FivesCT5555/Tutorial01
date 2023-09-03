<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Auslesen von Verzeichnissen</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
		<style>
			.dir {
				font-weight:bold;
			}
			.file {
				font-style:italic;
			}
			.link {
				color:green;
			}
		</style>
	</head>
	<body>
		<?php
		$vz = "./";
		$inhalt = scandir($vz); //liest sämtliche Datei-, Verzeichnis- und Verknüpfungsnamen in ein Array ein und gibt dieses zurück
		ta($inhalt);
		echo('<ul>');
		foreach($inhalt as $d) {
			if(is_dir($vz.$d)) {
				echo('<li class="dir">' . $d . '</li>');
			}
			else {
				if(is_file($vz.$d)) {
					echo('<li class="file">' . $d . '</li>');
				}
				else {
					echo('<li class="link">' . $d . '</li>');
				}
			}
		}
		echo('</ul>');
		?>
	</body>
</html>