<?php 
class DAO{
    private mysqli $conn;

    public function __construct($conn){
        $this->conn=$conn;
    }
    
    public function getByEmail($email):Usuario|null{
        if(!$stmt=$this->conn->prepare("SELECT * FROM usuarios WHERE email=?")){
            echo"Error en la SQL(getByEmail): ".$this->conn->error;
        }

        $stmt->bind_param('s',$email);

        $stmt->execute();

        $result=$stmt->get_result();

        if($result->num_rows >= 1){
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        }
        else{
            return null;
        }
    }
    public function getById($id):Usuario|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('s',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Mensaje, sino null
        if($result->num_rows >= 1){
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        }
        else{
            return null;
        }
    } 
    public function getBySid($sid):Usuario|null{
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE sid = ?")){
            echo "Error en la SQL:".$this->conn->error;
        }
        $stmt->bind_param('s',$sid);
        $stmt->execute();
        $result=$stmt->get_result();

        if($result->num_rows >=1){
            $usuario=$result->fetch_object(Usuario::class);
            return $usuario;
        }else{
            return null;
        }
    }
    

    function insert(Usuario $usuario): int|bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO usuarios (email, password,nombre,telefono,poblacion,foto,sid) VALUES (?,?,?,?,?,?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $email = $usuario->getEmail();
        $password = $usuario->getPassword();
        $nombre=$usuario->getNombre();
        $telefono=$usuario->getTelefono();
        $poblacion=$usuario->getPoblacion();
        $foto = $usuario->getFoto();
        $sid = $usuario->getSid();
        $stmt->bind_param('sssssss',$email, $password,$nombre,$telefono,$poblacion,$foto,$sid);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }
    }

    function generarNombreArchivo(string $nombreOriginal):string {
        $nuevoNombre = md5(time()+rand());
        $partes = explode('.',$nombreOriginal);
        $extension = $partes[count($partes)-1];
        return $nuevoNombre.'.'.$extension;
    }
    function guardarMensaje($mensaje){
        $_SESSION['error']=$mensaje;
    }
    function imprimirMensaje(){
        if(isset($_SESSION['error'])){
            echo '<div class="error" id="mensajeError">'.$_SESSION['error'].'</div>';
            unset($_SESSION['error']);
        } 
    }
    
    




?>