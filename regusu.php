<?php 
require_once 'modelos/ConnexionDB.php';
require_once 'modelos/Usuario.php';
require_once 'modelos/DAO.php';
require_once 'modelos/config.php';


$error='';
if($_SERVER['REQUEST_METHOD']=='POST'){

    $email=htmlentities($_POST['email']);
    $password=htmlentities($_POST['password']);
    $nombre=htmlentities($_POST['nombre']);
    $telefono=htmlentities($_POST['telefono']);
    $poblacion=htmlentities($_POST['poblacion']);
    $foto='';

    $connexionDB=new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
    $conn=$connexionDB->getConnexion();

    $DAO=new DAO($conn);
        if($DAO->getByEmail($email)!=null){
            $error="Ya hay un usuario con este email";

            
        }else{
           

            if($_FILES['foto']['type']!='image/jpeg' && $_FILES['foto']['type']!='image/webp' && $_FILES['foto']['type']!='image/png'){
                $error="La foto no tiene el formato adecuado";
            }else{
                $foto=generarNombreArchivo($_FILES['foto']['name']);

                while(file_exists("fotoUsuario/$foto")){
                    $foto=generarNombreArchivo($_FILES['foto']['name']);
                }
                if(!move_uploaded_file($_FILES['foto']['tmp_name'], "fotoUsuario/$foto")){
                    die("Error al copiar la foto a la carpeta fotoUsuarios");
                }
            }
            


            if($error==''){
                $usuario=new Usuario();
                $usuario->setEmail($email);
                $passwordCifrado=password_hash($password,PASSWORD_DEFAULT);
                $usuario->setPassword($passwordCifrado);
                $usuario->setNombre($nombre);
                $usuario->setTelefono($telefono);
                $usuario->setPoblacion($poblacion);
                $usuario->setFoto($foto);
                $usuario->setSid(sha1(rand()+time()),true);

                if($DAO->insert($usuario)){
                    header('location:index.php');
                    die();
                }else{
                    $error="No se ha podido insertar el usuario";
                }
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
    <h1>Registro</h1>
    <?= $error ?>
    <form action="regusu.php" method="post" enctype="multipart/form-data">
       Email: <input type="email" name="email"><br>
       Password: <input type="password" name="password"><br>
       Nombre: <input type="text" name="nombre"><br>
       Telefono: <input type="text" name="telefono"><br>
       Poblacion: <input type="text" name="poblacion"><br>
        <input type="file" name="foto" accept="image/jpeg, image/gif, image/webp, image/png"><br>
        <input type="submit" value="registrar">
        <a href="index.php">volver</a>
    </form>
</body>
</html>