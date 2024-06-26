<?php 

    include('db.php');

    session_start();

    $email;
    $msg = "";

    if(isset($_POST['submit'])){

        // check if an account exist with email

        $email = $_POST['email'];

        $sql = "SELECT COUNT(*) AS count FROM account WHERE email = '$email'";
        $result = mysqli_query($conn, $sql );
        $count = mysqli_fetch_assoc($result);
 
        if($count['count'] == 0){

            //if dont already exist
 
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
            $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
 
            $sql = "INSERT INTO account (email, first_name, last_name, password) VALUES('$email', '$first_name', '$last_name', '$password')";
         
            if(mysqli_query($conn, $sql)){
             //echo 'account created';
            }else{
                echo 'insert query error'.mysqli_error($conn);
            }
 
            //get user id
 
            $sql = "SELECT * FROM account WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $result_id = mysqli_fetch_assoc($result);
            $id = $result_id['id'];
            $_SESSION['id'] = $id;
 
            header('Location:profile.php');
 
        }else{
            $msg = "An account already exists with this E mail";
        }
    }
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Create FRIENDS account</title>
        <link rel="stylesheet" href="css/create_account.css">
        <script defer src="js/create_acc.js" ></script>
    </head>

    <body>
        <div class="name">
            <h1>F R I E N D S</h1>
        </div>
        <br />

        <div class="field">
            <br/>
            <div class="msg">
                <h5>
                    <?php echo $msg ?>
                </h5>
            </div>
            <div class="form">
                <form action="create_acc.php" method="POST" id="form">
                    <label>First name</label>
                    <input type="text" name="first_name" id="first_name">
                    <h5 id="h5_first_name"></h5>
                    <label>Last name</label>
                    <input type="text" name="last_name" id="last_name">
                    <h5 id="h5_last_name"></h5>
                    <label>E mail</label>
                    <input type="text" name="email" id ="email">
                    <h5 id="h5_email"></h5>
                    <label>Password</label>
                    <input type="text" name="password" id="password">
                    <h5 id="h5_password"></h5>
                    <label>Confirm password</label>
                    <input type="text" name="password" id="confirm" autocomplete="off">
                    <h5 id="h5_confirm"></h5>
                    <input type="submit" name="submit" value="Create account">
                </form>
            </div>
        </div>
    </body>
</html>