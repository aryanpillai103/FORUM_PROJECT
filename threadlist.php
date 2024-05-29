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
<style>
    /* .ques{
        min-height: 100vh;
    } */
</style>
</head>

<body>
    <?php include "partials/_dbconnect.php";?>
    <?php include "partials/_header.php";?>
    
    <?php 
        $id= $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE category_id=$id";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];
        }
    ?>

    <?php

        
        $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if($method=='POST'){
            $th_title = $_POST['title'];
            $th_desc = $_POST['desc'];
        
            //code that handles potential XSS attack 
            $th_title = str_replace("<", "&lt", "$th_title");
            $th_title = str_replace(">", "&gt;", "$th_title");

            $th_desc = str_replace("<", "&lt", "$th_desc");
            $th_desc = str_replace(">", "&gt;", "$th_desc");

            //code to post discussion posted by user
            $sno = $_POST['sno'];
            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_category_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;
            if($showAlert){
                echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Discussion has been added successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }
        }

    ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname;?> forums</h1>
            <p class="lead"><?php echo $catdesc;?> </p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge with each other.</p>
            <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo'<div class="container">
        <h1>Start a Discussion</h1>
        <form action ="' .$_SERVER["REQUEST_URI"]. '" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Problem Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
        <small id="emailHelp" class="form-text text-muted"> Keep your title as short and crisp as
            possible.</small>
    </div>
    <input type="hidden" name="sno" value="'.$_SESSION["Sno"].'">
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Elaborate your Concern</label>
        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div> ';
    }
    else{
        echo'
        <div class="container">
        <h1>Start a Discussion</h1>
        <p class="lead">You are not logged in. Please log in to be able to start a discussion.</p>
        </div>';
    }
    ?>

    <!-- code that list discussion on main page -->
    <div class="container my-4">
        <h1>Discussions</h1>
        <?php 
        $id= $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_category_id =$id";
        $result = mysqli_query($conn,$sql);
        $noResult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noResult=false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time=$row['timestamp'];
            $thread_user_id = $row['thread_user_id'];
            $sql2="SELECT user_email FROM `user_table` WHERE Sno=$thread_user_id";
            $result2 = mysqli_query($conn,$sql2);
            $row2= mysqli_fetch_assoc($result2);

            echo '<div class="media my-3">
            <img src="user-profile.jpg" class="mr-3" alt="..." width="50px" height="50px">
            <div class="media-body">'.
                '<h5 class="mt-0"> <a class="text-dark "href="thread.php?threadid='.$id.'">'. $title .'</a></h5>
                '. $desc .' </div>'.'<div class="font-weight-bold my-0">Asked by: '.$row2['user_email'].' at '.$thread_time .
            '</div>'.
            '</div>';
        }
        
        if($noResult){
            echo'<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-4">No Question Found</h1>
              <p class="lead">Be the first person to ask questions</p>
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