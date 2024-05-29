<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Welcome to Codeium</title>
</head>

<body>
    <?php include "partials/_dbconnect.php";?>
    <?php include "partials/_header.php";?>
    
    <?php 
        $id= $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];

            $thread_user_id = $row['thread_user_id'];
            $sql2="SELECT user_email FROM `user_table` WHERE sno='$thread_user_id'";
            $result2 = mysqli_query($conn,$sql2);
            $row2= mysqli_fetch_assoc($result2);
            $posted_by = $row2['user_email'];
        }
    ?>

    <?php

        $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if($method=='POST'){
            $comment = $_POST['comment'];
            
            //code that handles potential XSS attack 
            $comment = str_replace("<", "&lt", "$comment");
            $comment = str_replace(">", "&gt;", "$comment");

            $sno = $_POST['sno'];
            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`,`comment_by`, `comment_time`) VALUES ('$comment', '$id','$sno',current_timestamp())";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;
            if($showAlert){
                echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Comment added sucessfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }
        }

    ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title;?></h1>
            <p class="lead"><?php echo $desc;?> </p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge with each other.</p>
            <p>Posted by: <em><?php echo $posted_by; ?></em></p>
        </div>
    </div>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo'<div class="container">
        <h1>Post a Comment</h1>
        <form action ="' .$_SERVER["REQUEST_URI"]. '"method="post">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type your Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION["Sno"].'">
            </div>
            <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>
        </div>';
    }
    else{
        echo'
        <div class="container">
        <h1>Post a Comment</h1>
        <p class="lead">You are not logged in. Please log in to be able to post comments.</p>
        </div>';
    }
    ?>
    <div class="container my-4">
        <h1>Discussions</h1>
         <?php 
        $id= $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id =$id";
        $result = mysqli_query($conn,$sql);

        // this code dynamically shows comments posted by a user.
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $thread_user_id = $row['comment_by'];
            $sql2="SELECT user_email FROM `user_table` WHERE Sno=$thread_user_id";
            $result2 = mysqli_query($conn,$sql2);
            $row2= mysqli_fetch_assoc($result2); 
            echo '<div class="media my-3">
            <img src="user-profile.jpg" class="mr-3" alt="..." width="50px" height="50px">
            <div class="media-body">
                <p class="font-weight-bold my-0">'.$row2['user_email'].' at '. $comment_time.'</p>
                '. $content .'
            </div>
            </div>';
    }
    ?>

    <?php include "partials/_footer.php";?>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
        </script>
</body>

</html>