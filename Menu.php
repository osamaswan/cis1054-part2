<?php

    require_once __DIR__.'/database.php';
    $db = new Db();    

    $foods = $db -> select("SELECT food.id, food.image, food.name, food.desc FROM food order by name");
    echo $twig->render('menu.html','foods' => $foods)
?>
