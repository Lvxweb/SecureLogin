 <?php
//SECURE LOGIN / BY / LVXWEB / OPENSOURCE / PROJECT / PHP / MYSQL / COOKIE /CONTACT: LVXWEB96@PROTONMAIL.COM//
include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // GENERA UNA SESSIONE IN PHP.
if (isset($_POST['email'], $_POST['p'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['p']; // PASSWORD CRITTOGRAFATA
    
    if (login($email, $password, $mysqli) == true) {
        // Login success 
        header("Location: ../protected_page.php");
        exit();
    } else {
        // Login failed 
        header('Location: ../index.php?error=1');
        exit();
    }
} else {
    // SE NON è CORRETTA, STAMPA UN ERRORE
    header('Location: ../error.php?err=Impossibile eseguire il login');
    exit();
}
