<?php 

  include('db.php');
  session_start();

  $id = $_SESSION['id'];
    
  // upload profile_pic

  if(isset($_POST['upload'])){
    if ($_FILES["profile_pic"]["error"] == UPLOAD_ERR_OK) {
      $fileName = $_FILES["profile_pic"]["name"];
      $tmpName = $_FILES["profile_pic"]["tmp_name"];
      $fileSize = $_FILES["profile_pic"]["size"];
      $fileType = $_FILES["profile_pic"]["type"];
                      
      $fileError = $_FILES["profile_pic"]["error"];
          
      $allowedExtensions = array("jpg", "jpeg", "png", "gif");
      $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
          
      if (in_array($fileExtension, $allowedExtensions)) {
        if ($fileSize <= 5000000) {
          if (move_uploaded_file($tmpName, "profile/" . $fileName)) {

            // save file

            $user_id = $id;
            $pic_id = $_FILES["profile_pic"]["name"];
                
            $sql = "INSERT INTO profile (id, profile_pic) VALUE('$user_id', '$pic_id')";
                    
            if(mysqli_query($conn, $sql)){
              //echo 'post saved';
                      
            }else{
                echo 'insert query error'.mysqli_error($conn);
            }

          } else {
            echo '<script type="text/javascript">alert("Failed to upload file.")</script>';
          }

        } else {
          echo '<script type="text/javascript">alert("File size must be less than 5MB.")</script>';
        }

      } else {
        echo '<script type="text/javascript">alert("Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.")</script>';
      }

    } else {
      echo '<script type="text/javascript">alert("An error occurred during file upload.")</script>';
    }        
  }
   
  // check if profile info already uploaded

  $exist = false;

  $sql = "SELECT * FROM profile WHERE id = '$id'";
  $result = mysqli_query($conn, $sql);
  $info = mysqli_fetch_assoc($result);
  
  if(mysqli_num_rows($result) != 0){
    $exist = true;
  }

  //get user details

  $sql = "SELECT * FROM account WHERE id = '$id'";
  $details = mysqli_query($conn, $sql);
  $detail = mysqli_fetch_assoc($details);
  $first_name = $detail['first_name'];
  $last_name = $detail['last_name'];

  //get posts

  $sql = "SELECT post_id FROM posts WHERE user_id = '$id'";
  $posts = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

  <head>
    <title>FRIENDS profile</title>
    <link rel="stylesheet" href="css/profile.css">
    <script defer src="js/profile.js" ></script>
  </head>

  <body>
    <div class="top">
      <ul>
        <li>
          <div class= "name">
            <h1><?php  echo $first_name . " " . $last_name?></h1>
          </div>
        </li>
        <li>
          <div class="tags">
            <ul>
              <li>
                <a href="wall.php"  >Home</a>
              </li>
              <li>
              <a href="index.php"  >Log out</a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
      </div>    
    </div>
 
    <div class="posts">
      <div >
        <?php foreach($posts as $post) : ?>
          <br/>
          <div class="post">
            <br/>
            <?php 
              $post = 'uploads/'. $post['post_id'];   
              echo "<img src='$post' > ";
            ?>
            <br/>
          </div>
        <br/>
        <br/>
        <?php endforeach ; ?>
      </div>
    </div>

    <div class="profile_pic_outer">
      <div class="profile_pic">
        <div class="profile_pic_upload">
          <?php if(!$exist): ?>
            <form action="profile.php" method="POST" enctype="multipart/form-data" id="form">
              <label>Upload profile picture:</label>
              <br/>
              <label>
                    <input type="file" name="profile_pic" id="profile_pic" style="display: none;">
                    <a id = "upload_img">Choose Image</a>
              </label>
              <input type ="hidden" name="$id" >
              <input name="upload" type="submit" value="Upload File">
            </form>
        </div>
        <div >
          <?php else: ?>
            <?php 
              $pic = 'profile/'. $info['profile_pic']; 
              echo "<img src='$pic' > ";  
            ?>
          <?php endif; ?>  
        </div>
      </div>
    </div>
  </body>
</html>