<?php 

 session_start();
  require 'DBClass.php';
  require 'validatorClass.php';

class User{

   private $title; 
   private $content; 
   private $image; 


   public function Register($data){

       # Create Validator Class .... 
       $validator = new Validator();
      
       $this->title     = $validator->Clean($data['title']);
       $this->content    = $validator->Clean($data['content']);
       $this->image = $validator->Clean($data['image']);


       # Validate Data .... 
        $errors = []; 

    # Valoidate title .... 
    if (!$validator->Validate($this->title, 'required')) {      
        $errors['Title'] = "Field Required";
    }elseif (!$validator->Validate($this->title, 'string')) {      
        $errors['Title'] = "InValid String";
    }


     # Validate  Content 
     if (!$validator->Validate($this->content, 'required')) {      
      $errors['content'] = "Field Required";
  }elseif(!$validator->validate($this->content,"length")){
      $errors['content'] = "Length must Be >= 50 Chars";
  }


    # Validate  Image 
    if (!$validator->Validate($this->image , 'required')) {      
        $errors['image'] = "Field Required";
    }elseif(!$validator->validate($this->image ,"image")){
        $errors['image'] = "Invalid Format";
    }


    


     # Check ...... 
     if (count($errors) > 0) {
        
        $Message = $errors;

    } else {

$db = new DB();
       
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

   $dis = "uploads/".$imgName;


   if(move_uploaded_file($imgTmp,$dis)){
     echo "Uploaded";
   }else{
     echo " There is an Error";
   }


$stmt = $con->prepare("INSERT INTO crud (title, content , image) VALUES (?, ?, ?)");
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
  $imagePath = $row["image"];
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
  $name = $row["title"];
  $email = $row["content"];
  $image = $row["image"];

  $updated = true;
}

if(isset($_POST["update"])){
  $id = $_POST["id"];
  $title = $_POST["title"];
  $conent = $_POST["content"];
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
  $stmt->bind_param("sssi",$title,$conent,$newImage,$id);
  $stmt->execute();

  $_SEESSION["respone"] ="Updated Successfully..!";
  $_SEESSION["res_type"] ="primary";
  header("location:index.php");


}
  
       
  
     }
     
          return $Message;
  }
  
  }
  

 
?>