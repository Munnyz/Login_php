<?php

use PHPMailer\PHPMailer\PHPMailer;

require('config/conexao.php');

    if(isset($_POST['nome'])&& isset($_POST['email'])&& isset($_POST['senha'])&& isset($_POST['repete_senha'])){

        if(empty($_POST['nome']) or empty($_POST['email']) or empty($_POST['senha']) or empty($_POST['repete_senha']) or empty($_POST['termos'])){
            $erro_geral = "Todos os campos são obrigatórios!";
        }else{
            $nome = limparPost($_POST['nome']);
            $email = limparPost($_POST['email']);
            $senha = limparPost($_POST['senha']);
            $senha_cript = sha1($senha);
            $repete_senha =limparPost($_POST['repete_senha']);
            $checkbox =limparPost($_POST['termos']);

            if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
                $erro_nome = "Somente permitido letras!";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erro_email ="Informe um e-mail válido!";
            }
            if(strlen($senha) < 6 ){
                $erro_senha = "Senha deve ter no mínimo 6 caracteres!";
            }
            if($senha !== $repete_senha){
                $erro_repete_senha = "As senhas não estão iguais!";
            }
            if($checkbox !== "ok"){
                $erro_checkbox = "Desativado";
            }

            if (!isset($erro_geral) && !isset($erro_nome) && !isset($erro_email) && !isset($erro_senha) && !isset($erro_repete_senha) && !isset($erro_checkbox)){
                $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email=? LIMIT 1");
                $sql->execute(array($email));
                $usuario = $sql->fetch();

                if(!$usuario){
                    $recupera_senha="";
                    $token="";
                    $cod_confirmacao = uniqid();
                    $status = "novo";
                    $data_cadastro = date('d-m-Y');
                    $sql = $pdo->prepare("INSERT INTO usuarios VALUES (null,?,?,?,?,?,?,?,?)");
                    if($sql->execute(array($nome,$email,$senha_cript,$recupera_senha,$token,$cod_confirmacao,$status,$data_cadastro))){
                        // se o modo for local
                        if($modo=="local"){
                            $status = "confirmado";
                            $sql = $pdo->prepare("UPDATE usuarios SET status=?");
                            if($sql->execute(array($status))){            
                                header('location: index.php?result=ok');
                            }
                        }
                        //se o modo for producao
                        if($modo=="producao"){
                            
                            //enviar email pra usuario
                            $mail = new PHPMailer(true);
                            try{
                                // recipients
                                $mail->setFrom('sistema@email.com', 'Sistema de Login'); // quem esta mandando o email
                                $mail->addAddress($email,$nome); 

                                //content
                                $mail->isHTML(true);                    //corpo do email com html
                                $mail->Subject = 'Confirme seu cadastro';
                                $mail->Body    = '<h1>Confirme seu e-mail abaixo!<br><br><a style="background:green; color:white; text-decoration:none; padding:20px; border-radius:5px;" href="https://seusistema.com.br/confirmacao.php?cod_confirm='.$cod_confirmacao.'">Confirmar E-mail</a></h1>';
                            
                                $mail->send();
                                header('location: obrigado.php');

                            }catch (Exception $e) {
                                echo "Hoube um problema de enviar o e-mail de confirmação: {$mail->ErrorInfo}";
                            }
                        }
                    }
                }else{
                    $erro_geral = "Usuario já cadastrado!";
                }
            }

        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/estilo.css" rel="stylesheet">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <title>Cadastrar</title>
</head>
<body>
    <form method="post">
        <h1>Cadastrar</h1>

        <?php if(isset($erro_geral)){ ?>
            <div class="erro-geral animate__animated animate__rubberBand">
        <?php    echo $erro_geral; ?>
            </div>
        <?php } ?>
        

        <div class="input-group">
            <img class="input-icon" src="img/card.png">
            <input <?php if(isset($erro_geral) or isset($erro_nome)){ echo 'class="erro-input"';} ?> name="nome" type="text" placeholder="Nome Completo" <?php if(isset($nome)){ echo "value='$nome'";} ?> required>
            <?php if(isset($erro_nome)){ ?>
            <div class="erro"><?php echo $erro_nome; ?></div>
            <?php } ?> 
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/user.png">
            <input <?php if(isset($erro_geral) or isset($erro_email)){ echo 'class="erro-input"';} ?> type="email" name="email" placeholder="Seu melhor email" <?php if(isset($email)){ echo "value='$email'";} ?> required>
            <?php if(isset($erro_email)){ ?>
            <div class="erro"><?php echo $erro_email; ?></div>
            <?php } ?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/lock.png">
            <input <?php if(isset($erro_geral) or isset($erro_senha)){ echo 'class="erro-input"';} ?> type="password" name="senha" placeholder="Senha mínimo 6 Dígitos" <?php if(isset($senha)){ echo "value='$senha'";} ?> required>
            <?php if(isset($erro_senha)){ ?>
            <div class="erro"><?php echo $erro_senha; ?></div>
            <?php } ?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/lock-open.png">
            <input <?php if(isset($erro_geral) or isset($erro_repete_senha)){ echo 'class="erro-input"';} ?> type="password" name="repete_senha" placeholder="Repita a senha criada" <?php if(isset($repete_senha)){ echo "value='$repete_senha'";} ?> required>
            <?php if(isset($erro_repete_senha)){ ?>
            <div class="erro"><?php echo $erro_repete_senha; ?></div>
            <?php } ?>
        </div>   
        
        <div <?php if(isset($erro_geral)){ echo 'class="input-group erro-input"';}else{echo 'class="input-group"';} ?>>
            <input type="checkbox" id="termos" name="termos" value="ok" required>
            <label for="termos">Ao se cadastrar você concorda com a nossa <a class="link" href="#">Política de Privacidade</a> e os <a class="link" href="#">Termos de uso</a></label>
            <?php if(isset($erro_checkbox)){ ?>
            <div class="erro"><?php echo $erro_checkbox; ?></div>
            <?php } ?>
        </div>  
       
        
        <button class="btn-blue" type="submit">Cadastrar</button>
        <a href="index.php">Já tenho uma conta</a>
    </form>
</body>
</html>