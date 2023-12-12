<?php 
class AnunciosDAO{

    private mysqli $conn;

    public function __construct($conn){
        $this->conn=$conn;
    }


    function insert($anuncio): int|bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO anuncios (precio, titulo,descripcion,categoria,fecha,foto,idUsuario) VALUES (?,?,?,?,?,?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $precio = $anuncio->getPrecio();
        $titulo= $anuncio->getTitulo();
        $descripcion=$anuncio->getDescripcion();
        $categoria=$anuncio->getCategoria();
        $fecha=$anuncio->getFecha();
        $foto = $anuncio->getFoto();
        $idUsuario=$anuncio->getIdUsuario();
        
        
        $stmt->bind_param('dsssssi',$precio, $titulo,$descripcion,$categoria,$fecha,$foto,$idUsuario);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }

    
      public function getById($id) : Anuncio|null {
        if(!$stmt=$this->conn->prepare("SELECT * FROM anuncios WHERE id = ?")){
            echo"Error en la SQL:".$this->conn->error;
        }
            $stmt->bind_param('i',$id);
            $stmt->execute();
            $result=$stmt->get_result();

            if($result->num_rows==1){
                $anuncio=$result->fetch_object(Anuncio::class);
                return $anuncio;
            }else{
                return null;
            }
      }  
      public function getByIdUsu($idUsuario) : array {
        if(!$stmt=$this->conn->prepare("SELECT * FROM anuncios WHERE idUsuario = ?")){
            echo"Error en la SQL:".$this->conn->error;
        }
            $stmt->bind_param('i',$idUsuario);
            $stmt->execute();
            $result=$stmt->get_result();

            $array_anuncios=array();
            while($anuncio=$result->fetch_object(Anuncio::class)){
                $array_anuncios[]=$anuncio;
            }
            return $array_anuncios;

           
      }  

      public function getAll():array{
        if(!$stmt= $this->conn->prepare("SELECT * FROM anuncios ORDER BY fecha desc")){
            echo "Error en la SQL:".$this->conn->error;

        }
        $stmt->execute();
        $result=$stmt->get_result();

        $array_anuncios=array();
        while($anuncio=$result->fetch_object(Anuncio::class)){
            $array_anuncios[]=$anuncio;
        }
        return $array_anuncios;
      }
      
      function delete($id):bool{

        if(!$stmt = $this->conn->prepare("DELETE FROM anuncios WHERE id = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Comprobamos si ha borrado algún registro o no
        if($stmt->affected_rows==1){
            return true;
        }
        else{
            return false;
        }
        
    }

    function update($anuncio){
        if(!$stmt = $this->conn->prepare("UPDATE anuncios SET titulo=?,categoria=?,precio=?,foto=? WHERE id=?")){
            die("Error al preparar la consulta update: " . $this->conn->error );
        }
        $precio = $anuncio->getPrecio();
        $titulo = $anuncio->getTitulo();
        $categoria=$anuncio->getCategoria();
        $foto = $anuncio->getFoto();
        $id = $anuncio->getId();
        $stmt->bind_param('ssisi',$titulo,$categoria,$precio,$foto,$id);
        return $stmt->execute();

    }

    function getTituloAnuncio($titulo):array|bool{
        if (!$stmt= $this->conn->prepare("SELECT * FROM anuncios WHERE titulo LIKE ?")) {
          die("Error al preparar la consulta getTituloAnuncio " .$this->conn->error);
        }
        $busca = '%'.$titulo.'%';
        $stmt->bind_param('s',$busca);
        $stmt->execute();
        $listAnuncios = array();
        $result = $stmt->get_result();

        while($anuncio = $result->fetch_object(Anuncio::class)){
          $listAnuncios[]= $anuncio;
        }
        if(empty($listAnuncios)){
            return false;
        }
        return $listAnuncios;
      }
}
    




?>