<?php
if(!isset($_SESSION)){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>
<body>
    <?php 
        if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id']){
            include("layout/header.php");
        }else{
            include("layout/header.inc.php");
        }
    ?>
    <main>
        <div class="feedback">
        <?php date_default_timezone_set('Europe/Paris')?>
        <div class="range">
        
        <?php 
            if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id']){
                ?>
                <a href="event.php?id=<?php echo $_SESSION['id']; ?>" class="buttonadd">events</a>
                <a href="past_event.php?id=<?php echo $_SESSION['id']; ?>" class="buttonadd">past events</a>
                <a href="create_event.php?id=<?php echo $_SESSION['id']; ?>" class="buttonadd">+ add event</a>
        <?php
            }else{
                ?>
                <a href="event.php" class="buttonadd">events</a>
                <a href="past_event.php" class="buttonadd">past events</a>
        <?php
            }
            ?>
        </div>
            <div id="slider">
                <?php include("slider.php"); ?>
            </div>
            <?php include("template.php"); ?>
            <?php include("template.php"); ?>
            <?php include("template.php"); ?>
            <?php include("template.php"); ?>
            <?php include("template.php"); ?>
    </main>
    <?php include("layout/footer.inc.php");?>
    <script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>
