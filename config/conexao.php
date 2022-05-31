<?php
session_start();

// requerimento do phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

    $modo = 'local';
    
    if($modo == 'local'){
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $banco = "login";
    }

    if($modo == 'producao'){
        $servidor = "";
        $usuario = "";
        $senha = "";
        $banco = "";
    }

    try{
        $pdo = new PDO("mysql:host=$servidor;dbname=$banco",$usuario,$senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $erro){
        echo "Error ao conectar ao banco!";
    }

    function limparPost($dados){
        $dados = trim($dados);
        $dados = stripslashes($dados);
        $dados = htmlspecialchars($dados);
        return $dados;
    }

    function auth($tokenSessao){
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE token=? LIMIT 1");
        $sql->execute(array($tokenSessao));
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);
        if(!$usuario){
            return false;
        }else{
            return $usuario;
        }
    }

?>