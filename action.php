<?php
  session_start();
  require 'DBClass.php';


  

      
  $updated   = false;
      $id    = "";
      $title  =  "";
      $content = "";
      $image = "";




    if(isset($_POST["add"])){

    
      $title = $_POST["title"];
      $content = $_POST["content"];
      
      
       $imgName = $_FILES["image"]["name"];
       $imgTmp = $_FILES["image"]["tmp_name"];
       $imgType = $_FILES["image"]["type"];

         # Validate ...... 

   

    

       $dis = "uploads/".$imgName;


       if(move_uploaded_file($imgTmp,$dis)){
         echo "Uploaded";
       }else{
         echo " There is an Error";
       }


    $stmt = $con->prepare("INSERT INTO crud (title, content, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content,$dis);
    $stmt->execute();
    $stmt->close();
    $con->close();
    header("location:index.php");
    $_SESSION["response"] = "Successfully Inserted to database!";
    $_SESSION["res_type"] = "success";

    }
    if(isset($_GET["delete"])){
      $id = $_GET["delete"];

      // Delete Image From Folder uploads
      $stmt2 = $con->prepare("SELECT image FROM crud WHERE id = ? ");
      $stmt2->bind_param("i",$id);
      $stmt2->execute();
      $result2 = $stmt2->get_result();
      $row = $result2->fetch_assoc();
      $imagePath = $row["photo"];
      unlink($imagePath);

     
     

      // Delete From Database 
      $stmt = $con->prepare("DELETE FROM crud WHERE id = ? ");
      $stmt -> bind_param("i",$id);
      $stmt->execute();
    
      header("location:index.php");
      $_SESSION["response"] = "Successfully Deleted to database!";
      $_SESSION["res_type"] = "danger";
  

    }
    if(isset($_GET["edit"])){

      $id = $_GET["edit"];

      $stmt = $con->prepare("SELECT * FROM  crud WHERE id= ?");
      $stmt -> bind_param("i",$id);
      $stmt ->execute();
      $result = $stmt->get_result();
      $row = $result -> fetch_assoc();

      $id = $row["id"];
      $title = $row["title"];
      $content = $row["content"];
      $image = $row["image"];

      $updated = true;
    }

    if(isset($_POST["update"])){
      $id = $_POST["id"];
      $title = $_POST["title"];
      $content = $_POST["content"];
      $image = $_POST["image"];
      $oldImage = $_POST["oldImage"];
      
      if(isset( $_FILES["image"]["name"]) && ($_FILES["image"]["name"] != "")){

        $newImage = "uploads/".$_FILES["image"]["name"];
        unlink($oldImage);
        move_uploaded_file($_FILES["image"]["tmp_name"], $newImage);
      }else{
        $newImage = $oldImage;
      }

      $query = "UPDATE crud SET title = ?,content = ? , image = ?  Where id = ?";

      $stmt = $con->prepare($query);
      $stmt->bind_param("sssi",$title,$content,$newImage,$id);
      $stmt->execute();

      $_SEESSION["respone"] ="Updated Successfully..!";
      $_SEESSION["res_type"] ="primary";
      header("location:index.php");


    }
  
  

  
    
?>