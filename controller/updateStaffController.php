<?php
include_once "../config/dbconnect.php";

$staff_id = $_POST['staff_id'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$sex = $_POST['sex'];
$address = $_POST['address'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$password = $_POST['password'];
$registerAt = $_POST['registerAt'];

if (isset($_FILES['newImage'])) {

    $location = "./assets/images/";
    $img = $_FILES['newImage']['name'];
    $tmp = $_FILES['newImage']['tmp_name'];
    $dir = '../assets/images/';
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'webp');
    $image = rand(1000, 1000000) . "." . $ext;
    $final_image = $location . $image;
    if (in_array($ext, $valid_extensions)) {
        move_uploaded_file($tmp, $dir . $image);

    }
} else {
    $final_image = $_POST['existingImage'];
}
$updateItem = mysqli_query($conn, "UPDATE staff SET 
        firstName='$firstName', 
        lastName='$lastName', 
        sex='$sex', 
        staff_address='$address',
        contact_no='$contact',
        email='$email',
        password='$password',
        register_at='$registerAt',
        avatar='$final_image' 
        WHERE staff_id=$staff_id");


if ($updateItem) {
    echo "true";
}
// else
// {
//     echo mysqli_error($conn);
// }
?>