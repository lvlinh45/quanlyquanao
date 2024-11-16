<?php
    include_once "../config/dbconnect.php";
    
    if(isset($_POST['upload']))
    {
        $firstName= $_POST['firstName'];
        $lastName= $_POST['lastName'];
        $sex= $_POST['sex'];
        $address= $_POST['address'];
        $contact= $_POST['contact'];
        $email= $_POST['email'];
        $password= $_POST['password'];
        $registerAt= $_POST['registerAt'];
       
            
        $name = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
    
        $location="./assets/images/";
        $image=$location.$name;

        $target_dir="../assets/images/";
        $finalImage=$target_dir.$name;

        move_uploaded_file($temp, $finalImage);

         $insert = mysqli_query($conn,"INSERT INTO staff
         (firstName,lastName,sex,staff_address,contact_no, email, password, register_at, avatar) 
         VALUES ('$firstName','$lastName', $sex, '$address','$contact','$email', '$password', '$registerAt', '$image')");
 
         if(!$insert)
         {
             echo mysqli_error($conn);
         }
         else
         {
            echo "Records added successfully.";
         }
     
    }
        
?>