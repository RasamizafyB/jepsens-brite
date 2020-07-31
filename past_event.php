<?php
if(!isset($_SESSION)){
    session_start();
}
?>

<html>
<head>
<title>past events</title>
<link rel="stylesheet" href="src/css/style.css">
</head>
<body>
<?php 
    if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id']){
        include("layout/header.php");
    }else{
        include("layout/header.inc.php");
    }
?>
<main class="grid">
<table  class="categoryzone">
    <tr><th>Catégories</th></tr>
    <tr>
        <td class="inputcheck">
            <div>
                <input type="checkbox" id="all" name="all">
                <label for="concert">
                    All
                </label>
            </div>
        </td>
    </tr>
    <tr>
        <td class="inputcheck">
            <div>
                <input type="checkbox" id="concert" name="concert">
                <label for="concert">
                    concert
                </label>
            </div>
        </td>
    </tr>
    <tr>
        <td class="inputcheck">
            <div>
                <input type="checkbox" id="culture" name="culture">
                <label for="culture">
                    culture
                </label>
            </div>
        </td>
    </tr>
    <tr>    <td class="inputcheck"><div><input type="checkbox" id="manifestation" name="manifestation"><label for="manifestation">manifestation</label></div></td>
    </tr>
    <tr><td class="inputcheck"><div><input type="checkbox" id="musee" name="musee"><label for="musee">musée</label></div></td></tr>
    </table>
    <div class="feedback">
        <?php date_default_timezone_set('Europe/Paris')?>
            <div class="range">
            <?php 
                if(isset($_GET['id']) AND $_GET['id'] == $_SESSION['id']){
            ?>
                    <a href="event.php?id=<?php echo $_SESSION['id']; ?>" class="buttonadd">events</a>
                    <a href="past_event.php?id=<?php echo $_SESSION['id']; ?>" class="buttonadd">past events</a>
                    <a href="create_event.php?id=<?php echo $_SESSION['id']; ?>" class="buttonadd">+ add even</a>
            <?php
                }else{
            ?>
                    <a href="event.php" class="buttonadd">events</a>
                    <a href="past_event.php" class="buttonadd">past events</a>
            <?php
                }
            ?>
        </div>
        <?php include("template.php"); ?>
        <?php include("template.php"); ?>
        <?php include("template.php"); ?>
        <?php include("template.php"); ?>
        <?php include("template.php"); ?>
    </div>
</main>
<?php include("layout/footer.inc.php");?>

<script src="https://kit.fontawesome.com/1815b8a69b.js" crossorigin="anonymous"></script>
</body>
</html>