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
        <p class="pub">Wydawnictwo &nbsp;Znak</p>
<?php
        $conn = new mysqli("localhost", "root", "", "ksiazki");
		$conn->set_charset("utf8");
		if ($conn->connect_error) {
			die ("Connection failed: " . $conn->connect_error);
		}

    $res="znak";
    $stmtpre = $conn->prepare("SELECT * FROM bazaksiazki WHERE wydawca =?");
    $stmtpre->bind_param("s", $res);
    $stmtpre->execute();
    $result = $stmtpre->get_result();
    if ($result->num_rows === 0) {
        echo 'Nie ma takiego wyniku!';
        $stmtpre->close();
        $conn->close();
        die;
    }
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $title = $row['tytul'];
        $author = $row['autor'];
        $price = $row['cena'];
        $year = $row['rok'];
        strlen($price) ===4?$price = $price."0":$price;
        echo '<div class="p-3 mb-2 bg-light product">';
        echo '<h4 class="title">'.$title.'</h4>';
        echo '<p class="author">Autor: '.$author.'</p>';
        echo '<p>Rok wydania: <span class="year">'.$year.'</span></p>';
        echo '<img src="images/img'.$id.'.jpg">';
        echo '<p>Cena: <span class="price">'.$price.' zł</span></p>';
        echo '<input type="submit" class="cart" value="Do koszyka">';
        echo '</div>';
      }
      $stmtpre->close();
      $conn->close();
?>

      </div>
      <div class="footer">
      © 2019 Księgarnia Alito
    </div>
<script>
  document.addEventListener("DOMContentLoaded", Load);
    function Load(){
        var buttons = document.querySelectorAll(".cart");
        buttons.forEach(function(val){
            val.addEventListener("click", Add);
        })
    }
    function Add(e){
        var num = Number(e.target.parentNode.querySelector(".price").innerHTML.slice(0,-2));
        var title = e.target.parentNode.querySelector(".title").innerHTML;
        var author = e.target.parentNode.querySelector(".author").innerHTML;
        author = author.replace("Autor: ","");
        var img = e.target.parentNode.querySelector("img").getAttribute("src");
          $.ajax({
            method:"post",
            url:"add.php",
            data:{
                price:num,
                title:title,
                author:author,
                image:img
            }
        })
        .done(function(val){
            console.log(val);
            location.reload();
        })
      
    }
</script>
</body>
</html>