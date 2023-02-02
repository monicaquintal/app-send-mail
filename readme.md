<div align="center">
<h1>App Send Mail ✉🐘</h1>
<h3>Desenvolvimento Web Completo 2022</h3>
</div>

---

<div id="aula01" align= "justify">
<h2>Objetivo 🎯</h2>

Estudo do conteúdo abordado na [Seção 12: PHP e Orientação a Objetos](https://github.com/monicaquintal/estudandoPHP-orientacao-a-objetos):

- Paradigma de Orientação a Objetos;
- Uso de recursos como namespaces e tratamento de erros com try/catch;
- Incorporar biblioteca phpmailer;
- Segurança do lado do back-end da aplicação, protegendo arquivos sigilosos.

<h2>O projeto 💭</h2>

Aplicação funcional, capaz de enviar e-mails através do serviço de SMTP do Gmail (muito utilizado em sites comerciais).

No front-end da aplicação, um formulário, onde serão inseridos email, assunto e mensagem. O back-end fará o processamento necessário para disparar a mensagem de sucesso (caso o usuário seja válido).

<h2>Aulas 📚</h2>

<a href="#aula01">Aula 01: Introdução.</a><br>
<a href="#aula02">Aula 02: Iniciando o projeto.</a><br>
<a href="#aula03">Aula 03: Enviando dados do front-end para o back-end via método Post.</a><br>
<a href="#aula04">Aula 04: Criando e instanciando a Classe Mensagem.</a><br>
<a href="#aula05">Aula 05: Adicionando a biblioteca PHPMailer ao projeto.</a><br>
<a href="#aula06">Aula 06: Configurando o PHPMailer e envindo e-mails.</a><br>
<a href="#aula07">Aula 07: Enviando e-mails com base nos parâmetros do front-end.</a><br>


</div>

<div>
<h3>Aula 01: Introdução</h3>
</div>

Apresentação do projeto e seus objetivos.

<div id="aula02">
<h3>Aula 02: Iniciando o projeto</h3>
</div>

Iniciando o projeto: criação do diretório app-send-mail, incluindo arquivo `index.php` e imagem `logo.png`.

<div id="aula03">
<h3>Aula 03: Enviando dados do front-end para o back-end via método Post</h3>
</div>

- definindo o método de envio do formulário (`post`) e o arquivo de destino (`processa_envio.php` - back-end da aplicação).

- atribuindo names para os campos, para posteriormente explorá-lo individualmente.

<div id="aula04">
<h3>Aula 04: Criando e instanciando a Classe Mensagem</h3>
</div>

- submeter os dados via POST para o back-end.

- criação da classe Mensagem, definição dos atributos e métodos propostos e instanciando um objeto.

~~~php
echo '<pre>';
print_r($_POST);
echo '</pre>';
echo '<hr>';

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

  public function __mensagemValida() {
    // implementaremos posteriormente
  }
}

$mensagem = new Mensagem();
$mensagem->__set('para', $_POST[('para')]);
$mensagem->__set('assunto', $_POST[('assunto')]);
$mensagem->__set('mensagem', $_POST[('mensagem')]);

echo '<pre>';
print_r($mensagem);
echo '</pre>';
~~~

  Com retorno:

  ~~~
Array
(
  [para] => teste
  [assunto] => teste
  [mensagem] => teste

)

-------------------------------------

Mensagem Object
(
  [para:Mensagem:private] => teste
  [assunto:Mensagem:private] => teste
  [mensagem:Mensagem:private] => teste

)
  ~~~

- verificar se os dados contidos no Objeto (mensagem) são válidos, para determinar se devemos ou não dar continuidade no processamento da lógica da aplicação.

~~~php
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

if($mensagem->mensagemValida()) { // true
  echo "A mensagem é válida!";
} else { // false
  echo "Mensagem inválida!";
}
~~~

<div id="aula05">
<h3>Aula 05: Adicionando a biblioteca PHPMailer ao projeto</h3>
</div>

