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
 $prep_stmt = "SELECT id FROM members WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
    
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows == 1) {
            // In caso di duplicato (user già esistente)
            $error_msg .= '<p class="error">Un username come il tuo è già presente nel nostro database.</p>';
        }
    } else {
        $error_msg .= '<p class="error">Database error</p>';
    }
    if (empty($error_msg)) {
        // Crea una sessione crittografata per utente
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

        // Crea una password crittografata
        $password = hash('sha512', $password . $random_salt);

        // INSERISCE I DATI NEL DATABASE
        if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, email, password, salt) VALUES (?, ?, ?, ?)")) {
            $insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Registration failure: INSERT');
                exit();
            }
        }
        header('Location: ./register_success.php');
        exit();
    }
}
