 <?php
//SECURE LOGIN / BY / LVXWEB / OPENSOURCE / PROJECT / PHP / MYSQL / COOKIE /CONTACT: LVXWEB96@PROTONMAIL.COM//

include_once 'db_connect.php';
include_once 'func_config.php';

$error_msg = "ERROR"; //solito errore di connessione che stamperà in caso di mancata connessione al database.
if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Prova e valida i dati inseriti
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Se l'email non è valida
        $error_msg .= '<p class="error">L'email da te inserita non è valida</p>';
    }
    
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // esegue un processo di crittografia..
        $error_msg .= '<p class="error">Password non valida.</p>';
    }

