<?php
require("includes/config.inc.php");
require("includes/common.inc.php");

ta($_FILES);

$msg = "";
$whitelist = ["image","text"]; //Liste erlaubter Bildtypen (nur Haupttyp)

if(count($_FILES)>0) {
	//es gibt ein Formular, das abgeschickt wurde und in dem zumindest die Möglichkeit besteht, eine Datei hochzuladen; ob tatsächlich eine Datei hochgeladen wurde, wissen wir noch nicht
	
	$f = $_FILES["Upload"]; //Hilfsvariable (Array)
	
	if($f["error"]==0) {
		//während des Uploads ist kein Fehler aufgetreten --> Datei aus dem temporären Verzeichnis nehmen und im Zielverzeichnis ablegen
		
		$aufteilung = explode("/",$f["type"]); //Array mit sämtlichen Teilen, aufgeteilt auf Basis eines Schrägstrichs
		ta($aufteilung);
		if(in_array($aufteilung[0],$whitelist)) {
			//die hochgeladene Datei ist von einem Typen, der in unserer Whitelist erlaubt wird
			$ok = move_uploaded_file(
				$f["tmp_name"],
				"uploads/" . $f["name"]
			);
			if($ok) {
				$msg = '<p class="success">Vielen Dank, die Datei ' . $f["name"] . ' wurde erfolgreich hochgeladen.</p>';
			}
			else {
				$msg = '<p class="error">Leider konnte die Datei ' . $f["name"] . ' nicht gespeichert werden. Bitte melden Sie sich bei uns unter unserer <a href="mailto:noreply@test.at" target="_blank">Support-Email</a></p>';
			}
		}
		else {
			$msg = '<p class="error">Die Datei ' . $f["name"] . ' ist leider keine erlaubte Bilddatei. Bitte laden Sie eine andere Datei hoch.</p>';
		}
	}
	else {
		$msg = '<p class="error">Leider ist beim Upload ein Fehler aufgetreten. Bitte versuchen Sie es erneut.</p>';
	}
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Upload</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php echo($msg); ?>
		<form method="post" enctype="multipart/form-data">
			<input type="file" name="Upload">
			<input type="submit" value="hochladen">
		</form>
	</body>
</html>