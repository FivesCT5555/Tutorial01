
<?php
function ta($in) {
	echo('<pre class="ta">');
	print_r($in);
	echo('</pre>');
}

$ausgabe = ""; //Hilfsvariable

if(count($_POST)>0) {
	//es wurde ein Formular abgeschickt

	ta($_POST);
	
	$email_korrekt = "test@test.at";
	$pwd_korrekt = "test123";
	
	if($_POST["E"]==$email_korrekt && $_POST["P"]==$pwd_korrekt) {
		//$ausgabe = '<p class="success">Vielen Dank. Sie werden in Kürze weitergeleitet.</p>';
		
		session_start(); //(1) startet die Session-Verwaltung, (2) legt eine Session-ID für diesen User an, sofern noch nicht verhanden
		$_SESSION["eingeloggt"] = true;
		
		header("Location: 05_geschuetzt.php"); //ab diesem Zeitpunkt beendet der Server die Verarbeitung DIESES Dokumentes und widmet sich der Verarbeitung von 05_geschuetzt.php
	}
	else {
		$ausgabe = '<p class="error">Leider waren die eingegebenen Daten nicht korrekt. Bitte versuchen Sie es erneut.</p>';
	}
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Login</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php echo($ausgabe); ?>
		<form method="post">
			<label>
				Ihre Emailadresse:
				<input type="email" name="E">
			</label>
			<label>
				Ihr Passwort:
				<input type="password" name="P">
			</label>
			<input type="submit" value="einloggen">
		</form>
	</body>
</html>