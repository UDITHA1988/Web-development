<?php 

    session_start();

    $details=true;
    $msg = "Email or Password is not correct";

    $user;
    
    include('db.php');

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT COUNT(*) AS count FROM account WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_fetch_assoc($result);

        if($count['count']>0){

            // correct details

            $user = $email;

           //get user id
 
            $sql = "SELECT * FROM account WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $result_id = mysqli_fetch_assoc($result);
            $id = $result_id['id'];
            $_SESSION['id'] = $id;
            header('Location: wall.php');

        }else{

            //wrong details

            $details = false;
        
        }
    }
?>


<!DOCTYPE html>
<html>

    <head>
        <title>Sign in to FRIENDS</title>
        <link rel="stylesheet" href="css/index.css">
        <script defer src="js/index.js" ></script>
    </head>

    <body>
        <div class="name">
            <h1>F R I E N D S</h1>
        </div>
        </br>
        <div class="field">
            <div class="form">
                <div class="details">
                    <br/>
                    <h5>
                        <?php if(!$details){echo $msg;}?>
                    </h5>
                </div>
                </br>   
                <form action="index.php" method="POST" id="form">
                    <label>E mail</label>
                    <input type="text" id="email" name="email">
                    <h5 id="h5_email"></h5>
                    <label>Password</label>
                    <input type="text" id="password" name="password">
                    <h5 id="h5_password"></h5>
                    <input type="submit" name="submit" value="Sign in">
                </form>
                </br>
                </br>
                <a href="create_acc.php">Create account</a>
            <div>
        </div>
    </body>

</html>