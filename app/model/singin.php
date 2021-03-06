<?php
switch ($_GET['do']){
case 'logout':
        session_destroy();
        session_unset();
    require_once __DIR__ . '/../view/signinLoggedOut.php';
    break;
case 'login':
        if (!empty($_POST['password']) && password_verify($_POST['password'], $user[$_POST['login']])) {
            $_SESSION['user'] = $_POST['login'];
            $_SESSION['define'] = $_POST['login'];
            ?>
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Benvenuto <?php echo $_SESSION['user'] ?>:</strong> una volta
    finito, ricordati di uscire utilizzando il link <strong>"Esci"</strong>
    in alto a destra sulla barra.
</div>
<?php if (!array_key_exists('admin', $user)):?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Attenzione:</strong> per usufruire delle funzionalit� di blocco
    e avanzamento anni � necessario creare un utente <strong>"admin"</strong>.
</div>
<?php endif; ?>

<?php
        // Controllo se co sono messaggi dall'amministratore
        $messageFileName = './message.txt';
        $fmh = fopen($messageFileName, 'rb');
        $messageSize = filesize($messageFileName);
        if ($messageSize > 0) {
            $contents = fread($fmh, $messageSize);
?>
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Messaggio dall'amministratore:</strong> <?php echo $contents;?>
</div>
<?php
        }
        fclose($fmh);
        require_once __DIR__ . '/../model/indexModel.php';
    } else {
        $failedLogin = true;
        require_once __DIR__ . '/../view/signinForm.php';
    }
    break;
}
