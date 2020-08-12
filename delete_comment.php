<?php
session_start();
$db = new PDO('mysql:host=eu-cdbr-west-03.cleardb.net;dbname=heroku_894bd02b9729910', "b6ac8a68c1a5d3", "d263f5fb",);
if(isset($_GET['id'])){
    if($_GET['idauthor'] === $_SESSION['id'] OR $_SESSION['admin']==1){
        $deleteCom = $db->prepare("DELETE FROM commentaires WHERE id = ?");
        $deleteCom->execute(array($_GET['id']));
        echo "<h1> COMMENT DELETED </h1>";
        header("location: show_event.php?id=".$_GET['eventid']);
    }else{
        echo "<h1> ACCES DENIED </h1>";
    }
}else{
    echo "<h1> ACCES DENIED </h1>";
}
?>