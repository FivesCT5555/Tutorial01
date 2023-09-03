<?php
require("includes/common.inc.php");
require("includes/config.inc.php");
require("includes/conn.inc.php");

if(count($_POST)==0) {
    $_POST["Marke"] = "";
    $_POST["Modell"] = "";
    $_POST["BJ"] = "";
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>alle Modelle</title>
    <link rel="stylesheet" href="css/common.css">
</head>

<body>
    <h1>Modellliste</h1>
    <form method="post">
        <label>
            Marke: <input type="text" name="Marke" value="<?php echo($_POST["Marke"]); ?>">
        </label>
        <label>
            Modell: <input type="text" name="Modell" value="<?php echo($_POST["Modell"]); ?>">
        </label>
        <label>
            Baujahr: <input type="number" name="BJ" value="<?php echo($_POST["BJ"]); ?>">
        </label>
        <input type="submit" value="filtern">
    </form>
    <?php
    echo('<ul>');
    $where_marken = "";
    if(count($_POST)>0) {
        if(strlen($_POST["Marke"])>0) {
            $where_marken = "
                WHERE(
                    Markenname LIKE '%" . $_POST["Marke"] . "%'
                )
            ";
        }
    }
    $sql = "
        SELECT * FROM tbl_marken
        " . $where_marken . "
        ORDER BY Markenname ASC
    ";
    $marken = $GLOBALS["conn"]->query($sql) or die("Fehler in der Query: " . $GLOBALS["conn"]->error . "<br>" . $sql);
    while($marke = $marken->fetch_object()) {
        echo('
            <li>
                ' . $marke->Markenname . '
                <ul>
        ');
        
        // ---- alle Modelle zur Marke: ----
        $arr_modelle = ["FIDMarke=" . $marke->IDMarke];
        if(count($_POST)>0) {
            if(strlen($_POST["Modell"])>0) {
                $arr_modelle[] = "Modell LIKE '%" . $_POST["Modell"] . "%'";
            }
        }
        $sql = "
            SELECT * FROM tbl_modelle
            WHERE(
                " . implode(" AND ",$arr_modelle) . "
            )
            ORDER BY Modell ASC
        ";
        $modelle = $GLOBALS["conn"]->query($sql) or die("Fehler in der Query: " . $GLOBALS["conn"]->error . "<br>" . $sql);
        while($modell = $modelle->fetch_object()) {
            echo('
                <li>
                    ' . $modell->Modell . '
                    <ul>
            ');
            
            // ---- alle Baureihen zum Modell: ----
            $arr_baureihen = ["FIDModell=" . $modell->IDModell];
            if(count($_POST)>0) {
                if(intval($_POST["BJ"])>0) {
                    $arr_baureihen[] = "BaujahrVon<=" . $_POST["BJ"];
                    $arr_baureihen[] = "BaujahrBis>=" . $_POST["BJ"];
                }
            }

            $sql = "
                SELECT * FROM tbl_baureihen
                WHERE (
                    " . implode(" AND ",$arr_baureihen) . "
                )
            ";
            $baureihen = $GLOBALS["conn"]->query($sql) or die("Fehler in der Query: " . $GLOBALS["conn"]->error . "<br>" . $sql);
            while($baureihe = $baureihen->fetch_object()) {
                echo('
                    <li>
                        <a href="modell_teile.php?IDBaureihe=' . $baureihe->IDBaureihe . '">' . $baureihe->BaujahrVon . ' - ' . $baureihe->BaujahrBis . '</a>
                    </li>
                ');
            }
            // ENDE alle Baureihen zum Modell: ----
            
            echo('
                    </ul>
                </li>
            ');
        }
        // ENDE alle Modelle zur Marke: ----
        
        echo('
                </ul>
            </li>
        ');
    }
    echo('</ul>');
    ?>
</body>
</html>