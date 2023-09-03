<?php
function ta($in) {
	echo('<pre class="ta">');
	print_r($in);
	echo('</pre>');
}


if(count($_POST)>0) {
	//es wurde ein Formular abgeschickt

	ta("Inhalt der POST-Daten:");
	ta($_POST);
	
	// ---- im ersten Moment wäre die Angabe der Credentials auf diese Art und Weise ok, so spannend es auch aussieht (aber: wir werden dazu noch mehr erfahren): ----
	$email_korrekt = "test@test.at";
	$pwd_korrekt = "test123";
	// ----
	
	if($_POST["E"]==$email_korrekt && $_POST["P"]==$pwd_korrekt) {
		//die eingegebenen Zugangsdaten waren korrekt --> Weiterleiten auf einen geschützten Bereich, Meldung an den User, etc.
		echo('<p class="success">Vielen Dank. Sie werden in Kürze weitergeleitet.</p>');
	}
	else {
		//die Emailadresse und/oder das Passwort waren nicht korrekt --> Meldung an den User
		echo('<p class="error">Leider waren die eingegebenen Daten nicht korrekt. Bitte versuchen Sie es erneut.</p>');
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