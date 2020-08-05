<?php
 $comments = $db->prepare("SELECT pseudo,u.id, date_commentaire, commentaire, mail, c.id,                         YEAR(date_commentaire), 
 MONTHNAME(date_commentaire), 
 DAY(date_commentaire), 
 DAYNAME(date_commentaire), 
 HOUR(date_commentaire), 
 MINUTE(date_commentaire)FROM commentaires AS c LEFT JOIN utilisateur AS u ON c.createur_id = u.id WHERE event_id =  ? ORDER BY date_commentaire DESC");
 $comments->execute(array($_GET['id']));

//   if(isset($_POST['sendComment'])){
//       echo "bonjouuuur";
//       $addComment = $db->prepare("INSERT INTO comments (text, date_comment, author_id, event_id) VALUES (:text ,NOW(), :author, :event)");
//       $addComment->bindParam('text',$_POST['userComment']);
//       $addComment->bindParam('author',$_SESSION['id']);
//       $addComment->bindParam('event',$idevent);
//       $addComment->execute();
     
//      }
    
?>
<div class="comments">
<h2 class="titre-h2">Event Comments</h2>

         <?php 
         if(isset($_SESSION['id'])){
             ?>
                            <form method="POST" style="margin-top:40px;">
                                <div class="form-group">
                                    <label class="text-center" for="exampleTextarea">Your comment </label><br>
                                    <textarea name="userComment" class="title_input" style="resize:none; height:100px" id="exampleTextarea"></textarea>
                                    
                                </div>  
                                <div class="modal-footer">
                                <input class="buttonadd" type="submit" name="sendComment" value="Post Comment">
                                </div>
                            </form>
                            </div>  
                            
                        </div>
                    </div>
                    </div>
             <?php
         }else{
             ?>
             <div class="connectToComment d-flex justify-content-around d-block mx-auto" style="width: 500px;">
                 <a href="signup_page.php">
                     <button class="btn btn-info">Log in to comment</button>
                 </a>
                  
                  <a href="signin_page.php">
                     <button class="btn btn-info">Sign in to comment</button>
                 </a>
             </div>
             <?php
         }
         ?>
     </div>
    <!-- <div class="container justify-content-center"> -->
  
            <?php 
                while($showComments = $comments->fetch()){
                    
                    if($showComments['11'] ==0){
                        $minToShow = '00';
                    } else {
                        $minToShow = $showComments['11'];
                    }

                    // var_dump($showComments);

                    if(isset($showComments['mail'])){
                    
                    ?>
                            <a class="h4" href="<?php echo "user.php?id=".$showComments['1'];?>">
                                <div style="display:flex;flex-direction:row; align-items:center;margin-bottom:-20px;">
                                <img width="40" height="40" width='45' class="imgcomment"" src="<?php echo "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $showComments['mail']) ) ). "&s=" . 10;?>" alt="image-user">
                                <div class="author"><?php echo $showComments['pseudo'];?></div>
                            </div>
                            </a>
                        <div class="combody" style="overflow: auto;">
                                       <?php 
                                if(isset($_SESSION['id'])){
                                    if($_SESSION['id'] === $showComments['1'] OR $_SESSION['admin'] == 1){
                                        ?>
                                            <a href="<?php echo 'delete_comment.php?id='.$showComments['id'].'&idauthor='.$showComments['1'].'&eventid='.$idevent; ?>">
                                            <i class="fas fa-times buttonsection" style="float:right"></i></a>
                                            
                                        

                                        <?php
                                        
                                    }
                                }
                            ?>
                            <h3 class="description" style="overflow: hidden;"><?php echo $showComments['commentaire'];?></h3>
                            <p class="author"><?php echo $showComments['9'] . ' ' . $showComments['8'] . ' ' . $showComments['7'] . ' ' . $showComments['6'] . ' - ' . $showComments['10'] . ':' . $showComments['11'];?></p>

                            </div>
                            </div>
                    <?php
                    }else{
                        ?>
                        <div class="card border-success mt-3 w-100 mx-auto" style="width: 60rem; height: 20rem; ">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="h4">
                                <img width="40" height="40" class="rounded-circle" src="<?php echo "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $showComments['email']) ) ). "&s=" . 10;?>" alt="">
                                Deleted Account
                    </h4>

                        </div>
                        <div class="card-body" style="overflow: auto;">
                            <h3 class="card-title" style="overflow: auto;"><?php echo $showComments['text'];?></h3>
                            <p class="card-text text-white-50"><?php echo $showComments['9'] . ' ' . $showComments['8'] . ' ' . $showComments['7'] . ' ' . $showComments['6'] . ' - ' . $showComments['10'] . ':' . $showComments['11'];?></p>

                        </div>
                    </div>
                            <!-- </div> -->
                        <?php
                    }
                }
            ?>
              