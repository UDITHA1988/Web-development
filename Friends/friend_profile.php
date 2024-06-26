<?php 

    include('db.php');
    session_start();

    $id = $_SESSION['friend_id'];

    if(isset($_POST['share'])){

        $user_id = $_SESSION['id'];
        $post_id = $_POST['post_id'];

        $sql = "INSERT INTO posts (user_id, post_id) VALUE('$user_id', '$post_id')";
    
        if(mysqli_query($conn, $sql)){
            // data saved
        }else{
        echo 'insert query error'.mysqli_error($conn);
        }
    }

    //get profile info

    $sql = "SELECT * FROM profile WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $info = mysqli_fetch_assoc($result);

    $profile_pic_exist = true;

    if(isset($info['profile_pic'])){
        $profile_pic_exist = false;
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
    
    foreach($posts as $post){
      //print_r($post);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>FRIEND profile</title>
        <link rel="stylesheet" href="css/friend_profile.css">
    </head>

    <body>
        <div class="top">
            <ul>
                <li>
                    <div class="name"><h1><?php  echo $first_name . " " . $last_name?></h1></div>
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
    
        <div class="posts">
            <div>
                <?php foreach($posts as $post) : ?>
                    </br>
                    <div class="post">
                        </br>
                        <div>
                            <?php 
                                $poster = 'uploads/'. $post['post_id']; 
                                echo "<img src='$poster' > ";
                            ?>
                        </div>
                        <div>
                            <form action="friend_profile.php" method="POST">
                                <input type= "hidden" name="user_id" value= "<?php echo $id ?>" >
                                <input type = "hidden" name ="post_id" value= "<?php echo $post['post_id'] ?>">
                                <input type= "submit" name="share" value= "SHARE" >
                            </form>    
                        </div>
                    </div>
                    </br>
                    </br>  
                <?php endforeach ; ?>
            </div>
        </div>
    
        <div class ="profile_pic_outer">
            <div class="profile_pic">
                <div>
                    <?php if(!$profile_pic_exist){
                        $pic = 'profile/'. $info['profile_pic']; 
                        echo "<img src='$pic' > ";
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>