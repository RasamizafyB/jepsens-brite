<?php 
session_start();
$bdd = new PDO('mysql:host=eu-cdbr-west-03.cleardb.net;dbname=heroku_894bd02b9729910;charset=utf8mb4', "b6ac8a68c1a5d3", "d263f5fb",);
$showCat = $bdd->query("SELECT id,title FROM categorie");
$showSousCat = $bdd->prepare("SELECT id, sub_titre FROM subcat WHERE cat_id = ?");


if(isset($_POST)){
    var_dump($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form method="POST">
    <div class="title_input" style="width:400px;">
        <p style="margin-top:20px;">Category</p>
            <?php
                $reqcategory = $bdd->query("SELECT * FROM categorie ORDER BY title");
                while($categoryMenu = $reqcategory->fetch()){
                        echo'<input type="checkbox" name="'.$categoryMenu['title'].'" value="'.
                        $categoryMenu['id'].
                        '" label="'.$categoryMenu['title'].
                        '" style="margin-top:20px; " ><strong>'.
                        $categoryMenu['title'].
                        '</strong></input><hr>';
                            $reqsubcat= $bdd->prepare("SELECT * FROM subcat WHERE cat_id=? ORDER BY sub_titre ");
                            $reqsubcat->execute(array($categoryMenu['id']));
                            while($subcatMenu = $reqsubcat->fetch()){
                                if($subcatMenu['cat_id']==$categoryMenu['id']){
                                    echo'<input type="checkbox" name="'.$subcatMenu['sub_titre'].'" value="'.
                                    $subcatMenu['id'].
                                    '">'.$subcatMenu['sub_titre'].
                                    '</input>';
                                };
                            };
                echo'<br>';
            };?>
            </div>
            <input type="submit" name="send" value="envoi">
    </form>
</body>
</html>