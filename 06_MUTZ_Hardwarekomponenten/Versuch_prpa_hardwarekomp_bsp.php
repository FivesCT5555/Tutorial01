<?php
require("includes/common.inc.php");
require("includes/config.inc.php");
require("includes/conn.inc.php");
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Individual</title>
</head>
<body>
    <h1>IndividualPCs</h1>
    <!-- Eingabe möglichkeit -->
    <form method="post">
        <label>
            Komponente :
            <input type="text" name="Komp">
        </label>
        <label>
            Artikelnummer :
            <input type="text" name="Arti">
        </label>
        <input type="submit" value="filter">
    </form>
    <!-- ------------------- -->
    <?php
    $arr_W = ["tbl_produkte.FIDKategorie = 2"]; // ist das WHERE für die SQL-Anweisung, muss vor der Schleife angegeben werden
    //Abfrage der Eingaben vom USER und übergabe an das ARRAY
    if (count($_POST)>0) {
        $arr = ["tbl_konfigurator.FIDPC = tbl_produkte.IDProdukt"];
        if (strlen($_POST["Komp"])>0) {
            $arr[] = "Produkt LIKE '%" . $_POST["Komp"] . "%'";
        }
        if (strlen($_POST["Arti"])>0) {
            $arr[] = "Artikelnummer LIKE '%" . $_POST["Arti"] . "%'";
        }
        //$arr_W ist das Array für den SUBSELECT, hier wird die IDProdukte abgezählt und verglichen
        //verglichen oder Gefiltert wird: 
        //WHERE (FIDPC = IDProdukt AND Produkt LIKE '%der Eingabe%' AND Artikelnummer LIKE '%der Eingabe%')
        $arr_W[] = "
            (
                SELECT COUNT(tbl_produkte.IDProdukt) AS cnt 
                FROM tbl_konfigurator
                INNER JOIN tbl_produkte ON tbl_konfigurator.FIDKomponente = tbl_produkte.IDProdukt
                WHERE(
                    " . implode(" AND ",$arr) ."
                )
            )>0
        ";
    }
   ta($arr_W); 
    //Jetzt hohle ich mir laut Beispiel die benötigt Verfügbarkeit ---> Lieferbarkeit, Das ist der eigentliche Hauptselect
    //Über die SQL Anweisung, 
    $sql = "
        SELECT 
        tbl_produkte.*,
        tbl_lieferbarkeiten.Lieferbarkeit
        FROM tbl_produkte
        INNER JOIN tbl_lieferbarkeiten ON tbl_produkte.FIDLieferbarkeit = tbl_lieferbarkeiten.IDLieferbarkeit
        WHERE(
            " . implode(" AND ", $arr_W) . "
        )
    ";
    ta($sql);
    //Jetzte erfolrgt die Ausgabe
    $pcs = $GLOBALS["conn"]->query($sql) or die("Fehler in der Query:" . $GLOBALS["conn"]->error . "<br>" . $sql);
    //Listenausgabe Produkte und alle dazugehörigen Komponenten 
    echo('<ul>');
    while ($pc = $pcs->fetch_object()) {
        echo('
            <li>' . $pc->IDProdukt . ':
                <ul>
        ');
        //SQL-Anweisung für die AUSGABE, Produkte + Lieferbarkeit
        $sql = "
            SELECT
                tbl_produkte.*,
                tbl_lieferbarkeiten.Lieferbarkeit
            FROM tbl_konfigurator
            INNER JOIN tbl_produkte ON tbl_konfigurator.FIDKomponente = tbl_produkte.IDProdukt
            INNER JOIN tbl_lieferbarkeiten ON tbl_produkte.FIDLieferbarkeit = tbl_lieferbarkeiten.IDLieferbarkeit
            WHERE(
                FIDPC = " . $pc->IDProdukt . "
            )
            ORDER BY tbl_produkte.Produkt ASC
        ";
        ta($sql);
        //Daten wieder reinhohlen mit query, Schleife für die Ausgabe + ! Foto Anzeige klären !(das vergesse ich immer wieder)
        $produkte = $GLOBALS["conn"]->query($sql) or die ("Fehler in der Query:" . $GLOBALS["conn"]->error . "<br>" . $sql);
        //Hier nicht die Variabel vergessen für den Gesamt Preis
        $ges = 0;
        while ($produkt = $produkte->fetch_object()) {
            if (!isset($produkt->Produktfoto)) {
                $img = ' <img src= " ' . $produkt->Produktfoto . ' " alt = " ' . $produkt->Produktfoto . ' " > ';
            }
            else {
                $img = '<div>kein Foto verfübar</div>';
            }
            echo('
                <li>
                    ' . $img . '
                    <strong>' . $produkt->Artikelnummer . ' - ' . $produkt->Produkt . '</strong>
                    <div> ' . $produkt->Beschreibung . ' </div>
                    <div> ' . $produkt->Preis . ' </div>
                    <div> ' . $produkt->Lieferbarkeit . ' </div>
            ');

            //Den Gesamt Preis nicht vergessen
            $ges = $produkt->Preis;
        }

        //Ausgabe des Gesamt Preises
        echo('
            <ul>
                Gesamtpreis: ' . $ges . '
            </ul>
        ');
    }
    echo(' </ul> ');

    ?>
</body>
</html>