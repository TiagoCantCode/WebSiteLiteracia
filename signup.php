<?php 
// cria uma função em php que verifica se um email é valido 
function isEmailValido(string $email): bool {
    //echo "verificar email";
    // Utiliza a função filter_var() com o filtro FILTER_VALIDATE_EMAIL
    // para verificar se a string fornecida é um endereço de e-mail válido.
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}

// cria uma função em php que verifica se uma password 
    //tem no mínimo 8 caracteres, pelo menos 1 letra maiuscula, pelo menos 1 digito  
function verificarPasswordRequisitos(string $password): bool {
   // echo "verificar password";
    // Verifica se a senha tem no mínimo 8 caracteres
    if (strlen($password) < 8) {
      return false;
    }
  
    // Verifica se a senha contém pelo menos uma letra maiúscula
    if (!preg_match('/[A-Z]/', $password)) {
      return false;
    }
  
    // Verifica se a senha contém pelo menos um dígito
    if (!preg_match('/\d/', $password)) {
      return false;
    }
  
    // Se todas as condições forem atendidas, retorna true
    return true;
}

if (isset($_POST['email'])){
    $email = $_POST['email']; 
    $pwd = $_POST['inputPwd']; 
  
    //verificar os dados do email e da password 
    if(isEmailValido($email) && verificarPasswordRequisitos($pwd)){
        $pwd = md5($pwd);
        //inserir os dados na bd ->dataaccess.php
        include_once("dataAccess.php");
       // echo "include";
        $da = new dataAccess();
        $res = $da->signup($email, $pwd);
        if ($res == 1){
          //mostrar uma mensagem de sucesso
          echo "<script>alert('Registo de utilizador efetuado com sucesso')</script>";
        }else if ( $res == -1 ){
          echo "<script>alert('Erro! Contacte o administrador')</script>";
        }else {
          echo "<script>alert('Erro! E-mail duplicado')</script>";
        }
    }else{
        //mostrar um erro 
        echo "<script>alert('Erro!')</script>";
    }
    echo "<script>window.location.href='../index.php'</script>";
  
}else{
    echo "<script>window.location.href='../index.php'</script>";
}
    

    

?>