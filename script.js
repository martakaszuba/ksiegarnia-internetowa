
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
        .done(function(){
            location.reload();
        })
      
    }