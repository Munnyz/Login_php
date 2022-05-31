<?php
    require('config/conexao.php');

    $user = auth($_SESSION['TOKEN']);
    if($user){
        echo "<h1>SEJA BEM VINDO ".$user['nome']."!</h1>";
        echo "<br><br><a href='logout.php'>Sair do Sistema</a>";
    }else{
        header('location: index.php');
    }

    
?>
