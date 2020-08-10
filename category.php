<?php
session_start();
// VARIABLE POUR MESSAGE D ERREUR
$error = null;
$good = null;


$db = new PDO('mysql:host=eu-cdbr-west-03.cleardb.net;dbname=heroku_894bd02b9729910;charset=utf8mb4', "b6ac8a68c1a5d3", "d263f5fb",);

function eventListCreator($db, $cat){

$eventRequest = $db->query("SELECT  evenement.*, categorie.*,utilisateur.id,utilisateur.pseudo,
                                            YEAR(date), 
                                            MONTHNAME(date), 
                                            DAY(date), 
                                            DAYNAME(date), 
                                            HOUR(time),
                                            MINUTE(time)
                                            FROM 
                                            evenement, 
                                            categorie,
                                            utilisateur
                                            WHERE 
                                            evenement.categorie_id = categorie.id
                                            &&
                                            evenement.auteur = utilisateur.id
                                            && 
                                            evenement.date > curdate()
                                            ORDER BY date ASC
");

// $Parsedown = new Parsedown();
// $Parsedown->setSafeMode(true);
$eventResult = $eventRequest->execute();
echo '<div class="container row text-center justify-content-around">';

while($listEvent = $eventRequest->fetch()){

    $subcat = $db->prepare('SELECT sub_titre FROM subcat,subcat_event,evenement WHERE event_id = evenement.id && subcat_id = subcat.id && subcat_event.event_id = ? ');
    $subcat->execute(array($listEvent['0']));
        

        // var_dump($listEvent);
        if($listEvent['MINUTE(time)'] ==0){
            $minToShow = '00';
        } else if($listEvent['MINUTE(time)'] < 10) {
            $minToShow = '0'.$listEvent['MINUTE(time)'];
        }else{
            $minToShow = $listEvent['MINUTE(time)'];
        }

    if($cat == 'all'){
        echo '<div>';
        echo '<div id="image" style="height: 100px;" class="mb-3">';
        echo '<figure class="mt-5">';
        if($listEvent['image']){
            echo '<img src="event/image/' . $listEvent['image'] . '" class="card-img-top rounded" style="width: 75%; height: auto"/>';
        }else{
            echo '<iframe class="imgevent" src="https://www.youtube.com/embed/'.$listEvent["video"].' " frameborder="0" 
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        }
            echo '</figure></div>';
            echo '<div>';
            echo '<h2><a  href="show_event.php?id='. $listEvent['0'] . '">' . $listEvent['1'] . '</a></h2>';
            echo '<h4>'.$listEvent['adresse']." ".$listEvent['cp']." ".$listEvent['ville'].'</h4>';
            echo '<p><small class"text-muted>' . $listEvent['DAYNAME(date)'] . ' '. $listEvent['DAY(date)'] . ' ' . $listEvent['MONTHNAME(date)'] . ' ' . $listEvent['YEAR(date)'] . '  -  ' . $listEvent['HOUR(time)'] . ':' . $minToShow . '</small></p>';
            echo '<h3>Créateur : <a  href="user.php?id='. $listEvent['auteur'] . '">' . $listEvent['pseudo'] . '</a></h3>';
            echo '<h4>' . $listEvent['title'] . '</h4>';
            while($showSub = $subcat->fetch()){
            
                echo '<p>'.$showSub['sub_titre'].'</p>';
            
        }
            echo '<p class="card-text overflow-hidden text-light line-coverage clamptext" style="height: 200px;">' . $listEvent['description'] .'</p>';
            echo '</div>';
        echo '</div>';

    } elseif ($cat == $listEvent['categorie_id']){

        echo '<div';
        echo '<div>';
        echo '<figure class="mt-5">';
        if($listEvent['image']){
            echo '<img src="event/image/' . $listEvent['image'] .'/>';
        }else{
            echo '<iframe class="imgevent" src="https://www.youtube.com/embed/'.$listEvent["video"].' " frameborder="0" 
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        }
        echo '</figure></div>';
        echo '<div>';
        echo '<h2><a  href="show_event.php?id='. $listEvent['0'] . '">' . $listEvent['1'] . '</a></h2>';
        
        echo '<h4>'.$listEvent['adresse']." ".$listEvent['cp']." ".$listEvent['ville'].'</h4>';
        echo '<p>' . $listEvent['DAYNAME(date)'] . ' '. $listEvent['DAY(date)'] . ' ' . $listEvent['MONTHNAME(date)'] . ' ' . $listEvent['YEAR(date)'] . '  -  ' . $listEvent['HOUR(time)'] . ':' . $minToShow . '</small></p>';
        echo '<h3>Créateur : <a  href="user.php?id='. $listEvent['auteur'] . '">' . $listEvent['pseudo'] . '</a></h3>';
        echo '<h4>' . $listEvent['title'] . '</h4>';
        while($showSub = $subcat->fetch()){
            
            echo '<p>'.$showSub['sub_titre'].'</p>';
            
        }
        echo '<p>' . $listEvent['description'] .'</p>';
        echo '</div>';
    echo '</div>';
    }

}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content ="Display all event's coming for the Jepsen BeCode Promo and allow to create your own !">
    <title>Jepsen Brite</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>
<body>

    
    <div class="container">
    <form method ='get' action='#' name="eventlist">
    <label for="category">Please select a category :</label>


            <select class="custom-select" name="category" id="category" onchange="eventlist.submit();">
            <option> --> Pick a category here <-- </option>
            <option value="all" name="all" id="all">All</option>
            <?php
                $listRequest = $db->query("SELECT * FROM categorie ORDER BY title ASC");
                
                $listMenu = $listRequest;

                while($listMenu = $listRequest->fetch()){

                    echo '<option value ="' . $listMenu['id'] . '" name ="' . $listMenu['title'] . '" id ="' . $listMenu['title'] . '">' . $listMenu['title'] . '</p>';
                }
                
            ?> 
            </select>
    </form>
    <br/>

    <div class="container-fluid row text-center justify-content-between ml-n1">
        <?php

            if(isset($_GET['category'])){
                $cat=$_GET['category'];
                eventListCreator($db,$cat);
            
            } else {
                eventListCreator($db,"all");
            }
?>
        </div>
        </div>
</body>
</html>