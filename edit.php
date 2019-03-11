<?php
$message=false;
require_once 'database/connection.php';
$id=(int)$_GET['id'];
if($id===0){
    header('location: user.php');
    exit();
}
if(isset($_POST['update'])){
    $email = strtolower(trim($_POST['email']));
    if (! empty($_FILES['photo']['tmp_name'])) {
        $name = $_FILES['photo']['name'];
        $filename_parts = explode('.', $name);
        $extension = end($filename_parts);
        $new_filename = uniqid('pp_', true).time().'.'.$extension;
        move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/profile_photos/'.$new_filename);
        $photo=$new_filename;
       $query='UPDATE users SET photo=:photo WHERE id=:id';
       $stmt=$connection->prepare($query);
       $stmt->bindParam(':photo',$photo);
       $stmt->bindParam(':id',$id);
       $stmt->execute();
    }
    $query='UPDATE users SET email=:email WHERE id=:id';
    $stmt=$connection->prepare($query);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $message='User Updated';
}
$query = 'SELECT email, photo FROM users WHERE id=:id';
$stmt=$connection->prepare($query);
$stmt->bindParam(':id',$id);
$stmt->execute();
$users=$stmt->fetch();
$photo=!empty($users['photo'])?$users['photo']:false;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php if ($message): ?>
        <div class="alert alert-success">
            <?php echo $message; ?>
        </div>
    <?php endif ; ?>

    <form class="form-signin" action="" method="post" enctype="multipart/form-data">
        <h1 class="h3 mb-3 font-weight-normal">Edit Form</h1>

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" value="<?php echo $users['email']?>" required autofocus>

        <label for="inputPhoto" class="sr-only">Photo</label>
        <input type="file" name="photo" class="form-control">
        <?php if($photo):?>
        <p >
            <img src="uploads/profile_photos/<?php echo $photo?>" alt="photo" width="100">
        </p>
        <?php endif; ?>

        <button class="btn btn-lg btn-primary btn-block" type="submit" name="update">Update</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017-2019</p>
    </form>
</div>
</body>
</html>