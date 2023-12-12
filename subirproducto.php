<?php 
require_once 'modelos/ConnexionDB.php';
require_once 'modelos/config.php';
require_once 'modelos/Anuncio.php';
require_once 'modelos/AnunciosDAO.php';
require_once 'modelos/DAO.php';
require_once 'modelos/Foto.php';
require_once 'modelos/FotosDAO.php';
require_once 'modelos/Usuario.php';



$error=''; 

    $connexionDB=new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
    $conn=$connexionDB->getConnexion();

   
    $DAO=new DAO($conn);



if($_SERVER['REQUEST_METHOD']=='POST'){

    $precio=htmlentities($_POST['precio']);
    $titulo=htmlentities($_POST['titulo']);
    $descripcion=htmlentities($_POST['descripcion']);
    $categoria=htmlentities($_POST['categoria']);
    $idUsuario=htmlentities($_POST['idUsuario']);
    $fecha=htmlentities($_POST['fecha']);

  

    $AnunciosDAO=new AnunciosDAO($conn);
    $anuncio=new Anuncio();


   if(empty($precio)|| empty($titulo)|| empty($descripcion)){
    $error="los campos son obligatorios";
   }else{

        $arrayfotos=array();
        $arrayTemporales=array();
        $arrayfotosfinal=array();

    if($_FILES['fotos']['error'][0]==UPLOAD_ERR_NO_FILE){
        $error="Debes añadir al menos 1 fato";
    }else if(count($_FILES['fotos']['name'])>5){
        $error="No puedes subir mas de 5 fotos ";
         }else{
            $num_fotos=count($_FILES['fotos']['name']);
            for($i=0;$i < $num_fotos; $i++){
                $arrayfotos[]=$_FILES['fotos']['name'][$i];
                $arrayTemporales[]=$_FILES['fotos']['tmp_name'][$i];
            }

        }
   foreach($arrayfotos as $i =>$foto){


    $extension=pathinfo($foto,PATHINFO_EXTENSION);
    if($extension != 'jpeg' && $extension != 'webp' && $extension != 'png'){
        $error="La foto no tiene el formato adecuado";
    }else{
        $foto=uniqid(true).'.'.$extension;
        while(file_exists("fotosAnuncio/$foto")){
            $foto=uniqid(true).'.'.$extension;
        }
        if($i==0){
            $anuncio->setFoto($foto);
        }

        foreach($arrayTemporales as $j => $fototemporal){
            if($i == $j){
                if(!move_uploaded_file($fototemporal,"fotosAnuncio/$foto")){
                    die("Error al copiar la foto a la carpeta");
                }
            }
        }
        $arrayfotosfinal[]=$foto;

    }
   }
   
   
       
        $anuncio->setPrecio($precio);
        $anuncio->setTitulo($titulo);
        $anuncio->setDescripcion($descripcion);
        $anuncio->setCategoria($categoria);
        $anuncio->setIdUsuario($idUsuario);
        $anuncio->setFecha($fecha);
      
       $idAnuncio=$AnunciosDAO->insert($anuncio);
        if($idAnuncio != null){
           $fotosDAO=new FotosDAO($conn);
           $fotosDAO->insert($idAnuncio,$arrayfotosfinal);

        }else{
            $error="No se han insertado las fotos";
        }
            header('location:index.php');
            die();
        
            
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
    <h1>Registro</h1>
    <?= $error ?>
    <form action="subirproducto.php" method="post" enctype="multipart/form-data">
       Precio: <input type="text" step="any" name="precio"><br>
       Titulo: <input type="text" name="titulo"><br>
       Descripcion: <textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
       Categoria: <input type="text" name="categoria"><br>
       Fecha: <input type="date" name="fecha"><br>
       IdUsuario: <input type="number" name="idUsuario"><br>
        <input type="file" multiple name="fotos[]" accept="image/jpeg, image/gif, image/webp, image/png"><br>
        <input type="submit" value="añadir">
        <a href="index.php">volver</a>
    </form>
</body>
</html>