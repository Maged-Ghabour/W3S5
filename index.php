<?php

  require 'DBClass.php';
  require "action.php";
  


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD PHP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>


          <!-- Start NavBar -->
    
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  
  <div class="container-fluid">
    <a class="navbar-brand" href="#">CRUD App</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-primary bg-primary" type="submit">Search</button>
      </form>
      
    </div>
  </div>


  </nav>


<div class="container-fluid">
<h4 class="text-center m-1 text-secondary"> CRUD App (using php oop)</h4>
  <hr>
  <?php if(isset($_SESSION["response"])){ ?>
  <div class="alert alert-<?= $_SESSION["res_type"];?> alert-dismissible text-center w-50 mb-3 ms-auto me-auto">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <?php echo $_SESSION["response"];?>
  </div>
<?php } unset($_SESSION["response"]);?>


</div>

 

   <!-- End  NavBar  -->



   <!-- Start Form -->

<div class="container-fluid row">
<div class="col-4">

   <form class="g-3 ms-2" action="action.php" method="post" enctype="multipart/form-data"> 

 

    <h4 class="text-info text-center"> Add Recored </h4>
      <input type="hidden" name="id" value="<?=$id;?>" >
      <div class="col-12">
        <label for="title" class="form-label">title</label>
        <input type="text"  id="title" class="form-control" value="<?=$title;?>"  name="title" placeholder="title">
      </div>
     
    <div class="col-12">
      <label for="content" class="form-label">content</label>
      <input type="text" id="email" class="form-control" value="<?=$content;?>"  name="content" placeholder="content">
    </div>
   
   

    <div class="col-12">
     <input type="hidden" name="oldImage" value="<?=$image?>">

      <label for="image" class="form-label"> Image </label>
      <input class="form-control" id="image" type="file" name="image"  placeholder="Upload Image">
      <img src="<?=$image;?>" width="120" class="image-thumbnail">
    </div>
   
    

    <?php if($updated == true ){ ?>
      <div class="col-12">
        
      <button type="submit" name="update" class="btn btn-success mt-3 col-12">Update Record</button>
      </div>
  <?php  } else {?>
    <div class="col-12">
      <button type="submit" name="add" class="btn btn-primary mt-3 col-12">Add Record</button>
    </div>
  <?php  } ?>
  </form>
</div>

<div class="col-8">
  
<?php

$stmt = $con->prepare("SELECT * FROM crud");
$stmt->execute();
$result = $stmt->get_result(); 



?>

  <h4 class="text-info text-center">  Recored Database</h4>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Content</th> 
          <th scope="col">Image</th>
        </tr>
      </thead>
      <tbody">
      <?php while($row = $result->fetch_assoc()){ ?>

        <tr>
          <th scope="row"><?php echo $row["id"];?></th>
          <td><?php echo $row["title"];?></td>
          <td><?php echo $row["content"];?></td>
        
          <td><img src= "<?= $row['image']; ?>" width="50" height="50" </td>
          <td>
    
            <a class="btn btn-danger" onclick="return confirm('Do You Sure You Want to Delete this record ?!')" href="action.php?delete=<?php echo $row["id"]?>" role="button">Delete</a>
            <a class="btn btn-success" href="index.php?edit=<?php echo $row["id"]?>" role="button">Edit</a>

          </td>
        </tr>
      <?php } ?>
      </tbody>
    </table>

  </div>
</div>
   <!-- End   Form -->
   

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>