<?PHP
session_start();
if(!$_SESSION['usuario']) {
    echo $_SESSION['usuario'];
    // This is in the PHP file and sends a Javascript alert to the client
    $message = "Para Excecutar essa Pagina, Executar o LOGIN no Sistema.";
    echo "<script type='text/javascript'>alert('$message');</script>";   
    
    echo "Para execucao, Efetuar LOGIN";

    
	header('Location: ../index.php');
	exit();
}
if (isset($_GET['msgexec'])) {
    $msgultexec = $_GET['msgexec'];
} else {
    $msgultexec = '';    
}
    
?>

<?php
    
include_once("../conexao.php");

$sql = "SELECT
        a.cfgId,
        b.nomelocador,
        SUBSTRING(b.nomelocador, 1, 15) as nomelocador,  
        a.cfgIdlocador,
        a.cfgmesref,
        a.cfganoref,
        a.cfgObservacao
        FROM configsis as a
        left join locador b on a.cfgIdlocador = b.idlocador
        WHERE a.cfgId='1'";
$result_qry_config = $link->query($sql) or die($link->error);
$registro_qry_config = $result_qry_config->fetch_object();



$sql = "SELECT 
idlocatario,
SUBSTRING(nomelocatario, 1, 7) as nomelocatario, 
(select count(*) from avalista where idlocatario = locatario.idlocatario) as qtdreg_aval,
SUBSTRING(telefonelocatario, 1, 15) as telefonelocatario,
cpflocatario,
dataNascimentolocatario,
enderecolocatario,
observacaolocatario 

FROM locatario order by nomelocatario";

$result_tabela = $link->query($sql);


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Up imoveis</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Rajdhani:wght@600&family=Raleway:ital,wght@1,100;1,200;1,300&family=Roboto:ital,wght@0,300;0,400;0,500;1,500&family=Ubuntu:wght@400;500;700&display=swap');

    body {

        background-color: rgb(201, 76, 76);
 
    }
  
    h1 {
      color: #1C1C1C;
      margin-top: 350px;
      margin-left: 650px;
    }

    .table-bg {
      /*background: rgb(0, 0, 0, 0.5);*/
      background: #3E3D3D;  
      color: #fff;
      border-radius: 15px;
    }
    
  </style>
</head>

<body>

<?php
  include("m_locatario_nav.php");
    
       print "<p style='color: white; background-color: blue'>
         [LOCATARIO-Cadastro]: ". $registro_qry_config->cfganoref." ---- ".$msgultexec."</p>";     
    
    
?>  


  <div class="container">

    <div class="card">
      <div class="card-header">
        <div class="card-header">
          <h3>Locatario - Cadastro</h3>
            
         <p style='color: white; background-color: blue'>Cadastro, Edição e Remoção de Registros.</p> 
    
            
            
        </div>      
      
      
    <table class="table text white table-bg">
      <thead class="thead-light">
        <tr>

          <th scope="col">...</th> 
          <th scope="col">Nome</th>
          <th scope="col">ID</th>

 
          <th scope="col">Telefone</th>

        </tr>
      </thead>
      <tbody>
        <?php
        while ($user_data = mysqli_fetch_assoc($result_tabela)) {
          echo "<tr>";
          echo "<td>
               <button class='btn btn-sm btn-warning' onclick=\"location.href='m_locatario_editar.php?idlocatario=$user_data[idlocatario]';\">Consultar</button>
               <?td>";
          echo "<td>" . $user_data['nomelocatario'] . "<?td>";
          echo "<td>" . $user_data['idlocatario'] . "<?td>";
  
          echo "<td>" . $user_data['telefonelocatario'] . "<?td>";

          echo "</tr>";
        }
        ?>
      </tbody>
    </table>

    </div>
    </div>        
          

  </div>


</body>

</html>