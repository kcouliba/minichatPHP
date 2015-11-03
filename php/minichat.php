<?php
    session_start();
    
    if (!isset($_POST['nickname']) || (strlen($_POST['nickname']) < 1)) {
        header('Location: ../index.php?error=E_EMPTY_NICKNAME');
        exit ;
    }
    if (!isset($_POST['message']) || (strlen($_POST['message']) < 1)) {
        header('Location: ../index.php?error=E_EMPTY_MESSAGE');
        exit ;
    }
    $nickname = htmlspecialchars($_POST['nickname']);
    $message = htmlspecialchars($_POST['message']);
    try {
        $bdd = new PDO("mysql:host=localhost;dbname=minichat;charset=utf8", "root", "");
    } catch (Exception $ex) {
        die("Error : " . $ex->getMessage());
    }
    $query = "INSERT INTO message (pseudo, message, date) VALUES (?, ?, ?)";
    $request = $bdd->prepare($query);
    $request->execute(array($nickname, $message, date("Y-m-d H:i:s")));
    $_SESSION['nickname'] = $nickname;
    header('Location: ../index.php');
?>