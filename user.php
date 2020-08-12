<?php
    session_start();
   
    include 'config/config.php';

    try {
		$bdd = new PDO($dbdsn, $dbusername, $dbpassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
    }
    $today = date("Y-m-d");
    
    if(isset($_SESSION['id'])){
        if($_SESSION['id'] == $_GET['id']){
            $participated = $bdd->prepare("SELECT titre, id, date FROM evenement,user_event WHERE id=event_id && user_id= ? && date< ? ORDER BY date");
            $participated->execute(array($_SESSION['id'],$today));
        }
        if($_SESSION['id'] == $_GET['id']){
            $participate = $bdd->prepare("SELECT titre, id, date FROM evenement,user_event WHERE id=event_id && user_id= ? && date>= ? ORDER BY date");
            $participate->execute(array($_SESSION['id'],$today));
        }
        if($_SESSION['id'] == $_GET['id']){
            $created = $bdd->prepare("SELECT titre, id, date FROM evenement WHERE auteur= ? ORDER BY date");
            $created->execute(array($_SESSION['id']));
        }
    }
    if(isset($_GET['id']) AND $_GET['id'] > 0){
        $getid = intval($_GET['id']);
        $req = $bdd->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $req->execute(array($getid));
        $user = $req->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil user</title>

    <link rel="shortcut icon" href="https://img.icons8.com/color/48/000000/naruto.png" type="image/x-icon">
    <link rel="stylesheet" href="src/css/style.css">

    <script type="text/javascript">
        function ConfirmDelete()
        {
            if (confirm("Delete Account?")){
                location.href="<?php echo "delete_profile.php?id=".$_SESSION['id']; ?>";
            }     
        }
    </script>
</head>
<body>
    <?php include("layout/header.php");?>
        <main>
            <div class="feedback">
                <?php date_default_timezone_set('Europe/Paris'); ?>
                <div class="range">
                <?php 
                    if(isset($_SESSION['id'])){
                ?>
                        <a href="category.php" class="buttonadd">events</a>
                        <a href="past_event.php?id=<?php echo $_SESSION['id']; ?>" class="buttonadd">past events</a>
                        <a href="create_event.php?id=<?php echo $_SESSION['id']; ?>" class="buttonadd">+ add even</a>
                <?php
                    }else{
                ?>
                        <a href="category.php" class="buttonadd">events</a>
                        <a href="past_event.php" class="buttonadd">past events</a>
                <?php
                    }
                ?>
                </div>
                <section class="article">
                    <div class="range1">
                        <?php if(isset($_SESSION['id']) AND $_SESSION['admin'] == 1){ ?>
                            <a href="edit_profile.php?id=<?php echo $_SESSION['id']; ?>"><i class="fas fa-pen buttonsection"></i></a>
                        <?php }elseif(isset($_SESSION['id'])){ ?>
                            <a href="edit_profile.php?id=<?php echo $_SESSION['id']; ?>"><i class="fas fa-pen buttonsection"></i></a>
                            <button class='deletebutton' onclick="ConfirmDelete()"><i class="fas fa-trash buttonsection"></i></button>
                        <?php } ?> 
                    </div>
                        <img src="user/avatar/<?php echo $user['avatar']; ?>" alt="image user" class="imguser" width='150'>
                        <h2 class="titre-h2"><?php echo $user['pseudo']; ?></h2>
                        <h5 class="email"><?php echo $user['mail']; ?></h5>
                        <?php if(isset($_SESSION['id']) AND $_SESSION['admin'] == 1){?>
                            <a href="admin.php" class="titre-h2 buttonsection">Administrateur</a>
                        <?php }elseif($user['admin'] == 1){ ?>
                            <p>Administrateur</p>
                        <?php }else{ ?>
                            <p>Utilisateur</p>
                        <?php } ?>   
                </section>
                <?php 
                    if(isset($_SESSION['id'])){
                        if($_SESSION['id'] == $_GET['id']){
                        ?>
                            <div class="profileevent">
                                <div class="profilezone1">
                                    <table>
                                        <tr>
                                            <th class="thstyle">participated events</th>
                                        </tr>
                                        <?php while($showParticipated = $participated->fetch()){ ?>
                                            <tr>
                                                <td><a href="<?php echo 'show_event.php?id='.$showParticipated['id']?>" class="buttonsection"><?php echo $showParticipated['titre']?></a></td>
                                                <td><?php echo $showParticipated['date'];?></td>
                                            </tr>
                                        <?php } ?>  
                                    </table>
                                </div>
                                <div class="profilezone2">
                                    <table>
                                        <tr>
                                            <th class="thstyle">participation in events</th>
                                        </tr>
                                        <?php while($showParticipate = $participate->fetch()){ ?>
                                            <tr>
                                                <td><a href="<?php echo 'show_event.php?id='.$showParticipate['id']?>" class="buttonsection"><?php echo $showParticipate['titre']?></a></td>
                                                <td><?php echo $showParticipate['date'];?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                                <div class="profilezone3">
                                    <table>
                                        <tr>
                                            <th class="thstyle">created events</th>
                                        </tr>
                                        <?php while($showCreated = $created->fetch()){ ?>
                                            <tr>
                                                <td><a href="<?php echo 'show_event.php?id='.$showCreated['id']?>" class="buttonsection"><?php echo $showCreated['titre']?></a></td>
                                                <td><?php echo $showCreated['date'];?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>     
                            </div>
                        <?php
                        }
                    }
                ?>
            </div>
        </main>
        <script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>
<?php
    }else{
        header("Location: index.php");
    }
?>