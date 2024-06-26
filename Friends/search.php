<?php 

    session_start();
    $id = $_SESSION['id'];
    $friend_list = $_SESSION['friend_list'];

    include('db.php');

    // search friends
    
    if(isset($_POST['search'])){

        $first_name = $_POST['search_name'].'%';
        $last_name = $_POST['search_name'].'%';

        $sql = "SELECT * FROM account WHERE (email != '$email') AND (first_name LIKE '$first_name' OR last_name LIKE '$last_name')AND id NOT IN ($friend_list)";
        $result = mysqli_query($conn, $sql);
        
    }else{
        $sql = "SELECT * FROM account WHERE id != '$id' AND id NOT IN ($friend_list)" ;
        $result = mysqli_query($conn, $sql);
    }

    //to use when sending requests

    $msg ="Send request";

    //process requests

    if(isset($_POST['add'])){
        $from = $_POST['from'];
        $to = $_POST['to'];

        $sql = "SELECT COUNT(*)  AS count FROM requests WHERE from_id = '$id' AND to_id ='$to' ";
        $result2 = mysqli_query($conn, $sql);
        $count = mysqli_fetch_assoc($result2);
          

        if($count['count'] == 0){
            $sql = "INSERT INTO requests (from_id, to_id) VALUES('$id', '$to')";

            if(mysqli_query($conn, $sql)){
        
            }else{
                echo 'insert query error'.mysqli_error($conn);
            }
        }else{
            // already requested
        }   
    }

    // to show request info

    $already = array();

    $sql = "SELECT to_id FROM requests WHERE from_id = '$id' " ;
        $result3 = mysqli_query($conn, $sql);
        
        foreach($result3 as $i){

            $item = $i['to_id'];
            array_push($already, $item);
        }   
?>

<html>
    <head>
        <title>Add friends</title>
        <link rel="stylesheet" href="css/search.css">
    </head>
    <body>
        <section class="top">
            <div class="list">
                <ul>
                    <li>
                        <div class= "search">
                            <form action="search.php" method="POST">
                                <ul>
                                    <li>
                                        <label><h2>Search friend </h2></label>
                                    </li>
                                    <li >
                                        <input id ="search_bar" type="text" name ="search_name">
                                    </li>
                                    <li >
                                        <input id="search_btn" type="submit" name="search" value="SEARCH">
                                    </li>               
                                </ul>
                            </from>
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
        </section>
        <section class="friends">
            <?php foreach($result as $friend) : ?>
                <div class="friend">
                    <h3>
                        <?php echo $friend['first_name'] . " " . $friend['last_name'] ?>
                    </h3>
                    <div>
                        <?php 
                            if(in_array($friend['id'], $already)){
                                $msg = 'Request sent';
                            }
                        ?>
                    </div>
                    <form action="search.php" method="POST">
                        <input type="hidden" name="from" value="<?php echo $email ?> ">
                        <input type="hidden" name="to" value="<?php echo $friend['id'] ?>">
                        <input type="submit" name="add" value="<?php echo $msg ?>">
                    </form>
                </div>
                <br/>
                <br/> 
                <?php  $msg= "Send request" ?>
            <?php endforeach;?>
        </section>
    </body>
</html>