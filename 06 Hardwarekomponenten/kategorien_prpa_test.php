<?php
require("includes/common.inc.php");
require("includes/config.inc.php");
require("includes/conn.inc.php");

function lesbarkeit($fid=null) {
    global $conn;   //<---ermöglicht den Zugriff auf das conn-Objekt, das sich ja nicht innerhalb dieser Funktion befindet

    // Hier wird das WHERE, der Filter, seiner Bedeutung festgelegt
    if (is_null($fid)) {
        $where = "FIDKategorie IS NULL";
    }
    else {
        $where = "FIDKategorie =" . $fid;
    }
    //Daten reinhohlen mit SQL Anweisung
    $sql="
        SELECT *
        FORM tbl_produkte
        WHERE(
            " . $where ."
        )
    ";
    //Datensätze hohlen und Fehler Meldung Definieren
    $kats = $conn->query($sql) or die ("Fehler in der Query" . $conn->error . "<br>" . $sql);
    //Hirachische Liste erstellen
    echo('<ul>');
    //Einzelne Datensätze hohlen
    while ($kat = $kats->fetch_object($sql)) {
        echo('
            <li><a href
        ');
    }


};
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategorien</title>
</head>
<body>
    <h1>Hardwarekomponentennnnnnnnnn</h1>
    <nav>
        <ul>
            <li><a href="index.html">Startseite</a></li>
            <li><A href="individualpcs.php">Individual-PC's</a></li>
        </ul>
    </nav>
    <?php
    lesbarkeit();
    ?>
</body>
</html>