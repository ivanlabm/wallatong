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


$anuncios=array();
$anunciosDAO = new AnunciosDAO($conn);
if (isset($_SESSION['id'])) {
    $anuncios = $anunciosDAO->getByIdUsu($_SESSION['id']);
} else {
    $error = 'No hay id';
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
                <span id="emailUsuario"><?= $_SESSION['nombre'] ?></span>
            </div>
                <button class="subir"><a href="subirproducto.php"><img src="/PRACTICA1/img/suma.png" id="imgsubir">Subir producto</a></button>
                
            </div>
           </header>
           <?php endif;?>
           </header>
        <div class="menu">
            <nav id="menu">
        <a href="index.php">Anuncios</a>
        <a href="misAnuncios.php">Mis Anuncios</a>
        <a href="logout.php">cerrar sesión</a>
            </nav>
        </div>
    <main>
   <section id="anuncios">
      <div id="articulos">  
    <?php foreach ($anuncios as $anuncio): ?>
       

            <article>
            <a href="ver_anuncio.php?id=<?=$anuncio->getId()?>">
            <?php 
                    $imagen = $anuncio->getFoto();
                    $ruta = "fotosAnuncio/";
                    $rutaCompleta = $ruta . $imagen;
                    if (!empty($rutaCompleta)) {
                        echo "<img src='$rutaCompleta' width='350px'>";
                    }else{
                        echo "Imagen no existe";
                    }
                ?>
            <h4 class="titulo">
            <span><?= $anuncio->getTitulo() ?></a>
            </h4>
            <span><?= $anuncio->getPrecio() ?>€</span>
            </a>
            <div>
        <button><a href="borrar.php?id=<?=$anuncio->getId()?>">Borrar</a></button> 
         <button><a href="editar.php?id=<?=$anuncio->getId()?>">Editar</a></button> 
         <button><a href="index.php">Volver a los Anuncios</a></button>
         </div>
        </article>
          
        <?php  endforeach; ?>
           </div>  
    </section>
    </main>
</body>
</html>
