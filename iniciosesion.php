<?php
//session_start();
require_once 'modelos/ConnexionDB.php';
require_once 'modelos/Usuario.php';
require_once 'modelos/DAO.php';
require_once 'modelos/config.php';


$conexionBD=new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
$conn=$conexionBD->getConnexion();

if($_SERVER['REQUEST_METHOD']=='POST'){

$email=htmlentities($_POST['email']);
$password=htmlentities(($_POST['password']));
$nombre=htmlentities($_POST['nombre']);
$telefono=htmlentities(($_POST['telefono']));
$poblacion=htmlentities($_POST['poblacion']);
$foto='';

$DAO=new DAO($conn);
if($usuario=$DAO->getByEmail($email)){
    if(password_verify($password,$usuario->getPassword())){

        $_SESSION['email']=$usuario->getEmail();
        $_SESSION['nombre']=$usuario->getNombre();
        $_SESSION['telefono']=$usuario->getTelefono();
        $_SESSION['poblacion']=$usuario->getPoblacion();
        $_SESSION['foto']=$usuario->getFoto();
        $_SESSION['id']=$usuario->getId();

        setcookie('sid',$usuario->getSid(),time()+7*24*60*60,'/');
        header('location:index.php');
        die();
    }
}
}
guardarMensaje("Email o password incorrectos");
header('location:index.php');
?>
