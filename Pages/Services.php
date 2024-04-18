<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Verifica se o usuário está logado
    if (!isset($_SESSION['id'])) {
        // Redireciona para a página de login
        header("Location: ../index.php");
        exit();
    }
    include '../Php/Config.php';
    function processCsvFile($file, $con) {
        $csvFile = fopen($file['tmp_name'], 'r');
        fgetcsv($csvFile);
        while (($line = fgetcsv($csvFile)) !== FALSE) {
            $descricao = $line[0];
            $valor = str_replace(',', '.', $line[1]);
            $data = $line[2];
            $date = DateTime::createFromFormat('d/m/Y', $data);
            $mysqlFormattedDate = $date->format('Y-m-d');
            $categoria = $line[3];
            $userId = $_SESSION['id'];
            $expenseId = '';

            $stmt = $con->prepare("INSERT INTO expenses (date, description, expenseId, userId, value, categorieId) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $mysqlFormattedDate, $descricao, $expenseId, $userId, $valor, $categoria);
            if (!$stmt->execute()) {
                error_log("Failed to execute query: " . $stmt->error);
                return false;
            }
        }
        fclose($csvFile);
        return true;
    }

    function downloadTemplate() {
        $headers = ['descricao', 'valor', 'data', 'categoria'];
        $csvFile = fopen('template.csv', 'w');
        fputcsv($csvFile, $headers);
        fclose($csvFile);
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=template.csv;');
        readfile('template.csv');
        exit();
    }

    if (isset($_FILES['file'])) {
        if (!processCsvFile($_FILES['file'], $con)) {
            echo "<script>alert('Falha ao cadastrar despesa!')</script>";
        } else {
            header("Location: DashBoard.php");
            exit();
        }
    }

    if (isset($_GET['download_template'])) {
        downloadTemplate();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="..\Assets\CSS\Login-SignStyle.css">
  <title>Service Page</title>
</head>
<body>
  <div class="container">
    <div class="box form-box" id="form-box">
      <div class="field">
        <img src="your_image_path" alt="Image Description" style="width:50%; float:left;">     
        <form action="" method="post" enctype="multipart/form-data" style="width:50%; float:right;">
          <label for="file">Upload File:</label><a href="?download_template">Download CSV Template</a>
          <input type="file" name="file" id="file" accept=".csv" required>
          <input type="submit" class="btn" name="submit" value="Upload">
        </form>
      </div>
    </div>
  </div>
</body>
</html>