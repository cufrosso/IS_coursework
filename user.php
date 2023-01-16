<?php
session_start();
if (!isset($_SESSION['nick'])){
    header("location: registration.php");
}
$nick = $_SESSION['nick'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Postamats</title>
    <meta name="viewport" content="width=device-widht, inital-scale=1"> <!-- для норм отображения на устройствах -->
    <!-- подключение bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="container">
        <form action="config/exit.php">
            <h5 style="margin-left:-65px; margin-top:30px">
                <button type="submit" class="btn btn-outline-danger" style="margin-right:5px;">Выход</button>
                <?php echo $nick; ?>
            </h5>
        </form>
    </div>

    <br><h2>Package near</h2>
    <div class="container">

      <div class="input-group mb-3">
          <input type="text" name="pack_id" id="pack_id" class="form-control" placeholder="input number of package">
          <button type="button" name="find" id="find" class="btn btn-outline-dark">Find</button>
      </div>
      <div id="find_error"></div>

      <div class="row">
          <div class="col"><br>
            <div id="map_t" class="map"> </div>
            <script src="js/jquery-3.6.1.min.js"></script>
            <script src="https://api-maps.yandex.ru/2.1/?apikey=9cfcf69f-e761-41ae-b528-c5fb5084054d&lang=ru_RU type="text/javascript""></script>
            <script>
            let map;
            let point;
            let collection;
            </script>
            <script src="js/maps.js"></script>
          </div>

      </div>
    </div>

    <script>
    let point_find = '';
    $("#find").on("click", function(){
        let pack_id=$("#pack_id").val().trim();

        if(pack_id== ""){
            $("#find_error").text("Введите номер 🥰");
            return false;
        }
        $("#find_error").text("");

        $.ajax({
            url: "config/mapdb.php",
            type: "POST",
            cache: false,
            async: false,
            data: {"query": ["get_pack"]},
            dataType: "json",
            success: function(data){
                packs = data;
            }
        });
        $.ajax({
            url: "config/mapdb.php",
            type: "POST",
            cache: false,
            async: false,
            data: {"query": ["get_post"]},
            dataType: "json",
            success: function(data){
                points = data;
            }
        });
        for (let i = 0; i < packs.length; i++){
          if (pack_id == packs[i][1]){
            point_find = packs[i][3];
            map.setCenter([points[point_find][1],points[point_find][2]],16,{});
            collection[point_find].baloon.open();
          }
        }
        if (point_find == ''){
            $("#find").prop("disabled", false);
            $("#find_error").text("Нет посылки с таким номером");
        }
    });
  </script>-->
</body>
</html>
