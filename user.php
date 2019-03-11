<?php

    require_once 'database/connection.php';
    $query='SELECT id, email, photo FROM users';
    $stmt = $connection->query($query);
    $stmt->execute();
    $user=$stmt->fetchAll();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <table class="table table-hover table-dark table-bordered">
                <thead >
                    <tr class="text-center">
                        <td>Serial No</td>
                        <td>User ID</td>
                        <td>Email</td>
                        <td>Photo</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1;?>
                <?php foreach ($user as $users):?>
                <tr>
                    <td class="text-center"><?php echo $i++?></td>
                    <td class="text-center"><?php echo $users['id']?></td>
                    <td><?php echo $users['email']?></td>
                    <td>
                        <img src="uploads/profile_photos/<?php echo $users['photo'];?>" alt="<?php echo $users['email']?>" width="150">
                    </td>
                    <td>
                        <a href="delete.php?id=<?php echo $users['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        <a href="edit.php?id=<?php echo $users['id']?>" class="btn btn-sm btn-info">Edit</a>
                    </td>
                    
                </tr>
                <?php endforeach;?>
                </tbody>

            </table>
        </div>
    </div>
</body>
</html>