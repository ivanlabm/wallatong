<?php 
session_start();
require_once 'modelos/ConnexionDB.php';
require_once 'modelos/Usuario.php';
require_once 'modelos/DAO.php';
require_once 'modelos/Anuncio.php';
require_once 'modelos/AnunciosDAO.php';


//Creamos la conexión utilizando la clase que hemos creado
$connexionDB=new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
$conn = $connexionDB->getConnexion();

//Si existe la cookie y no ha iniciado sesión, le iniciamos sesión de forma automática
if( !isset($_SESSION['email']) && isset($_COOKIE['sid'])){
    //Nos conectamos para obtener el id y la foto del usuario
    $DAO = new DAO($conn);
    //$usuario = $usuariosDAO->getByEmail($_COOKIE['email']);
    if($usuario = $DAO->getBySid($_COOKIE['sid'])){
        //Inicio sesión
        $_SESSION['email']=$usuario->getEmail();
        $_SESSION['id']=$usuario->getId();
        $_SESSION['foto']=$usuario->getFoto();
    }
    
}


$anunciosDAO = new AnunciosDAO($conn);
$anuncios = $anunciosDAO->getAll();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $titul=htmlspecialchars($_POST("buscar"));
    $arrayfiltrar= Array();
$arrayfiltrar=$anunciosDAO->getTituloAnuncio($titul);
}





?>
   <?php 
        imprimirMensaje();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">  
    <style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,400;1,100&family=Signika+Negative&display=swap');
</style>
</head>
<body>
   
  
        <?php if(isset($_SESSION['email'])):?>  
           <header>
            <div class ="ri">
                <div css="titulo">
             <p><img src="/PRACTICA1/img/lgbueno.png" alt="">wallatong</p>
               </div>
            </div>   
            <div class="le">
            <div class="usu">
                <img src="fotoUsuario/<?= $_SESSION['foto']?>"class="fotoUsuario">
                <span id="emailUsuario"><?= $_SESSION['nombre'] ?></span><br>
                <span id="idUsu"><?= $_SESSION['id'] ?></span>
            </div>
                <button class="subir"><a href="subirproducto.php"><img src="/PRACTICA1/img/suma.png" id="imgsubir">Subir producto</a></button>
                
            </div>
           </header>
   
        <?php else:?>
     <header>
     <div class ="ri">
                <div class="titulo">
             <p><img src="/PRACTICA1/img/lgbueno.png" alt="">wallatong</p>
               </div>
            </div>   
            <div class="le">
                <button class="subir"><a href="registro.php"><img src="/PRACTICA1/img/suma.png" alt="" id="imgsubir">Subir producto</a></button>
                <button><a href="registro.php">Registrate o Iniciar sesion</a></button>
                
            </div>
         
        <?php endif;?>
            <hr>
        </header>
        <div class="menu">
            <nav id="menu">
        <a href="index.php">Anuncios</a>
        <a href="misAnuncios.php">Mis Anuncios</a>
        <a href="logout.php">cerrar sesión</a>

        <form action="index.php" method="post">
            <p>
            <input type="search" name="buscar">
            <button type="submit"><img src="img/lupa.png" width="15px"></button>
            </p>
        </form>
            </nav>
        </div>
    
  
      <div id="articulos">  
        <?php if (empty($arrayfiltrar)):?>
    <?php foreach ($anuncios as $anuncio): ?>
       

            <article>
            <a href="ver_anuncio.php?id=<?=$anuncio->getId()?>">
            <img src="fotosAnuncio/<?= $anuncio->getFotoanu() ?>"> 
            <h4 class="titulo">
            <span><?= $anuncio->getTitulo() ?></a>
            </h4>
            <span><?= $anuncio->getPrecio() ?>€</span>
            </a>
            </article>
          
        <?php  endforeach; ?>
        <?php else:?>

        <?php foreach ($arrayfiltrar as $anuncio): ?>
       

       <article>
       <a href="ver_anuncio.php?id=<?=$anuncio->getId()?>">
       <img src="fotosAnuncio/<?= $anuncio->getFotoanu() ?>"> 
       <h4 class="titulo">
       <span><?= $anuncio->getTitulo() ?></a>
       </h4>
       <span><?= $anuncio->getPrecio() ?>€</span>
       </a>
       </article>
     
   <?php  endforeach; ?>
            <?php endif;?>
           </div>  
  
   
</body>
</html>
