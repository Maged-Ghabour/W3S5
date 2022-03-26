<?php 
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

    # Valoidate name .... 
    if (!$validator->Validate($this->title, 'required')) {      
        $errors['Title'] = "Field Required";
    }elseif (!$validator->Validate($this->title, 'string')) {      
        $errors['Title'] = "InValid String";
    }

     # Validate  content 
     if (!$validator->Validate($this->content, 'required')) {      
      $errors['content'] = "Field Required";
  }elseif(!$validator->validate($this->content,"length")){
      $errors['content'] = "Length must Be >= 6 Chars";
  }


    # Validate  email 
    if (!$validator->Validate($this->image , 'required')) {      
        $errors['Image'] = "Field Required";
    }elseif(!$validator->validate($this->image ,"image")){
        $errors['Image'] = "Invalid Format";
    }


}
if (count($errors) > 0) {
        
    $Message = $errors;

}




?>