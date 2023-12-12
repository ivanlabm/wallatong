<?php 
require_once 'modelos/ConnexionDB.php';
require_once 'modelos/config.php';
require_once 'modelos/Anuncio.php';
require_once 'modelos/AnunciosDAO.php';
require_once 'modelos/DAO.php';
require_once 'modelos/Foto.php';
require_once 'modelos/FotosDAO.php';

$connexionDB = new ConnexionDB('root','','localhost','wallatong');
$conn = $connexionDB->getConnexion();

$anunciosDAO = new AnunciosDAO($conn);

$idAnuncio=htmlspecialchars($_GET['id']);
$anuncio=$anunciosDAO->getById($idAnuncio);


$fotosDAO=new FotosDAO($conn);
$fotos=$fotosDAO->getFotosById($idAnuncio);





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="veranuncio.css">
</head>
<body>
<div class="ver_anuncio">
    <?php if( $anuncio!= null): ?>
       
   <div id="cuerpo">
    <h1>Foto Principal</h1>
    <img src="fotosAnuncio/<?= $anuncio->getFotoanu() ?>" id="imgtitulo"> <br>
    <div id="img">
   <?php foreach ($fotos as $foto): ?>
    
       <img src="fotosAnuncio/<?= $foto->getFoto() ?>"id="otrasimg"> <br>
     
       
        <?php  endforeach; ?>
       </div>
        <p> Titulo:<?= $anuncio->getTitulo() ?></p>
       <p> Descripcion:<?= $anuncio->getDescripcion() ?> </p>
       <p> Categoria: <?= $anuncio->getCategoria() ?> </p>
       <p>Precio:<?= $anuncio->getPrecio() ?> €</p>
       <p> IdUsuario: <?= $anuncio->getIdUsuario() ?> </p>
    </p>Fecha de creacion:<?= $anuncio->getFecha() ?> </p>
         <button><a href="borrar.php?id=<?=$anuncio->getId()?>">Borrar</a></button> 
         <button><a href="editar.php?id=<?=$anuncio->getId()?>">Editar</a></button> 
         <button><a href="index.php">Volver a los Anuncios</a></button> 
    
        </div>
    <?php else: ?>
        <strong>anuncio con id <?= $id ?> no encontrado</strong>
         <a href="index.php">Volver al listado de mensajes</a>
    <br>
   <?php endif; ?>
</div>
</body>
</html>