<?php
session_start();
require_once("db_connect.php");
error_reporting(-1);


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo json_encode(['success' =>  false, "error" => "Erreur lors de l'inscription"]);
    die;
}

if (
    isset($_POST['firstname'], $_POST['lastname'], $_POST['birthdate'], $_POST['email'], $_POST['pwd']) &&
    !empty(trim($_POST['firstname'])) &&
    !empty(trim($_POST['lastname'])) &&
    !empty(trim($_POST['birthdate'])) &&
    !empty(trim($_POST['email'])) &&
    !empty(trim($_POST['pwd']))
) {
    // if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[#?!@$ %^&*-]){8,}$/", $_POST['pwd'])) {
    //     echo json_encode(['success' => false, "error" => "Le mot de passe n'est pas au bon format"]);
    //     die;
    // }
    $hash = password_hash($_POST['pwd'], PASSWORD_DEFAULT);

    // if (!preg_match("/^([a-z0-9A-Z]+)@([a-z]+.[a-z]{3})$/", $_POST['email'])) {
    //     echo json_encode(['success' => false, "error" => "L'email n'est pas au bon format"]);
    //     die;
    // }

    $req = $db->prepare("INSERT INTO users(firstname, lastname, birthdate, email, pwd) VALUES (?, ?, ?, ?, ?)");
    $req->execute([$_POST['firstname'], $_POST['lastname'], $_POST['birthdate'], $_POST['email'], $hash]);

    echo json_encode(['success' => true]);
} else echo json_encode(['success' => false, "error" => "Tous les champs du formulaire n'ont pas été rempli"]);
