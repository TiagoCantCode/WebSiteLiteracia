<?php
/*
receber o ID 
dataaccess 
chamar a função 
*/

if(isset($_GET['id'])){
    $id = $_GET['id'];
    include_once("dataAccess.php");
    $da = new dataAccess();
    $res = $da->deleteUser($id);
    if($res == -1){
        echo "<script>alert('Erro. Contacte o administrador')</script>";
    }else{
        echo "<script>alert('Utilizador eliminado com sucesso')</script>";
    }
}

echo "<script>window.location.href='../index.php'</script>";

?>