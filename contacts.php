<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Welcome to iDiscuss - Coding Forums</title>
    <style>
    .container {
        min-height: 87vh;
    }
    </style>
</head>

<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>

    <?php

        
$showAlert = false;
$method = $_SERVER['REQUEST_METHOD'];
if($method=='POST'){

    //code to post discussion posted by user
    $email = $_POST['email'];
    $concern = $_POST['description'];

    $sql = "INSERT INTO `concern` (`email`, `concern_desc`) VALUES ('$email', '$concern');";
    $result = mysqli_query($conn,$sql);
    $showAlert = true;
    if($showAlert){
        echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your concern has been submitted successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
}

?>



    <div class="container my-3">
        <h1 class="text-center">Contact Us</h1>
        <form action="contacts.php" method="post">
            <div class="form-group">
                <label for="exampleFormControlInput1">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleFormControlInput1">
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Please enter your concern</label>
                <textarea type="text" class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>

            <button class="btn btn-success">Submit</button>
        </form>

    </div>
    <?php include 'partials/_footer.php';?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>