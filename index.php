<?php


// print_r($_POST);


if ( !empty($_POST["usuario"]) && !empty($_POST["senha"]) ) {

   echo ("Logado!");

} else {

   echo("Erro ao logar");
}



$dsn = "mysql:host=localhost;dbname=php_com_pdo"; // DSN = Data Source Name

$usuario = "root";

$senha = "";


try {


   $conexao = new PDO($dsn, $usuario, $senha);



   /* --- SQL Injection --- */

   /*
   $query = "select *from users where ";

   $query .= " nome_user = '{$_POST["usuario"]}' ";

   $query .= " AND senha_user = '{$_POST["senha"]}' ";


  // echo $query;


   /$stmt = $conexao->query($query); 


   $usuario = $stmt->fetch();

   echo "<hr>";

   echo("<pre>");
   print_r($usuario);
   echo("</pre>");
   */



   /* --- Prepare Statement --- */

  $query = "select *from users where ";

  $query .= " nome_user = :usuario ";

  $query .= " AND senha_user = :senha' ";


   $stmt = $conexao->prepare($query);

   // o bindValue(), poder ser passado 3 paramento 1 = variavel ':nome_variavel', 2 = valor, valor recuperado do formulario e não obrigatorio 0 3 = paramentro - o tipo de dado usado na base de dados 

   $stmt->bindValue(":usuario", $_POST["usuario"]); // o metodo bindValue remove/analisa a existencia de qualquer SQL injection

   // $stmt->bindValue(":senha", $_POST["senha"]);

   $stmt->bindValue(":senha", $_POST["senha"], PDO::PARAM_INT); // Com os 3 paramentros


   $stmt->execute();


   $usuario = $stmt->fetch();

   echo "<hr>";

   echo("<pre>");
   print_r($usuario);
   echo("</pre>");




/*
   // O ( exec(suaquerysql) ), mais apropriado para criar tabelas (mesmo que ja tenha uma tabela criado e for criar outro com o mesmo nome, não sera criada, mas, ja no insert irá inserir infinitas vezes)
   $query = 'create table users
            (
            id_user int primary key auto_increment not null,
            nome_user varchar(50) not null,
            email_user varchar(100) not null,
            senha_user varchar(32) not null
            )';


   $conexao->exec($query);

   
   $query = 'insert into users
            (
               nome_user, email_user, senha_user
            ) 
            values 
            (
               "KSnake", "kb.luiscarlos@live.com", "123"
            )';


   $conexao->exec($query);


   $query = "delete from users";

   $conexao->exec($query);
*/


// $query = 'select * from users'; // Fazendo teste com toda a tabela


$query = 'select * from users'; 


// O (query(suaquerysql)), retorna o PDPStatement
// $conexao->query($query);


// $stmt = $conexao->query($query);


// $lista_usuario = $stmt->fetchall(PDO::FETCH_ASSOC);


/*
echo("<pre>");
print_r($lista_usuario);
echo("</pre>");
*/




/* --- Listando registros com Foreach --- */

/*
foreach($lista_usuario as $key => $value) {

   // print_r($value);

   // recuperando apenas o nome
   // print_r($value["nome_user"]);

   echo $value["nome_user"];

   echo "<hr>";

}
*/


foreach($conexao->query($query) as $key => $value) {

   // print_r($value);

   // print_r($value[1]);

  // echo "<hr>";

}




// print_r($stmt);



/* --- Trabalhando os tipos de retorno --- */

// $stmt->fetchAll(); // fetchAll() traz todos os registro de um determinada tabela


// $lista = $stmt->fetchAll(PDO::FETCH_ASSOC); // FETCH_ASSOC de Associativo

// $lista = $stmt->fetchAll(PDO::FETCH_NUM); // FETCH_NUM de Numerico

// $lista = $stmt->fetchAll(PDO::FETCH_BOTH); // FETCH_BOTH de AMBOS

// $lista = $stmt->fetchAll(PDO::FETCH_OBJ); // FETCH_OBJ = trabalhar com Arrays de Objetos não de Arrays de Arrays


// Com a tag <pre> o retorno é associativo(que é o nome da tabela junto as informações) e numerico(que representa o nome da tabela no db junto com as informações) que é o default (padrão)
echo("<pre>");
// print_r($lista);
echo("</pre>");

// echo("<br>");

// Acesso associativo, Arrays de Arrays
// echo $lista[2]["nome_user"];

// echo("<br>");

// Acesso numerico, Arrays de Arrays
// echo $lista[2][1];

// Com acesso a Arrays de Objetos
// echo $lista[2]->nome_user;

/* --- --- --- */



/* --- Trabalhando com unico registro --- */

// $lista = $stmt->fetch(PDO::FETCH_OBJ);

/*
echo("<pre>");
print_r($lista);
echo("</pre>");
*/


} catch ( PDOException $e ) {

   /*
   echo ("<pre>");
   print_r($e);
   echo ("</pre>");
   */

   echo "Erro: " . $e->getCode() . " - Mensagem: " . $e->getMessage();

}





/*
$mysqli_connection = new MySQLi('HOST', 'USUARIO', 'SENHA', 'BASE');
if($mysqli_connection->connect_error){
   echo "Desconectado! Erro: " . $mysqli_connection->connect_error;
}else{
   echo "Conectado!";
}


$mysqli_connection = new MySQLi('localhost', 'root', '', 'php_com_pdo');

if ( $mysqli_connection->connect_error ) {

   echo "Desconectado! Erro: " . $mysqli_connection->connect_error;

} else {

   echo "Conectado!";
}
*/


?>



<!DOCTYPE html>

<html>

<head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title> Login </title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" type="text/css" media="screen" href="main.css">
   <script src="main.js"></script>

</head>

<body>



   <form action="index.php" method="post">

      <input type="text" placeholder="usuário" name="usuario" />

      <br>

      <input type="password" placeholder="senha" name="senha" />

      <br>

      <button type="submit"> Logar </button>

   </form>


   
</body>

</html>