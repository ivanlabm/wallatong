<?php 
require_once 'modelos/ConnexionDB.php';
require_once 'modelos/config.php';
require_once 'modelos/Anuncio.php';
require_once 'modelos/AnunciosDAO.php';
require_once 'modelos/DAO.php';
require_once 'modelos/Foto.php';
require_once 'modelos/FotosDAO.php';

$error ='';


//Conectamos con la bD
$connexionDB=new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
$conn = $connexionDB->getConnexion();

//Obtengo el id del anuncio que viene por GET
$idAnuncio = htmlspecialchars($_GET['id']);

$anunciosDAO = new AnunciosDAO($conn);
$anuncio = $anunciosDAO->getById($idAnuncio);



if($_SERVER['REQUEST_METHOD']=='POST'){

    //Limpiamos los datos que vienen del usuario
    $titulo = htmlspecialchars($_POST['titulo']);
    $foto = htmlspecialchars($_POST['foto']);
    $precio = htmlspecialchars($_POST['precio']);
   
    $categoria = htmlspecialchars($_POST['categoria']);
    if(empty($titulo) || empty($foto)|| empty($precio)||  empty($categoria)){
        $error = "Los campos son obligatorios";
    }
    else{
        $anuncio->setTitulo($titulo);
        $anuncio->setFoto($foto);
        $anuncio->setPrecio($precio);
      
        $anuncio->setCategoria($categoria);
        

        if($anunciosDAO->update($anuncio)){
            header('location: index.php');
            die();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?= $error ?>
    <form action="editar.php?id=<?= $idAnuncio ?>" method="post">
        Titulo:<input type="text" name="titulo" placeholder="Titulo" value="<?=$anuncio->getTitulo()?>"><br>
        foto:<input type="file" multiple="true" name="foto" accept="image/jpeg, image/gif, image/webp, image/png" value="<?=$anuncio->getFotoanu()?>"><br>
       Precio:<input type="text" name="precio" placeholder="Precio" value="<?=$anuncio->getPrecio()?>"><br>
      
        Categoria: <input type="text" name="categoria" value="<?=$anuncio->getCategoria()?>"><br>
        ID Usuario:<input type="text" name="Id" placeholder="IDUsuario" value="<?=$anuncio->getIdUsuario()?>"><br>
        <a href="index.php">Volver</a>
        <input type="submit">
    </form>
</body>
</html>
