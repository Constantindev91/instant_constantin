<?php
session_start();

if (!$_SESSION['connected']) {
    echo json_encode(["success" => false, "error" => "Vous n'êtes pas connecté"]);
    die;
}

if (!$_SESSION['admin']) {
    echo json_encode(["success" => false, "error" => "Vous n'êtes pas administrateur, accès interdit"]);
    die;
}

if (isset($_FILES['file']['name'])) {
    $filename = $_FILES['file']['name'];

    $location = "../img/" . $filename;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);

    $valid_extensions = array("jpg", "jpeg", "png");

    if (in_array(strtolower($imageFileType), $valid_extensions)) {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
            $location = "../img/" . $filename;
            echo json_encode(["success" => true, "picture" => $location]);
        } else echo json_encode(["success" => false, "error" => "L'image n'a pas pu être transférée"]);
    } else echo json_encode(["success" => false, "error" => "L'extension de l'image n'est pas acceptée"]);
} else echo json_encode(["success" => false, "error" => "Les données ne sont pas correctement renseignée"]);


session_start();
require_once("db_connect.php");

if (!$_SESSION['admin']) {
    echo json_encode(["success" => false, "error" => "Vous n'êtes pas administrateur, accès interdit"]);
    die;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') $method = $_POST;
else $method = $_GET;

switch ($method['choice']) {

    case 'update':
        if (
            isset($method['img'],$method['id_img']) &&
            !empty(trim($method['img'])) &&
            !empty(trim($method['id_img']))
        ) {
            $sql = "UPDATE products SET img = :img WHERE id_img = :id_img";
            $req = $db->prepare($sql);
            $req->bindValue(':img', $method['img']);
            $req->bindValue(':id_img', $method['id_img']);
            $req->execute();

            echo json_encode(["success" => true]);
        } else echo json_encode(["success" => false, "error" => "Les données ne sont pas correctement renseignée"]);
        break;

    case 'insert':
        if (
            isset($method['img']) &&
            !empty(trim($method['img']))
    
        ) {
            $sql = "INSERT INTO img (img) VALUES (:img)";
            $req = $db->prepare($sql);
            $req->bindValue(':img', $method['img']);
            $req->execute();

            echo json_encode(["success" => true, 'id_img' => $db->lastInsertId()]);
        } else echo json_encode(["success" => false, "error" => "Les données ne sont pas correctement renseignée"]);
        break;

    default:
        echo json_encode(["success" => false, "error" => "Ce choix n'existe pas"]);
        break;
}
