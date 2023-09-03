<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");
?>

<!doctype html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <titel>Lehrgangsdurchführungen - Vortrragende und Einsatz</titel>
        <link rel="css/common.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
<body>
    <?php
        $sql="
            SELECT 
                tbl_vortragende.Nachame,
                tbl_vortragende.Vorname,
                tbl_vortragende.SVNr,
                tbl_vortragende.GebDatum,
                tbl_vortragende.Telno,
                tbl_vortragende.Emailadresse,
                tbl_einsaetze.Stundenzahl,
                tbl_lehrgangsdurchfuehrungen.Beginnjahr,
                FROM tbl_einsaetze,
                LEFT JOIN tbl_vortragende,
                ON tbl_einsaetze.FIDVortragender=tbl_vortragende.IDVortragender,
                INNER JOIN tbl_lehrgangsdurchfuehrungen,
                ON tbl_einsaetze.FIDLehrgangsdurchfuehrung=tbl_lehrgangsdurchfuehrungen.IDLehrgangsdurchfuehrung,
        ";
        $summ="";
        $datensaetze=$conn->query($sql) or die("Fehler in der Query:" . $conn->error . "<br>" . $sql);
        while ($ldf=$datensaetze->fetch_object()) {
            echo('
                <li>' . $ldf->Beginnjahr . 'Vorname:' . $ldf->Vorname . 'Nachname:' . $ldf->Nachname . 'SVNr.:' . $ldf->SVNr . 
                'Geb Datum:' . $ldf->GebDatum . 'Telno:' . $ldf->Telno . 'Emailadresse:' . $ldf->Emailadresse . 'IDEinsatz:' . $ldf->IDEinsatz . '</li>
            ');
        }
    ?>
</body>
</html>