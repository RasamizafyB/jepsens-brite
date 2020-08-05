<?php 
session_start();
include 'config/config.php';
  try
  {
  $db = new PDO('mysql:host=eu-cdbr-west-03.cleardb.net;dbname=heroku_894bd02b9729910', "b6ac8a68c1a5d3", "d263f5fb",);
  } 
  catch (Exeption $e)
  {
    die('erreur :' .$e ->getMessage());
} 


$countParticipant = $db->prepare("SELECT * FROM user_event WHERE event_id = ?");
$countParticipant->execute(array($_GET['id']));
$nbParticipant = $countParticipant->rowCount();


if (isset($_GET['id'])) {
  $idevent = $_GET['id'];
  $events = $db ->prepare('SELECT *,
                                  YEAR(date), 
                                  MONTHNAME(date), 
                                  DAY(date), 
                                  DAYNAME(date), 
                                  HOUR(time), 
                                  MINUTE(time),
                                  adresse,
                                  cp 
                                  FROM evenement
                                  WHERE id= ?');

  $events -> execute(array($idevent));
  $event = $events-> fetch();

  $category = $db-> prepare('SELECT title FROM categorie,evenement WHERE evenement.categorie_id = categorie.id && evenement.id=?');
  $category -> execute(array($_GET['id']));
  $categoryTitle = $category->fetch();

}
if(isset($_SESSION['id'])){

if(isset($_POST['dontGo'])){
    $dontGo = $db->prepare('DELETE FROM user_event WHERE event_id = ? && user_id = ?');
    $dontGo->execute(array($_GET['id'],$_SESSION['id']));
    header("location: show_event.php?id=".$event['id']);
    exit();
}
if(isset($_POST['goEvent'])){
    $go = $db->prepare('INSERT INTO user_event (event_id, user_id) VALUES (:event , :user)');
    $go->bindParam('event',$_GET['id']);
    $go->bindParam('user',$_SESSION['id']);
    $go->execute();
    header("location: show_event.php?id=".$event['id']);
    exit();
}


if(isset($_POST['sendComment'])){
  $addComment = $db->prepare("INSERT INTO commentaires (commentaire, date_commentaire, createur_id, event_id) VALUES (:text ,DATE_ADD(NOW(), interval +2 HOUR), :author, :event)");
  $addComment->bindParam('text',$_POST['userComment']);
  $addComment->bindParam('author',$_SESSION['id']);
  $addComment->bindParam('event',$idevent);
  $addComment->execute();
  header("location: show_event.php?id=".$event['id']);
  
  exit();
 }                
if ($_SESSION['id'] === $event['auteur'] ) {
  
  if (isset($_POST['edit'])) {
                  
    $newtitle = htmlspecialchars($_POST['newTitle']);    
    $editTitle = $db ->prepare('UPDATE evenement SET titre=? WHERE id=?' );
    $editTitle -> execute(array($newtitle, $idevent));

    // TODO: Modification image
    // $editnewimage = $_POST['newImage'];
    // $editImage = $db ->prepare ('UPDATE event SET image=? WHERE id=?');
    // $editImage ->execute(array($editnewimage, $idevent));
                  
    $newdate = htmlspecialchars($_POST['newDate']);
    $editdate = $db -> prepare('UPDATE evenement SET date=? WHERE id=?');
    $editdate ->execute(array($newdate, $idevent));

    $newtime=htmlspecialchars($_POST['newHour']);
    $edittime= $db ->prepare('UPDATE evenement SET time=? WHERE id=?');
    $edittime ->execute(array($newtime, $idevent));

    $newdescription=htmlspecialchars($_POST['newDescription']);
    $editdescription =$db -> prepare('UPDATE evenement SET description=? WHERE id=?');
    $editdescription ->execute(array($newdescription, $idevent));

    header("location: show_event.php?id=".$event['id']);

  }

    
  if (isset($_POST['delete'])) { 
    
    $deleteEvent = $db ->prepare("DELETE FROM evenement WHERE id = ?" );
    $deleteEvent ->execute(array($idevent));
    $deletecomments = $db->prepare("DELETE FROM commentaires WHERE event_id = ?");
    $deletecomments->execute(array($idevent));
  

    // $deletecomments = $db ->prepare ("DELETE FROM comments WHERE event_id ='$idevent'");
    // $deletecomments -> execute(array($idevent));
    
    

    

    header("location: index.php");
    exit();
             
  }
}
}

   

?>
<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Event Page</title>
      <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
      <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> -->
      <link rel="stylesheet" href="src/css/style.css">
      <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </head>

  <body>
  <?php 
    if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id']){
        include("layout/header.php");
    }else{
        include("layout/header.inc.php");
    }
