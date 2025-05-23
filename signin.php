<?php 

if(isset($_POST['email'])){
    $email = $_POST['email'];
    $password = md5($_POST['pwd']);

    include_once("dataAccess.php");
    $da = new dataAccess();
    $result = $da->signin($email, $password);
    if(is_int($result) && $result == -1){
        echo "<script>alert('Erro. Contacte o administrador.')</script>";
    }else{
        if(mysqli_num_rows($result) == 0){
            echo "<script>alert('Erro. Credenciais inválidas.')</script>";
        }else{            
            session_start();
            $row = mysqli_fetch_object($result);
            $_SESSION['idType'] = $row->idType;
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $row->id;
            echo "<script>alert('Login efetuado com sucesso.')</script>";
        }
    }    
}

echo "<script>window.location.href='../index.php'</script>";

?>