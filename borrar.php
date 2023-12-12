<?php 
session_start();

require_once 'modelos/ConnexionDB.php';
require_once 'modelos/config.php';
require_once 'modelos/Anuncio.php';
require_once 'modelos/AnunciosDAO.php';
require_once 'modelos/DAO.php';
require_once 'modelos/Foto.php';
require_once 'modelos/FotosDAO.php';

//Creamos la conexión utilizando la clase que hemos creado
$connexionDB = new ConnexionDB('root','','localhost','wallatong');
$conn = $connexionDB->getConnexion();

//Creamos el objeto MensajesDAO para acceder a BBDD a través de este objeto
$anunciosDAO = new AnunciosDAO($conn);
$fotosDAO=new  FotosDAO($conn);

//Obtener el Anuncio
$idAnuncio = htmlspecialchars($_GET['id']);
$anuncio = $anunciosDAO->getById($idAnuncio);

//obtenemos la ruta completa de las imagenes
$imagen = $anuncio->getFoto();
$ruta = "fotosAnuncio/";
$rutaCompleta = $ruta . $imagen;

//Comprobamos que el anuncio pretenece al usuario
if($_SESSION['id']==$anuncio->getIdUsuario()){
$fotosanun=$fotosDAO->getFotosById($idAnuncio);

//Elimina todas las fotos de el anuncio menos la principal
foreach($fotosanun as $foto){
    $fotos=$foto->getFoto();
    $rutaCompleta2 = $ruta . $fotos;
    if(file_exists($rutaCompleta2)){
        if(unlink($rutaCompleta2)){
        }else{
            $_SESSION['error']="Error al intentar eliminar un archivo";
        }
    }else{
        $_SESSION['error']="El archivo no existe en esta ruta";
    }

}

//Eliminamos la foto principal
    unlink($rutaCompleta);
    $anunciosDAO->delete($idAnuncio);
    header('location: index.php');
}
else{
    $_SESSION['error']="No puedes borrar este anuncio";
    guardarMensaje("No puedes borrar este mensaje");
}