- adicionando a biblioteca [PHPMailer](https://packagist.org/packages/phpmailer/phpmailer) no projeto, a partir do site [Packagist](https://packagist.org/), repositório por trás do Composer.

- acessando o repositório no GitHub do [PHPMailer](https://github.com/PHPMailer/PHPMailer), e fazendo o download da [versão 6.4.1](https://github.com/PHPMailer/PHPMailer/releases/tag/v6.4.1), que inclui atualizações que deixaram o pacote mais compatível com as versões 7 e 8 do PHP.

- baixar o arquivo compactado contendo a biblioteca, e adicionar ao diretório do projeto.

- para adicionar a lib:
  - importar os arquivos PHPMailer no script processa_envio.php (`require`);

~~~php
require "./libs/PHPMailer/Exception.php";
require "./libs/PHPMailer/OAuth.php";
require "./libs/PHPMailer/PHPMailer.php";
require "./libs/PHPMailer/POP3.php";
require "./libs/PHPMailer/SMTP.php";
~~~

  - importar os namespaces (`use`);

~~~php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
~~~

  - copiar a instrução que produz uma instância em PHPMailer, bem como try/catch associado (alterando a lógica do operador e inserindo dentro do if/else):

~~~php
if(!$mensagem->mensagemValida()) {
  echo "Mensagem inválida!";
  die();
} // lógica

// ctrl c+ ctrl v do repositório:
$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'user@example.com';                     //SMTP username
    $mail->Password   = 'secret';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
    $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');
    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Não foi possível enviar este e-mail! Por favor, tente novamente mais tarde.";
    echo "Detalhes do erro: {$mail->ErrorInfo}";
}
~~~

<div id="aula06">
<h3>Aula 06: Configurando o PHPMailer e envindo e-mails.</h3>
</div>

`Servidor SMTP` tem o funcionamento parecido com os Correios: despachamos uma determinada correspondência, e ele é responsável por receber essa correspondência e organizar a sua entrega.

Há diversos servidores SMTP disponíveis de fotma gratuita, como o próprio Gmail do Google.


### Entendendo a interação entre as partes da aplicação:

O front-end se comunica com o back-end através do protocolo HTTP, enquanto a aplicação implementa uma biblioteca que vai utilizar um serviço disponível na Internet.
Então, através da Internet, utilizando o protocolo SMTP, é feita uma autenticação no Gmail para, a partir da nossa aplicação, disparar um e-mail, sendo o Gmail o responsável por fazer essa entrega ao destinatário!

### Implementando na prática:

1. Criar uma conta no Gmail.

2. Inserir login e senha do e-mail no script `processa_envio.php`.

~~~php
$mail = new PHPMailer(true);
try {
  <...>                                
  $mail->Username   = 'seu.email@gmail.com';                   
  $mail->Password   = 'senha';    
  <...>             
} catch {
  <...>
}      
~~~

3. Informar o Host (servidor SMTP) que utilizaremos como gateway.

- acessar o artigo ["Enviar e-mails usando uma impressora, um scanner ou um app"](https://support.google.com/a/answer/176600?hl=pt);
  
- inserir o DNS (endereço): smtp-relay.gmail.com (conforme acesso em 01/02/2023).

~~~php
$mail->Host = 'smtp-relay.gmail.com';  
~~~

- configurações de segurança (criptografia em tls) e porta (587).

- ajustando remetente e destinatários.

~~~php
//Recipients
$mail->setFrom('monica.zoom@gmail.com', 'Mônica Remetente');
$mail->addAddress('monica.zoom@gmail.com', 'Mônica Destinatário');     //Add a recipient
// $mail->addReplyTo('info@example.com', 'Information'); // encaminha sempre as respostas a esse destinatário
// $mail->addCC('cc@example.com'); // com cópia
// $mail->addBCC('bcc@example.com'); // cópia oculta
~~~

- alterando demais parâmetros (de anexos, mensagem, etc).

~~~php
try {
  <...>
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
~~~

4. Relizando um teste!

Neste caso, ocorrerá uma mensagem se erro, pois geralmente servidores SMTP são fechados para aplicações externas.

Portanto, é necessário autorizar previamente que apps externos ao domínio tenham acesso a realizar autenticação com aqueles usuários.

### IMPORTANTE:

Atualmente, a opção de "apps menos seguros" não está mais autorizada pelo Google! Agora precisamos gerar uma senha exclusiva para este fim.

Para configurar uma senha exclusiva para o projeto, acesse a conta de e-mail do Gmail que será utilizada em seu projeto e siga os passos:

1. Clique na opção "Gerenciar sua Conta do Google";
2. Clique na opção "Segurança";
3. Ative a opção de "Verificação em duas etapas";
4. Clique na opção "Senhas de app";
5. Clique na opção "Selecione o app e o dispositivo para o qual você quer gerar a senha de app" e escolha a opção "Outro";
6. Defina um nome (pode ser qualquer nome) e depois clique em "gerar";
7.  A senha será gerada, basta copiá-la;
8. Utilize a senha copiada no passo 7 no arquivo de configuração de envio de e-mail (processa_envio.php);
9. Após realizar estes passos o envio de e-mails deve funcionar normalmente.

<div id="aula07">
<h3>Aula 07: Enviando e-mails com base nos parâmetros do front-end.</h3>
</div>