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
<h2 class="text-center">Event Comments</h2>

     <div class="commentButton">
         <?php 
         if(isset($_SESSION['id'])){
             ?>
  

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                
                                
                            </div>
                            <div class="modal-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label class="text-center" for="exampleTextarea">Your comment </label>
                                    <textarea name="userComment" class="form-control" id="exampleTextarea"></textarea>
                                    
                                </div>  
                                <div class="modal-footer">
                                <input class="btn btn-success" type="submit" name="sendComment" value="Post Comment">
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
                    <div class="card border-success mt-3 w-100 mx-auto">
                        <div class="card-header d-flex justify-content-between">
                            <a class="h4" href="<?php echo "user.php?id=".$showComments['1'];?>">
                                <img width="40" height="40" class="rounded-circle" src="<?php echo "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $showComments['mail']) ) ). "&s=" . 10;?>" alt="">
                                <?php echo $showComments['pseudo'];?>
                            </a>

                                       <?php 
                                if(isset($_SESSION['id'])){
                                    if($_SESSION['id'] === $showComments['1'] OR $_SESSION['admin'] == 1){
                                        ?>
                                            <a href="<?php echo 'delete_comment.php?id='.$showComments['id'].'&idauthor='.$showComments['1'].'&eventid='.$idevent; ?>">
                                                <button type="button" class="btn btn-danger" style="height: 35px;">
                                                    X
                                                </button>
                                        </a>
                                            
                                        

                                        <?php
                                        
                                    }
                                }
                            ?></div>
                        <div class="card-body" style="overflow: auto;">
                            <h3 class="card-title" style="overflow: auto;"><?php echo $showComments['commentaire'];?></h3>
                            <p class="card-text text-white-50"><?php echo $showComments['9'] . ' ' . $showComments['8'] . ' ' . $showComments['7'] . ' ' . $showComments['6'] . ' - ' . $showComments['10'] . ':' . $showComments['11'];?></p>

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
              