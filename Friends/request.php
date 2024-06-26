<?php 

    session_start();

    $id = $_SESSION['id'];

    include('db.php');

    // to show request status

    $no_requests = false;

    // accept request and delete request from request table

    if(isset($_POST['accept'])){

        $follower = $_POST['id'];
        $following = $id;
        
        $sql = "INSERT INTO friends (follower, following) VALUES('$follower','$following')";

        if(mysqli_query($conn, $sql)){
            // friend added
        }else{
        }

        $sql = "DELETE FROM requests WHERE from_id = '$follower' AND to_id = '$following'";

        if(mysqli_query($conn, $sql)){
            // request cleared
        }
    }   

    //get an array of requests

    $sql = "SELECT * FROM requests WHERE to_id = '$id' ";
    $result = mysqli_query($conn, $sql);

    // get corresponding user details

    $ids = array();

    foreach($result as $req){
        array_push( $ids , $req['from_id']);
    }

    // an empty array throws errors in sql

    if(empty($ids)){
        $element = 0;
        array_push($ids, $element);
        $no_requests = true;
        
    }else{
    }

    $ids = implode(',',$ids);

    $sql = "SELECT first_name, last_name, email, id FROM account WHERE id IN ($ids)";
    $result = mysqli_query($conn, $sql);
?>

<html>
    <head>
        <title>Friend requests</title>
        <link rel="stylesheet" href="css/request.css">
    </head>
    <body>
        <div class="top">
            <div class = "list">
                <ul>
                    <li>
                        <h2>Requests</h2>
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
        <div class="friends">
            </br>
            <div>
                <?php  if($no_requests){ ?>
                    <h4>No requests<h4>
                <?php }?>
            </div>
                <?php foreach($result as $request) : ?>
                    </br>
                    <div class="friend">
                        <form action="request.php" method="POST">
                            <h3><?php echo $request['first_name'] . " " . $request['last_name']  ?></h3>
                            <input type="hidden" name="id" value="<?php echo $request['id']?>">
                            <input type="submit" name="accept" value="accept">
                        </form>
                    </div>
                <?php endforeach; ?>
        </div>
    </body>
</html>
