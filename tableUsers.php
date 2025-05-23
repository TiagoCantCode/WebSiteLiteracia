<!-- 
    tabela de utilizadores
    dataaccess
    chamar o getUsers
    criar a tabela em html
    isto só é visível se o utilizador for admin
    a tabela deverá permitir editar e eliminar 
-->
<script>
    function confirmarEliminar(){
        return confirm("Tem a certeza?");
    }
</script>

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">E-mail</th>
      <th scope="col">Type</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>

<?php 
    include_once("db/dataAccess.php");
    $da = new dataAccess();
    if ( isset ($_GET['textSearch']) && $_GET['textSearch'] != "" ){
        $results = $da->searchUsers($_GET['textSearch']);
    }else{
        $results = $da->getUsers();
    }
    
    if(is_int($results) && $results == -1){
        echo "<script>alert('Erro. Contacte o administrador')</script>";
    }else{
        while ( $row = mysqli_fetch_object($results) ){
            echo "
            <tr>
                <td>$row->id</th>
                <td>$row->name</td>
                <td>$row->email</td>
                <td>$row->type</td>
                <td>
                    <a href='updateUser.php?id=$row->id'>
                        <img style='height:16px' src='images/edit.png'/>
                    </a>
                </td>
                <td>
                    <a href='db/delete.php?id=$row->id' onclick='return confirmarEliminar()'>
                        <img style='height:16px' src='images/delete.png'/>
                    </a>
                </td>
            </tr>
            ";
            
        }
    }


?>
    </tbody>
</table>