<?php
session_start();
require_once '../includes/loginDB.php';
require_once '../includes/articleDB.php';

if (!isset($_SESSION['name'])) {
    header("Location: ./loginPage.php");
    exit();
}

$user = getName();
if (!$user || $user['role'] !== 'admin') {
    echo "Accès refusé.";
    exit();
}

if (!isset($_GET['id'])) {
    echo "ID article manquant.";
    exit();
}

$articleId = $_GET['id'];

deleteArticle($articleId);

header("Location: ./adminArticlesPage.php?deleted=1");
exit();
