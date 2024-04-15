<?php
  if(!isset($_SESSION)){
    session_start();
  }else{
    if(!isset($_SESSION['username'])){
      header('location:../index.php');
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="..\Assets\CSS\Login-SignStyle.css">
  <script src="..\Assets\JS\main.js"></script>
  <title>DashBoard</title>
</head>
<body>
  <div class="nav">
    <div class="logo">
      <p>Logo</p>
    </div>

    <div class="right-links">
      <a href="DashBoard.php">Home</a>
      <a href="#">About</a>
      <a href="#">Contact</a>
      <a href="#">Services</a>
      <a href="../Php/Logout.php"><button class="btn">Log Out</button></a>

    </div>
  </div>
  <main>
    <div class="container-home">
      <div class="top-home">
      <div class="box">
          <h1>Seja Bem Vindo ao seu Dashboard</h1>
          <p>Seja bem-vindo ao seu centro de comando financeiro! Este é o lugar onde você terá uma visão abrangente e em tempo real da sua saúde financeira.</p>
        </div>
      </div>
      <div class="bottom-home">
        <div class="box">
            <h3>Faturamento</h3>
            <div class="table-delimiter">
              <table class="content-table">
                <thead>
                  <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Data</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <button class="btn">Adicionar Faturamento</button>
        </div>
        <div class="box">
            
            </script>
            <h3>Despesas</h3>
            <div class="table-delimiter">
              <table class="content-table">
                <thead>
                  <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Categoria</th>
                    <th>Data</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    include '../Php/Config.php';
                    $userId = $_SESSION['id'];
                    $sql = "SELECT * FROM expenses join categories on expenses.categorieId = categories.categorieId WHERE userId = '$userId'";
                    $result = mysqli_query($con, $sql);
                    if(mysqli_num_rows($result) > 0){
                      while($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td>".$row['description']."</td>";
                        echo "<td>R$ ".number_format($row['value'], 2, ',', '.')."</td>";
                        echo "<td>".$row['categorie']."</td>";
                        $date = date_create($row['date']);
                        echo "<td>".date_format($date, 'd/m/Y')."</td>";
                        echo "</tr>";
                      }
                    }
                  ?>
                </tbody>
              </table>
            </div>
            <button class="btn" id="show-cadaster">Adicionar Despesas</button>
            <?php
              include '../Php/Config.php';
              if(isset($_POST['submit'])){
                $descricao = $_POST['descricao'];
                $valor = str_replace(',', '.', $_POST['valor']);
                $data = $_POST['data'];
                $categoria = $_POST['categoria'];
                $userId = $_SESSION['id'];

                $sql = "INSERT INTO expenses (date, description, expenseId, userId, value, categorieId) 
                VALUES ('$data', '$descricao','', '$userId', '$valor', '$categoria')";
                $result = mysqli_query($con, $sql);
                if(!$result){
                  echo "<script>alert('Falha ao cadastrar despesa!')</script>";
                }else {
                  // Redireciona para a mesma página (ou outra página) para evitar duplicação de envios
                  header("Location: DashBoard.php");
                  exit();
              }
              }
            ?>
            <div class="second-form" id="cadaster">
              <form action="" method="POST">
                <label for="descricao">Descrição</label>
                <input type="text" name="descricao" placeholder="Descrição">
                <label for="valor">Valor</label>
                <input type="text" name="valor" placeholder="00,00$">
                <label for="data">Data</label>
                <input type="date" name="data" placeholder="Data">
                <label for="categoria">Categoria</label>
                <select name="categoria" id="categoria">
                  <option value="">Selecione uma categoria</option>
                  <?php
                    $sql = "SELECT * FROM categories";
                    $result = mysqli_query($con, $sql);
                    if(mysqli_num_rows($result) > 0){
                      while($row = mysqli_fetch_assoc($result)){
                        echo "<option value='".$row['categorieId']."'>".$row['categorie']."</option>";
                      }
                    }
                  ?>
                <input type="submit" class="btn" name="submit" value="Cadastrar">
              </form>
            </div>
        </div>
      </div>
    </div>
  </main>  
</body>
</html>