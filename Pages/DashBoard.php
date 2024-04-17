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
      <div class="dashboard">
        <div class="box" id="card1">
          <?php
            include '../Php/Config.php';

            $userId = $_SESSION['id'];
            $currentMonth = date('m');
            $currentYear = date('Y');
            
            $sql = "SELECT 
                        (SELECT SUM(value) FROM earnings WHERE userId = ? AND MONTH(date) = ? AND YEAR(date) = ?) as totalEarnings,
                        (SELECT SUM(value) FROM expenses WHERE userId = ? AND MONTH(date) = ? AND YEAR(date) = ?) as totalExpenses";
            
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'isiisi', $userId, $currentMonth, $currentYear, $userId, $currentMonth, $currentYear);
            mysqli_stmt_execute($stmt);
            
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            
            $totalEarnings = $row['totalEarnings'];
            $totalExpenses = $row['totalExpenses'];
            $total = $totalEarnings - $totalExpenses;
            
            echo "<h3>Saldo do mês</h3>";
            if ($total < 0) {
                echo "<h1>R$ ".number_format($total, 2, ',', '.')." <span style='color:red;'>&#x2193;</span></h1>"; // Downwards arrow
            } else {
                echo "<h1>R$ ".number_format($total, 2, ',', '.')." <span style='color:green;'>&#x2191;</span></h1>"; // Upwards arrow
            }
          ?>
        </div>
        <div class="box">
          <?php
            include '../Php/Config.php';
            $userId = $_SESSION['id'];
            $currentMonth = date('m');
            $currentYear = date('Y');
            $sql = "SELECT categories.categorie, SUM(expenses.value) as total FROM expenses join categories on expenses.categorieId = categories.categorieId WHERE userId = ? AND MONTH(date) = ? AND YEAR(date) = ? GROUP BY categories.categorie ORDER BY total DESC LIMIT 1";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, 'isi', $userId, $currentMonth, $currentYear);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            echo "<h3>Categoria com mais gastos</h3>";
            echo "<h1>".$row['categorie']."</h1>";
            echo "<p>R$ ".number_format($row['total'], 2, ',', '.')."</p>";
            ?>
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
                  <?php
                   include '../Php/Config.php';
                   $userId = $_SESSION['id'];    
                   $currentMonth = date('m');
                   $currentYear = date('Y');
                   $sql = "SELECT * FROM earnings WHERE userId = '$userId' AND MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'";
                   $result = mysqli_query($con, $sql);
                   if(mysqli_num_rows($result) > 0){
                       while($row = mysqli_fetch_assoc($result)){
                           echo "<tr>";
                           echo "<td>".$row['description']."</td>";
                           echo "<td>R$ ".number_format($row['value'], 2, ',', '.')."</td>";
                           $date = date_create($row['date']);
                           echo "<td>".date_format($date, 'd/m/Y')."</td>";
                           echo "</tr>";
                       }
                   }
                  ?>
                </tbody>
              </table>
            </div>
            <button class="btn" id="show-cadaster2">Adicionar Ganhos</button>
        </div>
        <div class="box">
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
                    $currentMonth = date('m');
                    $currentYear = date('Y');
                    $sql = "SELECT * FROM expenses join categories on expenses.categorieId = categories.categorieId WHERE userId = '$userId' AND MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'";
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
            <button class="btn" id="show-cadaster1">Adicionar Despesas</button>
        </div>
      </div>
        <div class="second-form" id="cadaster1">
          <div class="box">
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
            <div class="cadaster">
              <h3>Realize o cadastro da despesa</h3>
              <form action="" method="POST">
                <label for="descricao">Descrição</label>
                <input type="text" name="descricao">
                <label for="valor">Valor</label>
                <input type="text" name="valor" step="0.01" min="0">
                <label for="data">Data</label>
                <input type="date" name="data">
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
        <div class="second-form" id="cadaster2">
          <div class="box">
            <?php
              include '../Php/Config.php';
              if(isset($_POST['submit2'])){
                $valor = $_POST['valor'];
                $data = $_POST['data'];
                $descricao = $_POST['descricao'];
                $userId = $_SESSION['id'];

                $sql = "INSERT INTO earnings (userId, value, date, description) VALUES (?, ?, ?, ?)";

                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, 'idss', $userId, $valor, $data, $descricao);
                $executeResult = mysqli_stmt_execute($stmt);
                if(!$executeResult){
                  echo "<script>alert('Falha ao cadastrar ganho!')</script>";
                }else {
                  // Redireciona para a mesma página (ou outra página) para evitar duplicação de envios
                  header("Location: DashBoard.php");
                  exit();
                }
              }
            ?>
            <div class="cadaster">
              <h3>Realize o cadastro do ganho</h3>
              <form action="" method="POST">
                <label for="descricao">Descrição</label>
                <input type="text" id="descricao" name="descricao">
                <label for="valor">Valor</label>
                <input type="number" id="valor" name="valor" step="0.01" min="0">
                <label for="data">Data</label>
                <input type="date" id="data" name="data">
                <input type="submit" class="btn" name="submit2" value="Cadastrar">
              </form>
            </div>
          </div>
        </div>
    </div>
  </main>  
</body>
</html>