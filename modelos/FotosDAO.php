<?php 
class FotosDAO{

    private mysqli $conn;

    public function __construct($conn){
        $this->conn=$conn;
    }


    public function insert(int $idAnuncio ,array $fotos): bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO fotosAnuncio (foto,idAnuncio) VALUES (?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
       
       foreach($fotos as $foto){
        $stmt->bind_param('si',$foto,$idAnuncio);
        $stmt->execute();
       }
        
        if($this->conn->affected_rows==count($fotos)){
            return true;
        }
        else{
            return false;
        }
    }

    
     public function getById($idAnuncio) : Foto|null{
        if(!$stmt=$this->conn->prepare("SELECT * FROM fotosAnuncio WHERE idAnuncio = ?")){
            echo"Error en la SQL:".$this->conn->error;
        }
            $stmt->bind_param('i',$idAnuncio);
            $stmt->execute();
            $result=$stmt->get_result();
            
            if($result->num_rows==1){
                $foto=$result->fetch_object(Foto::class);
                return $foto;
            }else{
                return null;
            }

          
      }  

      public function getFotosById($idAnuncio):array{
        if(!$stmt=$this->conn->prepare("SELECT * FROM fotosAnuncio WHERE idAnuncio = ?")){
            echo"Error en la SQL:".$this->conn->error;
        }
            $stmt->bind_param('i',$idAnuncio);
            $stmt->execute();
            $result=$stmt->get_result();
            

            $array_fotos=array();
           while($foto=$result->fetch_object(Foto::class)){
            $array_fotos[]=$foto;
           }
           return $array_fotos;

          
      } 
    

      public function getAll():array{
        if(!$stmt= $this->conn->prepare("SELECT * FROM fotosAnuncio")){
            echo "Error en la SQL:".$this->conn->error;

        }
        $stmt->execute();
        $result=$stmt->get_result();

        $array_fotos=array();
        while($foto=$result->fetch_object(Foto::class)){
            $array_fotos[]=$foto;
        }
        return $array_fotos;
      }

      function delete($idAnuncio):bool{

        if(!$stmt = $this->conn->prepare("DELETE FROM anuncios WHERE idAnuncio = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$idAnuncio);
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

      
    
}



?>