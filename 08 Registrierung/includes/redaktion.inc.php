<?php
function rollen_show(int $idUser, int $idRolle):string {
    global $conn;
    
    if($_SESSION["Berechtigungsstufe"]<=10) {
        $r = '
            <select name="IDRolle[]">
        ';

        $sql = "
            SELECT
                *
            FROM tbl_rollen
            WHERE(
                Berechtigungsstufe>10
            )
            ORDER BY Berechtigungsstufe DESC
        ";
        $rollen = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
        while($rolle = $rollen->fetch_object()) {
            if($idRolle==$rolle->IDRolle) { $selected = "selected" ; }
            else { $selected = ""; }
            $r.= '<option value="' . $idUser . ',' . $rolle->IDRolle . '" ' . $selected . '>' . $rolle->Rolle . '</option>';
        }
        
        $r.= '</select>';
    }
    else {
        $sql = "
            SELECT
                Rolle
            FROM tbl_rollen
            WHERE(
                IDRolle=" . $idRolle . "
            )
        ";
        $rollen = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
        $rolle = $rollen->fetch_object();
        $r = $rolle->Rolle;
    }
    
    return $r;
}
?>