<?php
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Księgarnia internetowa Marta Kaszuba</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:900" rel="stylesheet"> 
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel ="stylesheet" href="style.css">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
</head>

<body>
        <div id="header">
                <h2>Księgarnia Alito</h2>
            </div>
    <nav class="navbar navbar-expand-sm bg-light navbar-light">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Prószyński i S-ka</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="znak.php">Znak</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="swiat-ksiazki.php">Świat książki</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="rebis.php">Rebis</a>
          </li>
          <li class="nav-item">
                <a class="nav-link" href="zysk.php">Zysk i S-ka</a>
              </li>
        </ul>
        <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                        <a class="nav-link" id ="basket" href="koszyk.php">Koszyk: 
                          <?php !isset($_SESSION["count"])?$count =0:$count=$_SESSION["count"];
                        strpos($count,".") !== false? $count =$count."0":$count;
                        echo $count;
                        ?> zł</a>
                      </li>
                      </ul>
    </form>
      </nav>
      <div id="content">
        <?php
if (isset($_SESSION["confirm"])){
  echo '<p class="pub">Zamówienie zostało złożone!</p>';
  $_SESSION["confirm"] = null;
}

else if (!isset($_SESSION["arr"])){
  echo '<p class="pub">Koszyk pusty!</p>';
}
else {
  echo "<table>";
  echo "<tr class='dark'>";
  echo "<td>L.p</td>";
  echo "<td></td>";
  echo "<td>Tytuł</td>";
  echo "<td>Autor</td>";
  echo "<td>Sztuk</td>";
  echo "<td>Cena</td>";
  echo "</tr>";
  $count = 1;
  $sum = 0;
  foreach ($_SESSION["arr"] as $item){
  echo "<tr>";
  echo "<td>".$count."</td>";
  echo "<td><img class='sm' src='".$item[0]."'></td>";
  echo "<td>".$item[1]."</td>";
  echo "<td>".$item[2]."</td>";
  echo "<td>1</td>";
  $price =$item[3];
  $sum +=$price;
  strpos($price,".") !== false? $price =$price."0":$price;
  echo "<td>".$price." zł</td>";
  echo "</tr>";
  $count++;
  }
  echo "<tr>";
  echo "<td>Razem:</td>";
  strpos($sum,".") !== false? $sum =$sum."0":$sum;
  echo "<td>".$sum." zł</td>";
  echo "</tr>";
  echo "</table>";
  echo "<form method='post' class='justify'>";
  echo '<button class="btn btn-info infbask" name="confirm">Złóż zamówienie</button>';
  echo '<button class="btn btn-info infbask" name="empty">Opróżnij koszyk</button>';
  echo "</form>";
}

if (isset($_POST["confirm"])){
  $_SESSION["count"] = 0;
  $_SESSION["arr"] = null;
  $_SESSION["confirm"] = true;
  header("Refresh:0");
}

else if (isset($_POST["empty"])){
  $_SESSION["count"] = 0;
  $_SESSION["arr"] = null;
  header("Refresh:0");

}
        ?>
        </div>

      <div class="footer">
      © 2019 Księgarnia Alito
    </div>
<script>
</script>
</body>
</html>