?>
      <?php 
        // include 'layout/header.inc.php';
        if($event['13'] ==0){
          $minToShow = '00';
      } else {
          $minToShow = $event['13'];
      }
      
      ?>
      <main>
        <section class="article" style="margin-top:60px">
        <div class="card-header d-flex text-warning justify-content-between h1">
          <div class="imgevent">
                                  <?php
                                  if($event['image']){
                                      echo '<img src="event/image/' . $event['image'] . '" width="100" alt="event image"/>';
                                  } else {
                                      echo '<img src="https://mifato.s3.eu-west-3.amazonaws.com/no-image.png" width="100" alt="event image not found"/>';
                                  }
                                  ?>
                  
          </div>
        <h2  class="titre-h2"><?php echo $event['titre']; ?><div class="category"><?php echo $categoryTitle['title']; ?></div></h2>
        <h5  class="date"><?php echo $event['11'] . ' ' . $event['10'] . ' ' . $event['9'] . ' ' . $event['8'] . ' - '.$event['DAYNAME(date)'] . ' ' . $event['DAY(date)'] . ' ' . $event['MONTHNAME(date)'] . ' ' . $event['YEAR(date)'] . ' - ' . $event['HOUR(time)'] . ':' . $minToShow?> </h5>
        <h4 class="titre-h2" style="font-size:15px;"><?php echo $nbParticipant; ?> Participant(s) :  </h4>
        <ul style="list-style-type: none;" class="participation">
        <?php 
        $whoCome = $db->prepare('SELECT pseudo , utilisateur.id FROM utilisateur, user_event WHERE utilisateur.id = user_id && event_id = ?');
        $whoCome ->execute(array($_GET['id']));
        while($showWhoCome = $whoCome->fetch()){
            ?>
            <li><a href="<?php echo "user.php?id=".$showWhoCome['id'];?>" class="participant"><?php echo $showWhoCome['pseudo']." ,";?></a></li>
            <?php
        }
        ?>
        </ul>
                <p class="description"><strong>description:</strong><?php  echo " ".$event['description']; ?></p>
        <div class="participation">
            <form method="POST">
            <?php 
            if(isset($_SESSION['id'])){
            $verifParticipation = $db->prepare('SELECT * FROM user_event WHERE event_id = ? && user_id = ?');
            $verifParticipation->execute(array($_GET['id'],$_SESSION['id']));
            $participation = $verifParticipation->rowCount();
            
                if($participation == 1){
                    ?>
                    
                        <input type="submit" class="buttonadd participationcenter" value="Ne plus participer" name="dontGo">
                    
                    <?php
                }else{
                    ?>
                
                        <input type="submit" class="buttonadd participationcenter" value="participer à l'événement" name="goEvent">
                    
                    <?php
                }
            }
            ?><div class="map">
            <iframe  src="https://www.google.com/maps?q=<?= $event['adresse'].' '.$event['cp'] ;?>  &output=embed" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
            </form>
                
          </div>
        <?php 
                  if (isset ($_SESSION['id'])) {
                    if ($_SESSION['id'] === $event['auteur']) {
                      ?>
                      
                      <form class ="formedit " method="POST">
      
                        
                            
                            
                            
                                <div class="modal-body">
                                    <p> Edit Title :</p>
                                    <input type="text" id="exampleModalCenterTitle"  name="newTitle" value="<?php echo $event['titre'];?>">        
                                    <br>
                                <p> Edit Date & Hour:</p>
                                    <div class="modal-text d-flex justify-content-left">
                        
                                    <input class="form-control w-25" type="date"  name="newDate" value="<?php echo $event['date'];?>">
                                    <input class="form-control w-25" type="time" name="newHour" value="<?php echo $event['time'];?>">
                                    <br>
                           
                                
                                
                                    <br>
                                    <p>Edit description</p>
                                    <textarea class="description" rows="10" name="newDescription" type="text" data-emojiable="true" data-emoji-input="unicode"><?php echo  $event['description'];?></textarea>
                               
                                    <input type="submit" name="edit" value="Save Changes" class="btn btn-primary">
                                    <input type="submit" name="delete" value="Delete event" class="btn btn-primary">
                                  </div>
                                  
                                  
                                  
                                </form>
                                
                                <?php }} ?>
                                <?php include 'comments.php'; ?>
                                
                                
                                
                                
                                
                                
                                
                                <!-- Modal -->
                                
                                
                              </section>
                    </main>
                    <?php include('layout/footer.inc.php')?>
                              </body>
</html>
