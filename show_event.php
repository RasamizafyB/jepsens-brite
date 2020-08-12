<?php
session_start();
$today = date('Y-m-d');
include 'config/config.php';
  try {
      $db = new PDO($dbdsn, $dbusername, $dbpassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  } catch (Exeption $e) {
      die('erreur :' .$e ->getMessage());
  }

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';


$countParticipant = $db->prepare("SELECT * FROM user_event WHERE event_id = ?");
$countParticipant->execute(array($_GET['id']));
$nbParticipant = $countParticipant->rowCount();


if (isset($_GET['id'])) {
    $idevent = $_GET['id'];
    $events = $db ->prepare('SELECT *,utilisateur.pseudo,
                                    YEAR(date), 
                                    MONTHNAME(date), 
                                    DAY(date), 
                                    DAYNAME(date), 
                                    HOUR(time), 
                                    MINUTE(time),
                                    adresse,
                                    cp,
                                    ville
                                    FROM evenement,
                                         utilisateur
                                    WHERE evenement.auteur = utilisateur.id
                                    &&
                                    evenement.id= ?');

    $events -> execute(array($idevent));
    $event = $events-> fetch();

    $category = $db-> prepare('SELECT title FROM categorie,evenement WHERE evenement.categorie_id = categorie.id && evenement.id=?');
    $category -> execute(array($_GET['id']));
    $categoryTitle = $category->fetch();

    $subcat = $db->prepare('SELECT sub_titre FROM subcat,subcat_event,evenement WHERE event_id = evenement.id && subcat_id = subcat.id && subcat_event.event_id = ? ');
    $subcat->execute(array($_GET['id']));
}
if (isset($_SESSION['id'])) {
    if (isset($_POST['dontGo'])) {
        $dontGo = $db->prepare('DELETE FROM user_event WHERE event_id = ? && user_id = ?');
        $dontGo->execute(array($_GET['id'],$_SESSION['id']));
        header("location: show_event.php?id=".$event['0']);
        exit();
    }
    if (isset($_POST['goEvent'])) {
        $go = $db->prepare('INSERT INTO user_event (event_id, user_id) VALUES (:event , :user)');
        $go->bindParam('event', $_GET['id']);
        $go->bindParam('user', $_SESSION['id']);
        $go->execute();
        header("location: show_event.php?id=".$event['0']);
        exit();
    }


    if (isset($_POST['sendComment'])) {
        $addComment = $db->prepare("INSERT INTO commentaires (commentaire, date_commentaire, createur_id, event_id) VALUES (:text ,DATE_ADD(NOW(), interval +2 HOUR), :author, :event)");
        $addComment->bindParam('text', $_POST['userComment']);
        $addComment->bindParam('author', $_SESSION['id']);
        $addComment->bindParam('event', $idevent);
        $addComment->execute();
        header("location: show_event.php?id=".$event['0']);

        exit();
    }
    if ($_SESSION['id'] === $event['auteur']) {
        if (isset($_POST['edit'])) {
            $newtitle = htmlspecialchars($_POST['newTitle']);
            $editTitle = $db ->prepare('UPDATE evenement SET titre=? WHERE id=?');
            $editTitle -> execute(array($newtitle, $idevent));

            $newdate = htmlspecialchars($_POST['newDate']);
            $editdate = $db -> prepare('UPDATE evenement SET date=? WHERE id=?');
            $editdate ->execute(array($newdate, $idevent));

            $newtime=htmlspecialchars($_POST['newHour']);
            $edittime= $db ->prepare('UPDATE evenement SET time=? WHERE id=?');
            $edittime ->execute(array($newtime, $idevent));

            $newdescription=htmlspecialchars($_POST['newDescription']);
            $editdescription =$db -> prepare('UPDATE evenement SET description=? WHERE id=?');
            $editdescription ->execute(array($newdescription, $idevent));

    
            if (isset($_FILES['newImage']) and !empty($_FILES['newImage']['name'])) {
                $tailleMaxImage = 2097152;
                $extensoinValideImage = array('jpg', 'jpeg', 'png', 'gif');
                if ($_FILES['newImage']['size'] <= $tailleMaxImage) {
                    $extensionUploadImage = strtolower(substr(strrchr($_FILES['newImage']['name'], '.'), 1));
                    if (in_array($extensionUploadImage, $extensoinValideImage)) {
                        $cheminImage = "event/image/new".$newtitle.".".$extensionUploadImage;
                        $resultatImage = move_uploaded_file($_FILES['newImage']['tmp_name'], $cheminImage);
                        $newImage = "new".$newtitle.".".$extensionUploadImage;
                    } else {
                        $error = 'The image format must be in JPG, JPEG, PNG or GIF';
                    }
                } else {
                    $error = 'Your image is so big';
                }
            }

            $newVideo = substr(htmlspecialchars($_POST['newVideo']), 32) ;
            $setvideo = "";
            $setimage = "";
 
            if (isset($_FILES['newImage']) and !empty($_FILES['newImage']['name']) and isset($_POST['newVideo']) and !empty($_POST['newVideo'])) {
                $error = 'You can insert an image or video url but not both';
            } elseif (isset($_FILES['newImage']) and !empty($_FILES['newImage']['name'])) {
                $updateAvatar = $db->prepare('UPDATE evenement SET image=? , video=? WHERE id=?');
                $updateAvatar->execute(array($newImage, $setvideo, $idevent));
            } elseif (isset($_POST['newVideo']) and !empty($_POST['newVideo'])) {
                $editVideo =$db -> prepare('UPDATE evenement SET video=?, image=? WHERE id=?');
                $editVideo ->execute(array($newVideo, $setimage, $idevent));
            }
       
            $MailUserEvent = $db->prepare('SELECT pseudo , mail FROM utilisateur,user_event WHERE utilisateur.id = user_id && event_id = ?');
            $MailUserEvent->execute(array($idevent));
            while ($sendMail = $MailUserEvent->fetch()) {
                $maileditevent = new PHPMailer();
                $maileditevent->IsSMTP();
                $maileditevent->Mailer = "smtp";
                $maileditevent->SMTPAuth   = true;
                $maileditevent->SMTPSecure = "tls";
                $maileditevent->Port       = 587;
                $maileditevent->Host       = "smtp.gmail.com";
                $maileditevent->Username   = "bryanrasamizafy98@gmail.com";
                $maileditevent->Password   = "apzoeiruty135";

                $maileditevent->IsHTML(true);
                $maileditevent->AddAddress($sendMail['mail'], $sendMail['pseudo']);
                $maileditevent->SetFrom("bryanrasamizafy98@gmail.com", "JEPSENS-BRITE");
                $maileditevent->AddReplyTo("bryanrasamizafy98@gmail.com", "Teem media");
                $maileditevent->AddCC("cc-recipient-email@domain", "cc-recipient-name");
                $maileditevent->Subject = "Jepsens-brite event";
                $contenteditevent = "<p>" . $sendMail['pseudo'] . ".</p>
                  <p>We announce that event " . $newtitle . " has been modified.</p>
                  <p>It will take place on the " . $newdate ." at " . $newtime . " at the adresse " . $newadresse . "," . $newcp . " " . $newcity . ".</p>
                  <p>Cordially,</p>
                  <p>The JEPSENS-BRITE team.</p>
                      <img src='https://cdn.discordapp.com/attachments/734665861394071563/740911873318322266/jepsen_brite.png' alt='jepsens-brite'> 
                  ";
                $maileditevent->MsgHTML($contenteditevent);
                $maileditevent->send();
            }

            header("location: show_event.php?id=".$event['id']);
        }


        if (isset($_POST['delete'])) {
            $deleteEvent = $db ->prepare("DELETE FROM evenement WHERE id = ?");
            $deleteEvent ->execute(array($idevent));
            $deletecomments = $db->prepare("DELETE FROM commentaires WHERE event_id = ?");
            $deletecomments->execute(array($idevent));
            $deletesubcat = $db->prepare("DELETE FROM subcat_event WHERE event_id = ?");
            $deletesubcat->execute(array($idevent));
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
      <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
      <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </head>

  <body>
    
      <?php
        include 'layout/header.php';
        if ($event['MINUTE(time)'] ==0) {
            $minToShow = '00';
        } else {
            $minToShow = $event['MINUTE(time)'];
        }
      ?>

    <main>
      <section class="article" style="margin-top:60px">
     
        <div class="card-body">
            <?php
              if ($event['image']) {
                  echo '<img src="event/image/' . $event['image'] . '" width="100" alt="event image"/>';
              } elseif ($event['video']) {
                  echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $event["11"] . '" frameborder="0" 
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
              } else {
                  echo '<img src="https://mifato.s3.eu-west-3.amazonaws.com/no-image.png" width="100" alt="event image not found"/>';
              }
            ?>
        </div>
        <h2 class="titre-h2"><?php echo $event['titre']; ?></h2>
        <div class="category"><h3><?php echo $categoryTitle['title']; ?></h3></div>
        <?php
        while ($showSubcat = $subcat->fetch()) {
            ?>
            <h4 class="titre-h2"><?php echo $showSubcat['sub_titre']; ?></h4>
            <?php
        }
        ?>
        <h2 class="titre-h2"><?php echo $event['DAYNAME(date)'] . ' ' . $event['DAY(date)'] . ' ' . $event['MONTHNAME(date)'] . ' ' . $event['YEAR(date)'] . ' - ' . $event['HOUR(time)'] . ':' . $minToShow?> </h2>
        <h3 class='titre-h2'><?php echo $event['adresse']." ".$event['cp']." ".$event['ville'];?></h3>
        <p>Organisateur: <a href="user.php?id=<?php echo $event['auteur'] ;?>"><?php echo $event['pseudo']?></a></p>
        <h4 class="titre-h2" style="font-size:15px;"><?php echo $nbParticipant; ?> Participant(s) :  </h4>
        <ul class="participation" style="list-style-type: none;">
          <?php
            $whoCome = $db->prepare('SELECT pseudo , utilisateur.id FROM utilisateur, user_event WHERE utilisateur.id = user_id && event_id = ?');
            $whoCome ->execute(array($_GET['id']));
            while ($showWhoCome = $whoCome->fetch()) {
                ?>
            <li><a href="<?php echo "user.php?id=".$showWhoCome['id']; ?>" class="participant"><?php echo $showWhoCome['pseudo']." ,"; ?></a></li>
          <?php
            } ?>
        </ul>
        <p class="description"><strong>description:</strong><?php  echo " ".$event['description']; ?></p>
        <div class="participation">
            <form method="POST">
            <?php
            if (isset($_SESSION['id'])) {
                $verifParticipation = $db->prepare('SELECT * FROM user_event WHERE event_id = ? && user_id = ?');
                $verifParticipation->execute(array($_GET['id'],$_SESSION['id']));
                $participation = $verifParticipation->rowCount();
            
                if ($participation == 1) {
                    if ($event['date']>$today) {
                        ?>
                      <input type="submit" value="Ne plus participer" name="dontGo">
                  <?php
                    } else {
                        ?>
                  <p>Vous avez participé a cet événement.</p>
                  <?php
                    } ?>
              
                  
              
              <?php
                } else {
                    if ($event['date']>$today) {
                        ?>
                  <input type="submit" value="participer à l'événement" name="goEvent">
                  <?php
                    } else {
                        ?>
                  <p>Vous n'avez pas participé à cet événement. </p>
                  <?php
                    } ?>
          
                  
              
              <?php
                } ?>

      <?php
            }
          ?>
          
                <iframe src="https://www.google.com/maps?q=<?= $event['adresse'].' '.$event['cp'] ;?>  &output=embed" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </form>                        
        </div>

        <?php
                  if (isset($_SESSION['id'])) {
                      if ($_SESSION['id'] === $event['auteur']) {
                          ?>
                      
                      <form class ="formedit " method="POST" enctype='multipart/form-data'>
      
                        
                            
                            <div class="modal-content" >
                            
                                
                                <div class="modal-body">
                                    <p> Edit Title :</p>
                                    <input class="modal-title form-control w-100" type="text" id="exampleModalCenterTitle"  name="newTitle" value="<?php echo $event['titre']; ?>">        
                                    <br>
                                <p> Edit Date & Hour:</p>
                                    <div class="modal-text d-flex justify-content-left">
                        
                                    <input class="form-control w-25" type="date"  name="newDate" value="<?php echo $event['date']; ?>">
                                    <input class="form-control w-25" type="time" name="newHour" value="<?php echo $event['time']; ?>">
                                    <br>
                                <p>Edit adresse :</p>
                                    <input type="text" name="newAdress" value="<?php echo $event['adresse']?>">
                                    <input type="text" name="newCP" maxlength="4" value="<?php echo $event['cp']?>">
                                    <input type="text" name="newCity"  value="<?php echo $event['ville']?>">
                                <p>Edit image :</p>
                                    <input type="file" name='newImage'>
                                <p>Edit vidéo</p>
                                    <input type="video" name='newVideo'>
                                </div>
                                
                                <div class="modal-text">
                                    <br>
                                    <p>Edit description</p>
                                    <textarea class="form-control" rows="10" name="newDescription" type="text" data-emojiable="true" data-emoji-input="unicode"><?php echo  $event['description']; ?></textarea>
                                </div>
                                    
                                <div class="modal-footer">
                                    <input type="submit" name="edit" value="Save Changes" class="btn btn-primary">
                                  <?php
                      }
                      if ($_SESSION['id'] === $event['auteur'] or $_SESSION['admin'] == 1) { ?>
                                    <input type="submit" name="delete" value="Delete event" class="btn btn-primary">
                                  <?php } ?>
                                </div>
                                <?php if (isset($error)) {  ?>
                                    <div class="error">
                                        <p><i class="fas fa-times"></i> <?php echo $error ?> <i class="fas fa-times"></i></p>
                                    </div>
                                <?php } ?>

                        </form>
          
                    <?php
                  } ?>
        <?php include 'comments.php'; ?>
      </section>
    </main>
  </body>
</html>
