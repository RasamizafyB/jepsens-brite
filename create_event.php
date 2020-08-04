<?php
    if(!isset($_SESSION)){
        session_start();
    }
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
        $description = htmlspecialchars($_POST['description']);
        $category = $_POST['category'];
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
        
        if(!empty($_POST['title']) AND !empty($_POST['date']) AND !empty($_POST['time']) AND !empty($_POST['category']) AND isset($_SESSION['id']) AND !isset($error)){
            $addEvent = $bdd->prepare("INSERT INTO evenement (titre, auteur, date, time, image, description, categorie_id) VALUES 
            ( :titre, :auteur, :date, :time, :image, :description, :categorie_id)"); 
            $addEvent->execute(array(
                'titre' => $title,
                'auteur' => $userId,
                'date' => $date,
                'time' => $hour,
                'image' => $eventImage,
                'description' => $description,
                'categorie_id' => $category
            ));
            $done = "Your event has been created";
        }else{
            $error = "Complet the form please!";
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
<?php 
    if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id']){
        include("layout/header.php");
    }else{
        include("layout/header.inc.php");
    }
?>

<main>
    <h2 class="Titre-h2 h2center">Nouvel événement</h2>
    <form action="" method="POST"  enctype='multipart/form-data'>
        <input type="text" class="title_input"  placeholder="Titre" name='title'>
        <input class="title_input" type="date" name="date" id="date">
        <input class="title_input" type="time" name="time" id="time">
        <input type="text" class="descr_input"  placeholder="insérez votre description ici" name='description'>
        <input type="file" class="title_input" name='image'>
        <select class="title_input" name="category" style="width:200px;">
           <option value="0">select category</option>
           <?php
                $reqcategory = $bdd->query("SELECT * FROM categorie ORDER BY title");
                while($categoryMenu = $reqcategory->fetch()){
                    echo'<optgroup value="'.$categoryMenu['id'].'" label="'.$categoryMenu['title'].'" >'.$categoryMenu['title'];
                        $reqsubcat= $bdd->prepare("SELECT * FROM subcat WHERE cat_id=? ORDER BY sub_titre ");
                        $reqsubcat->execute(array($categoryMenu['id']));
                        while($subcatMenu = $reqsubcat->fetch()){
                            if($subcatMenu['cat_id']==$categoryMenu['id']){
                                echo'<option value="'.$subcatMenu['id'].'">'.$subcatMenu['sub_titre'].'</option>';
                            };
            };
            echo'</optgroup>';
        };?>
    </select>
        <input type=submit class="title_input" name='formEvent'>
    </form>
    <?php
        if(isset($error)){
    ?>
        <div class="error">
            <p><i class="fas fa-times"></i> <?php echo $error ?> <i class="fas fa-times"></i></p>
        </div>
    <?php
        }
        if(isset($done)){
    ?>
        <div class="done">
            <p><i class="fas fa-check"></i> <?php echo $done?> <i class="fas fa-check"></i></p>
        </div>
    <?php
        }
    ?>
</main>
<?php include("layout/footer.inc.php");?>


<script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>