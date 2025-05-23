<?php 
/*
receber os dados por post 
dataaccess 
chamar a função updateUser 
*/

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $idType = $_POST['idType'];

    include_once("dataAccess.php");
    $da = new dataAccess();
    $res = $da->updateUser($id, $name, $email, $idType);
    if($res == -1)
        echo "<script>alert('Erro. Contacte o administrador')</script>";
    else
        echo "<script>alert('Utilizador atualizado com sucesso')</script>";
    
    echo "<script>window.location.href='../index.php'</script>";
}


?>