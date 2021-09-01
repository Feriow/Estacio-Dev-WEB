<?php
/***VALIDAÇÃO DOS DADOS RECEBIDOS DO FORMULÁRIO ***/

if($_REQUEST['nome'] == "") {
   echo "O campo Nome não pode ficar vazio.";
   exit;
}

if(strlen($_REQUEST['cpf']) != 11){
   echo "O campo CPF deve conter 11 dígitos.";
   exit;
}

if(!stripos($_REQUEST['email'], '@') || !stripos($_REQUEST[email], '.')){
   echo "O campo e-mail não é válido.";
   exit;
}

if($_REQUEST['data_nascimento'] == "") {
   echo "O campo Data de nascimento não pode ficar vazio.";
   exit; 
}

/***FIM DA VALIDAÇÃO DOS DADOS RECEBIDOS DO FORMULÁRIO ***/

/***CONEXÃO COM O BD ***/
//Constantes para armazenamento das variáveis de conexão.
define('HOST', 'localhost');
define('PORT', '3306');
define('DBNAME', 'teste');
define('USER', "root");
define('PASSWORD', '');

$con_string = "mysql:host=" . HOST .
   ";port=" . PORT .
   ";dbname=" . DBNAME .
   ";user=" . USER .
   ";password=" . PASSWORD;

// Criação do PDO

try {
   $dsn = new PDO($con_string);
   echo "conexão com sucesso";
} catch (PDOException $e) {
   echo 'A conexão falhou e retornou a seguinte mensagem de erro: ' . $e->getMessage();
}

/*** FIM DOS CÓDIGOS DE CONEXÃO COM O BD ***/

/***PREPARAÇÃO E INSERÇÃO NO BANCO DE DADOS ***/


// Dados para inserção
$stmt = $dsn->prepare("INSERT INTO cliente(nome, cpf, email, data_nascimento) VALUES (?,?,?,?)");

$nome_cliente = $_REQUEST['nome'];
$cpf_cliente = $_REQUEST['cpf'];
$email_cliente = $_REQUEST['email'];
$data_nascimento_cliente = $_REQUEST['data_nascimento'];
$array_dados = [$nome_cliente, $cpf_cliente, $email_cliente, $data_nascimento_cliente];


$resultSet = $stmt->execute($array_dados);


if ($resultSet) {
   echo "Os dados foram inseridos com sucesso. \n\n";
} else {
   echo "Ocorreu um erro e não foi possível inserir os dados. \n\n";
   exit;
}

//Destruindo o objecto statement e fechando a conexão
$stmt = null;
$dsn = null;

?>