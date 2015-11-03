<?php
    session_start();

    // try to access database or stop the script
    try {
        $bdd = new PDO("mysql:host=localhost;dbname=minichat;charset=utf8", "root", "");
    } catch (Exception $ex) {
        die("Error : " . $ex->getMessage());
    }

    // Execute query and store results
    $query = "SELECT pseudo, message, date FROM message ORDER BY date DESC";
    $messageEntries = $bdd->query($query);

    // user input error management
    $errorType = ((isset($_GET['error'])) ? $_GET['error'] : "NO_ERROR");
    $errorMessage = "";
    switch ($errorType) {
        case "E_EMPTY_NICKNAME" :
            $errorMessage = "Merci de renseigner votre pseudo";
            break ;
        case "E_EMPTY_MESSAGE" :
            $errorMessage = "Le champ de message est vide";
            break ;
        default :
            break ;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" lang="fr" />
        <title>minichat</title>
        <link rel="stylesheet" href="css/index.css" type="text/css" />
    </head>
    <body>
        <!--    if there is an error    -->
        <?php if ($errorType != "NO_ERROR") : ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        
        <!--    minichat form    -->
        <form action="./php/minichat.php" method="post">
            <p>
                <label for="nickname">Pseudo : </label>
                <!--        if the user already posted a message search for his nickname is SESSION           -->
                <input type="text" id="nickname" name="nickname"
                       value="<?php echo ((isset($_SESSION['nickname'])) ? $_SESSION['nickname'] : ""); ?>"
                       <?php echo ((isset($_SESSION['nickname'])) ? "" : "autofocus"); ?> />
            </p>
            <p>
                <label for="message">Message : </label>
                <input type="text" id="message" name="message"
                       <?php echo ((isset($_SESSION['nickname'])) ? "autofocus" : ""); ?>/>
            </p>
            <p><input type="submit" value="Envoyer" /></p>
        </form>
        <section class="minichat">
            <?php foreach ($messageEntries as $messageEntry) : ?>
                <p>
                    [<span class="time"><?php echo date("d/m/Y H:i:s", strtotime($messageEntry['date'])); ?></span>]
                    <strong><?php echo $messageEntry['pseudo']; ?></strong> 
                    : <?php echo $messageEntry['message']; ?></p>
            <?php endforeach; ?>
        </section>
    </body>
</html>