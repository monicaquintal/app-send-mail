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
  die();
} 

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = 2;//SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'seu.email@gmail.com';                     //SMTP username
    $mail->Password   = 'senha';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('seu.email@gmail.com', 'Monica Remetente');
    $mail->addAddress('seu.email@gmail.com', 'Monica Destinatario');     //Add a recipient
    // $mail->addReplyTo('info@example.com', 'Information'); // encaminha sempre as respostas a esse destinatário
    // $mail->addCC('cc@example.com'); // com cópia
    // $mail->addBCC('bcc@example.com'); // cópia oculta

    //Attachments (anexos)
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Oi, eu sou o assunto!';
    $mail->Body    = 'Oi, eu sou o conteúdo do <strong>e-mail</strong>!';
    $mail->AltBody = 'Oi, eu sou o conteúdo do e-mail!';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>