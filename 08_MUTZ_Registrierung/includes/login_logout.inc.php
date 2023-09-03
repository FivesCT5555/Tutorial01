<?php
session_start();

if(isset($_POST["btnLogout"])) {
    $_SESSION = [];
    if(ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time()-86400,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
}

if(!(isset($_SESSION["eingeloggt"]) && $_SESSION["eingeloggt"] && isset($_SESSION["idUser"]) && intval($_SESSION["idUser"])>0)) {
    header("Location: index.html");
}
?>