<?php 
/*
session_start();
require_once 'modelos/ConnexionDB.php';
require_once 'modelos/Usuario.php';
require_once 'modelos/DAO.php';
require_once 'modelos/Anuncio.php';
require_once 'modelos/AnunciosDAO.php';
require_once 'modelos/config.php';
require_once 'modelos/Foto.php';
require_once 'modelos/FotosDAO.php';

//Creamos la conexión utilizando la clase que hemos creado
$connexionDB = new ConnexionDB('root','','localhost','wallatong');
$conn = $connexionDB->getConnexion();

$anuncioDAO = new AnunciosDAO($conn);
$titulo = isset($_GET['titulo']) ? $_GET['titulo'] : '';
$anuncioFiltro = $anuncioDAO->getTituloAnuncio($titulo);

header('location: index.php?titulo=' .urlencode($titulo));
die();
*/
?>