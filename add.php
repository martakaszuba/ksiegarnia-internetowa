<?php
session_start();
if (isset($_POST["price"]) && isset($_POST["title"]) && isset($_POST["author"]) && isset($_POST["image"])){
  $price = $_POST["price"];
  $title = $_POST["title"];
  $author = $_POST["author"];
  $img = $_POST["image"];
  
  $conn = new mysqli("localhost", "root", "", "ksiazki");
      $conn->set_charset("utf8");
      if ($conn->connect_error){
        die ("Connection failed: " . $conn->connect_error);
      }
  
      $stmtpre = $conn->prepare("SELECT * FROM bazaksiazki WHERE tytul =?");
      $stmtpre->bind_param("s", $title);
      $stmtpre->execute();
      $result = $stmtpre->get_result();
      if ($result->num_rows === 0) {
          $stmtpre->close();
          $conn->close();
          die;
      }
      else {
        while ($row = $result->fetch_assoc()) {
          if ($row["autor"] !== $author){
            die;
          }
          else if ($row['cena'] != $price){
            die;
          }
        }
        $stmtpre->close();
          $conn->close();
      }
  
  if (!isset($_SESSION["arr"])){
    $_SESSION["arr"] = [];
    $_SESSION["arr"][] = [$img, $title, $author, $price];
  }
  
  else {
    foreach ($_SESSION["arr"] as $item){
      if ($title === $item[1]){
        die;
      }
    }
    $_SESSION["arr"][] = [$img,$title,$author, $price];
  }
  
  if (!isset($_SESSION["count"])){
    $_SESSION["count"] =0;
    $_SESSION["count"]+=$price;
  }
  
  else {
    $_SESSION["count"] +=$price;
  }
}


?>
