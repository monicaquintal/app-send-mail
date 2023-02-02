<?php

require "./libs/PHPMailer/Exception.php";
require "./libs/PHPMailer/OAuth.php";
require "./libs/PHPMailer/PHPMailer.php";
require "./libs/PHPMailer/POP3.php";
require "./libs/PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// echo '<hr>';


class Mensagem {

  private $para = null;
  private $assunto = null;
  private $mensagem = null;
  public $status = array('codigo_status' => null, 'descricao_status' => '');

  public function __get($atributo) {
    return $this->$atributo;
  }

  public function __set($atributo, $valor) {
    $this->$atributo = $valor;
  }

  public function mensagemValida() {
    if (empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
      return false;
    }
    return true;
  }
}

$mensagem = new Mensagem();
$mensagem->__set('para', $_POST[('para')]);
$mensagem->__set('assunto', $_POST[('assunto')]);
$mensagem->__set('mensagem', $_POST[('mensagem')]);

// echo '<pre>';
// print_r($mensagem);
// echo '</pre>';

if(!$mensagem->mensagemValida()) {
  echo "Mensagem inválida!";
  header('Location: ./index.php');
} 

$mail = new PHPMailer(true);
try {
    //Server settings
    // o "false" abaixo faz com que n mostre msgs do debug!
    $mail->SMTPDebug = false;//SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'seu.email@gmail.com';                     //SMTP username
    $mail->Password   = 'senha';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('seu.email@gmail.com', 'Monica');
    $mail->addAddress($mensagem->__get('para'));     //Add a recipient
    // $mail->addReplyTo('info@example.com', 'Information'); // encaminha sempre as respostas a esse destinatário
    // $mail->addCC('cc@example.com'); // com cópia
    // $mail->addBCC('bcc@example.com'); // cópia oculta

    //Attachments (anexos)
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $mensagem->__get('assunto');
    $mail->Body    = $mensagem->__get('mensagem');
    $mail->AltBody = "É necessário utilizar um client que suporte HTML para ter acesso total ao conteúdo desta mensagem!";
    $mail->send();
    
    $mensagem->status['codigo_status'] = 1;
    $mensagem->status['descricao_status'] = 'E-mail enviado com sucesso!';
} catch (Exception $e) {
    $mensagem->status['codigo_status'] = 2;
    $mensagem->status['descricao_status'] = 'Não foi possível enviar este e-mail. Por favor, tente novamente mais tarde!' . $mail->ErrorInfo;
}

?>

<html>
	<head>
		<meta charset="utf-8" />
    	<title>App Send Mail</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	</head>

	<body>
    <div class="container">
      <div class="py-3 text-center">
        <img class="d-block mx-auto mb-2" src="./assets/logo.png" alt="" width="72" height="72">
        <h2>Send Mail</h2>
         <p class="lead">Seu app de envio de e-mails particular!</p>
      </div>

      <div class="row">
        <div class="col-md-12">

          <?php

          if ($mensagem->status['codigo_status'] == 1) {
          ?>  

            <div class="container">
              <h1 class="display-4 text-success">Sucesso!</h1>
              <p><?= $mensagem->status['descricao_status']?></p>
              <a href="./index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a> 
            </div>

          <?php  
          } 
          ?>

          <!-- fluxo de erro -->
          <?php

          if ($mensagem->status['codigo_status'] == 2) {
          ?>  

            <div class="container">
              <h1 class="display-4 text-danger">Ops!</h1>
              <p><?= $mensagem->status['descricao_status']?></p>
              <a href="./index.php" class="btn btn-danger btn-lg mt-5 text-white">Voltar</a> 
            </div>

          <?php  
          } 
          ?>  

        </div>
      </div>

    </div>
  </body>
</html>