<?php
    include_once "../config/dbconnect.php";
    
    if(isset($_POST['upload']))
    {
       
        $size = $_POST['size'];
        $sex = $_POST['sex'];
        $weight = $_POST['weight'];
        $height = $_POST['height'];
       
        $insert = mysqli_query($conn, "INSERT INTO sizes (size_name, sex, weight, height) 
        VALUES ('$size', '$sex', '$weight', '$height')");
 
         if(!$insert)
         {
             echo mysqli_error($conn);
             header("Location: ../index.php?size=error");
         }
         else
         {
             echo "Records added successfully.";
             header("Location: ../index.php?size=success");
         }
     
    }
        
?>