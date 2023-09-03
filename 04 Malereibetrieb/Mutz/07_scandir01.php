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
		<ul>
			<?php
			$inhalt = scandir("images/"); //liest sämtliche Datei-, Verzeichnis- und Verknüpfungsnamen in ein Array ein und gibt dieses zurück
			ta($inhalt);
			foreach($inhalt as $d) {
				if(is_dir("images/".$d)) {
					echo('<li class="dir">' . $d . '</li>');
				}
				else {
					if(is_file("images/".$d)) {
						echo('<li class="file">' . $d . '</li>');
					}
					else {
						echo('<li class="link">' . $d . '</li>');
					}
				}
			}
			?>
		</ul>
	</body>
</html>