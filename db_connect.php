 <?php

//SECURE LOGIN / BY / LVXWEB / OPENSOURCE / PROJECT / PHP / MYSQL / COOKIE /CONTACT: LVXWEB96@PROTONMAIL.COM//

include_once 'func-config.php';   // Serve perché il file di funzione non è unico.

$mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DB_NAME); //connessione al datbase
if ($mysqli->connect_error) {
    header("Location: ../error.php?err=Impossibile stabilire la connessione al database"); //stampa un messaggio di errore se non riesce a connettersi.
    exit();
}
