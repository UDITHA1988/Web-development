<?php 

    session_start();
    include('db.php');

    // get user id

    $id = $_SESSION['id'];

    // post images

    if(isset($_POST['submit'])){
        if ($_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
            $fileName = $_FILES["fileToUpload"]["name"];
            $tmpName = $_FILES["fileToUpload"]["tmp_name"];
            $fileSize = $_FILES["fileToUpload"]["size"];
            $fileType = $_FILES["fileToUpload"]["type"];
          
            
            $fileError = $_FILES["fileToUpload"]["error"];
          
            $allowedExtensions = array("jpg", "jpeg", "png", "gif");
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
          
            if (in_array($fileExtension, $allowedExtensions)) {
                if ($fileSize <= 5000000) {
                    if (move_uploaded_file($tmpName, "uploads/" . $fileName)) {
                        //echo "File uploaded successfully.";
                        $user_id = $_SESSION['id'];
                        $post_id = $_FILES["fileToUpload"]["name"];
          
                        $sql = "INSERT INTO posts (user_id, post_id) VALUE('$user_id', '$post_id')";
              
                        if(mysqli_query($conn, $sql)){
                            echo '<script type="text/javascript">alert("Image uploaded successfully")</script>';
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
                //echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
            }
        } else {
            echo '<script type="text/javascript">alert("An error occurred during file upload.")</script>';
        }         
    }

    

    if(isset($_POST['friend_profile'])){
        $_SESSION['friend_id'] = $_POST['friend_id'];
        header('Location:friend_profile.php');
    }

    // share posts

    if(isset($_POST['share'])){

        $user_id = $id;
        $post_id = $_POST['post_id'];

        $sql = "INSERT INTO posts (user_id, post_id) VALUE('$user_id', '$post_id')";
    
        if(mysqli_query($conn, $sql)){
            // info saved
        }else{
            echo 'insert query error'.mysqli_error($conn);
        }
    }

    // get a list of the following 

    $sql = "SELECT follower FROM friends WHERE following = '$id' ";
    $result = mysqli_query($conn, $sql);

    $friends = array();

    foreach($result as $friend){
        $friend_id = $friend['follower'];
        array_push($friends, $friend_id);
    }

    // an empty array throw errors in sql query

    if(empty($friends)){
        $element = 0;
        array_push($friends, $element);
    }

    $friends = implode(',', $friends);

    // get data for friends list

    $_SESSION['friend_list'] = $friends;

    $sql = "SELECT first_name, last_name, id FROM account WHERE id IN ($friends)";
    $result_friends_list = mysqli_query($conn, $sql);    

    // get feed

    $sql = "SELECT post_id, user_id FROM posts WHERE user_id IN ($friends)";
    $result = mysqli_query($conn, $sql);

    if(isset($POST['friend_profile'])){
        
        header('Location: friend_profile.php');
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>FRIENDS home</title>
        <link rel="stylesheet" href="css/wall.css">
        <script defer src="js/wall.js" ></script>
    </head>
    <body>    
        <section class="upload">
            <ul>
                <li id ="friend">
                    <h1><b>F R I E N D S</b> </h1>
                </li>
                <li id="form">
                    <form action="wall.php" method="POST" enctype="multipart/form-data" id="form" class="upload_form">    
                        <label for="fileToUpload">Share your story : </label>
                        <label>
                            <input type="file" name="fileToUpload" id="fileToUpload" style="display: none;">
                            <a id = "upload_img">UPLOAD IMAGE</a>
                        </label>
                        <input type ="hidden" name="$email" >
                        <input id = "post" type="submit" name= "submit" value="POST">
                    </form>
                </li>
            <ul>
        </section>
        <section class="posts">
            <div>
                <?php foreach($result as $post) : ?>
                    <br/>
                    <div class="post">
                        <br/>
                        <div >
                            <?php 
                                $poster = 'uploads/'. $post['post_id']; 
                                echo "<img src='$poster' > ";
                            ?>
                        </div>  
                        <div >   
                            <form action="wall.php" method="POST" class = "post_form">
                                <input type= "hidden" name="user_id" value= "<?php echo $id ?>" >
                                <input type = "hidden" name ="post_id" value= "<?php echo $post['post_id'] ?>">
                                <input type= "submit" name="share" id="post_submit" value= "SHARE" >
                            </form>    
                        </div>
                    </div>
                    <br/>
                    <br/>
                <?php endforeach;?>
            </div>
        </section>
        <section class="profile">
            <br/>
            <a href="profile.php">Profile</a>
        </section>
        <section class= "add_friends">
            <br/>
            <a href="search.php">Add friends</a>
        </section>
        <section class="requests" >
            <br/>
            <a href="request.php">Requests</a>
        </section>
        <section class="log_out">
            <br/>
            <a href="index.php">Log out</a>
        </section>
        <section class="f_list">
            <br/>
            <div>My friends</div>
            <div class="f_list_in">
                <?php foreach($result_friends_list as $friend): ?>
                    <br/>
                    <form action="wall.php" method="POST">
                        <input type="hidden" name= "friend_id" value ="<?php echo $friend['id'] ?>">
                        <input type="submit" name="friend_profile" value ="<?php echo $friend['first_name']. " " .$friend['last_name'] ?>">
                    </form>
                <?php endforeach ?>
            </div>
        </section>
    </body>
</html>
