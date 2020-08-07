<?php
    session_start();
    
    include 'config/config.php';  

    try {
		$bdd = new PDO($dbdsn, $dbusername, $dbpassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
    }

    if(isset($_POST['formEvent'])){
        $title = htmlspecialchars($_POST['title']);
        $date = htmlspecialchars($_POST['date']);
        $hour = htmlspecialchars($_POST['time']);
        $adresse = htmlspecialchars($_POST['adresse']);
        $code_postal = htmlspecialchars($_POST['code_postal']);
        $ville = htmlspecialchars($_POST['ville']);
        $description = htmlspecialchars($_POST['description']);
        $video = substr(htmlspecialchars($_POST['video']), 32) ;
        $category = $_POST['category'];
        $subCat = $_POST['subcat'];
        $userId = $_SESSION['id'];

        if(isset($_FILES['image']) AND !empty($_FILES['image']['name'])){
            $tailleMax = 2097152;
            $extensoinValide = array('jpg', 'jpeg', 'png', 'gif');
            if($_FILES['image']['size'] <= $tailleMax){
                $extensionUpload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
                if(in_array($extensionUpload, $extensoinValide)){
                    $chemin = "event/image/".$title.".".$extensionUpload;
                    $resultat = move_uploaded_file($_FILES['image']['tmp_name'], $chemin);
                    $eventImage = $title.".".$extensionUpload;
                }else{
                    $error = 'The image format must be in JPG, JPEG, PNG or GIF';
                }
            }else{
                $error = 'Your image is so big';
            } 
        }
        
        if(!empty($_POST['title']) AND !empty($_POST['date']) AND !empty($_POST['time']) AND !empty($_POST['category']) AND  
        isset($_SESSION['id']) AND !isset($error) AND !empty($_POST['adresse']) AND !empty($_POST['code_postal']) AND !empty($_POST['ville'])){
            if(isset($_FILES['image']) AND !empty($_FILES['image']['name']) AND isset($_POST['video']) AND !empty($_POST['video'])){
                $error = 'You can insert an image or video url but not both';
            }elseif(isset($_FILES['image']) AND !empty($_FILES['image']['name'])){
                $addEvent = $bdd->prepare("INSERT INTO evenement (titre, auteur, date, time, image, description, categorie_id, adresse, cp, ville) VALUES 
                ( :titre, :auteur, :date, :time, :image, :description, :categorie_id, :adresse, :cp, :ville)"); 
                $addEvent->execute(array(
                    'titre' => $title,
                    'auteur' => $userId,
                    'date' => $date,
                    'time' => $hour,
                    'image' => $eventImage,
                    'description' => $description,
                    'categorie_id' => $category,
                    'adresse' => $adresse,
                    'cp' => $code_postal,
                    'ville' => $ville
                ));
                $done = "Your event has been created whith image";
                $newIDevent = $bdd->lastInsertId();
                $addSub = $bdd->prepare("INSERT INTO `subcat_event` (`event_id`, `subcat_id`) VALUES (:event , :sub);");
                foreach($subCat as $sub){
                    $addSub->bindParam('event',$newIDevent);
                    $addSub->bindParam('sub',$sub);
                    $addSub->execute();
                }

            }elseif(isset($_POST['video']) AND !empty($_POST['video'])){
                $addEvent = $bdd->prepare("INSERT INTO evenement (titre, auteur, date, time, description, categorie_id, adresse, cp, ville, video) VALUES 
                ( :titre, :auteur, :date, :time, :description, :categorie_id,  :adresse, :cp, :ville, :video)"); 
                $addEvent->execute(array(
                    'titre' => $title,
                    'auteur' => $userId,
                    'date' => $date,
                    'time' => $hour,
                    'description' => $description,
                    'categorie_id' => $category,
                    'adresse' => $adresse,
                    'cp' => $code_postal,
                    'ville' => $ville,
                    'video' => $video
                ));
                $done = "Your event has been created with video";
                $newIDevent = $bdd->lastInsertId();
                $addSub = $bdd->prepare("INSERT INTO `subcat_event` (`event_id`, `subcat_id`) VALUES (:event , :sub);");
                foreach($subCat as $sub){
                    $addSub->bindParam('event',$newIDevent);
                    $addSub->bindParam('sub',$sub);
                    $addSub->execute();
                }

            }else{
                $error = "Insert an image or video url please!";
            }
        }else{
            $error = "Complet the form please!";
        }

        if($category == 1){
            if(isset($_POST['1'])){

            }
        }
    }
?>

<html>
<head>
    <title>create event</title>
    <link rel="stylesheet" href="src/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
</head>
<body>
    <?php include("layout/header.php"); ?>

<main>
    <h2 class="Titre-h2 h2center">Nouvel événement</h2>
    <form action="" method="POST"  enctype='multipart/form-data'>
        <input class="title_input" type="text" name='title' placeholder="Titre">
        <input class="title_input" type="date" name="date" id="date">
        <input class="title_input" type="time" name="time" id="time">
        <input class="title_input" type="text" name="adresse" id="adress" placeholder="Rue des Brasseurs 26">
        <input class="title_input" type="text" name="code_postal" id="code_postal" placeholder="4000" maxlength="4">
        <input class="title_input" type="text" name="ville" id="ville" placeholder="Liège">
        <input class="descr_input" type="text" name='description' placeholder="insérez votre description ici" >
        <input class="title_input" type="file" name='image'>
        <p class="title_input" style="margin-top:20px;">Ou Url vidéo</p>
        <input class="title_input" type="text" name="video" id="url" placeholder="https://example.com" >
        <div class="title_input" style="width:400px;">
        <p style="margin-top:20px;">Category</p>
            <?php
                $reqcategory = $bdd->query("SELECT * FROM categorie ORDER BY title");
                while($categoryMenu = $reqcategory->fetch()){
                    echo'<input type="checkbox" name="category" value="'.
                    $categoryMenu['id'].
                    '" label="'.$categoryMenu['title'].
                    '" style="margin-top:20px; " ><strong>'.
                    $categoryMenu['title'].
                    '</strong></input><hr>';
                    $reqsubcat= $bdd->prepare("SELECT * FROM subcat WHERE cat_id=? ORDER BY sub_titre ");
                    $reqsubcat->execute(array($categoryMenu['id']));
                    while($subcatMenu = $reqsubcat->fetch()){
                        if($subcatMenu['cat_id']==$categoryMenu['id']){
                            echo'<input type="checkbox" name="subcat[]" value="'.
                            $subcatMenu['id'].
                            '">'.$subcatMenu['sub_titre'].
                            '</input>';
                        };
                    };
                    echo'<br>';
                };
            ?>
        </div>
        <input type=submit class="title_input" name='formEvent'>
    </form>
    <?php if(isset($error)){  ?>
        <div class="error">
            <p><i class="fas fa-times"></i> <?php echo $error ?> <i class="fas fa-times"></i></p>
        </div>
    <?php }elseif(isset($done)){ ?>
        <div class="done">
            <p><i class="fas fa-check"></i> <?php echo $done?> <i class="fas fa-check"></i></p>
        </div>
    <?php } ?>
</main>
<?php include("layout/footer.inc.php");?>

<script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>