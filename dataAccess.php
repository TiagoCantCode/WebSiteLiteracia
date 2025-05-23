<?php

class dataAccess{
    private $connection;
    
    private function connect(){
        try{
            $db = "health_qa";
            $user = "root";
            $pwd = "";
            $server = "localhost";
    
            $this->connection = mysqli_connect($server, $user, $pwd, $db);
            if(!$this->connection) 
                die ("error");
        }catch(Exception $ex){
            throw $ex;
        }
        
    }

    private function execute($q){
        try{
            $res = mysqli_query($this->connection, $q);
            if(!$res)
                die("invalid query");
            else
                return $res;
        }catch(Exception $ex){
            throw $ex;
        }
    }
    
    private function disconnect(){
        mysqli_close($this->connection);
    }

    private function executeSQL($query){
        try{
            $this->connect();
            $res = $this->execute($query);
            $this->disconnect();
            return $res;
        }catch(Exception $e){
            throw $e;
        }        
    }
    
    public function signup($email, $password){
        try{
            //antes de inserir o utilizador, verificar se o email já existe 
            //query de select 
            $qry = "select * from users where email = '$email'";
            $res = $this->executeSQL($qry);
            if( mysqli_num_rows($res) >= 1 ){
                //o email já existe, n posso inserir este utilizador
                return 0;
            }else{
                $qry = "insert into users(email, password, idType) values
                                        ('$email','$password', 2)";
                // echo $qry;
                $this->executeSQL($qry);
                return 1;
            }
        }catch(Exception $ex){
            return -1;
        }        
    }

    public function signin($email, $password){
        try{
            $query = "select id, name, idType from users where 
                email = '$email' and password = '$password'";
            $res = $this->executeSQL($query);
            return $res;
        }catch(Exception $ex){
            return -1;
        }        
    }

    public function getUsers(){
        try{
            $query = "select U.id, U.name, U.email, U.idType, T.name as type
                from users U
                inner join types T on U.idType = T.id";
            $res = $this->executeSQL($query);
            return $res;
        }catch(Exception $ex){
            return -1;
        }     
    }

    public function deleteUser($id){
        try{
            $query = "delete from users where id = $id";
            $this->executeSQL($query);
            return 1;
        }catch(Exception $ex){
            return -1;
        }   
    }

    public function getUser($id){
        try{
            $query = "select id, name, email, idType from users where id = $id";
            $res = $this->executeSQL($query);
            return $res;
        }catch(Exception $ex){
            return -1;
        }     
    }
 
    public function updateUser($id, $name, $email, $idType){
        try{
            $query = "update users set name = '$name', email = '$email', idType=$idType 
                            where id = $id";
            $this->executeSQL($query);
            return 1;
        }catch(Exception $e){
            return -1;
        }   
    }

    public function searchUsers($txt){        
        try{
            $query = "select  U.id, U.name, U.email, U.idType, T.name as type
                        from users U
                        inner join types T on U.idType = T.id where 
                            U.name like '%$txt%' or U.email like '%$txt%' 
                            or T.name like '%$txt%' ";
            $res = $this->executeSQL($query);
            return $res;
        }catch(Exception $ex){
            return -1;
        }     
    }
}



?>