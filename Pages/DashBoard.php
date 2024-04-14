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
          <p>Eu sou a solução definitiva para simplificar a gestão do seu dinheiro. Deixe-me guiar você por uma jornada de controle financeiro descomplicado e eficiente.</p>
        </div>
      </div>
      <div class="bottom-home">
        <div class="box">
            <h3>Faturamento</h3>
            <button class="btn">Adicionar Faturamento</button>
        </div>
        <div class="box">
            <h3>Despesas</h3>
            <table class="content-table">
              <thead>
                <tr>
                  <th>Descrição</th>
                  <th>Valor</th>
                  <th>Data</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Aluguel</td>
                  <td>R$ 1000,00</td>
                  <td>10/10/2020</td>
                </tr>
                <tr>
                  <td>Felps</td>
                  <td>R$ 1000,00</td>
                  <td>10/10/2020</td>
                </tr>
                <tr>
                  <td>Aluguel</td>
                  <td>R$ 1000,00</td>
                  <td>10/10/2020</td>
                
              </tbody>
            </table>
            <button class="btn">Adicionar Despesas</button>
        </div>
      </div>
    </div>
  </main>  
</body>
</html>