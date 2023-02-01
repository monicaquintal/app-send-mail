<div align="center">
<h1>App Send Mail ✉</h1>
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
<a href="#aula05">Aula 05: Adicionando a biblioteca PHPMailer ao projeto</a><br>



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