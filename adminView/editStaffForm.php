<div class="container p-5">

    <h4>Edit Staff Detail</h4>
    <?php
  include_once "../config/dbconnect.php";
  $ID = $_POST['record'];
  $qry = mysqli_query($conn, "SELECT * FROM staff WHERE staff_id ='$ID'");
  $numberOfRow = mysqli_num_rows($qry);
  if ($numberOfRow > 0) {
    while ($row1 = mysqli_fetch_array($qry)) {
      ?>
    <form id="update-Items" onsubmit="return updateStaff()" enctype='multipart/form-data' method="POST">
        <div class="form-group">
            <input type="text" class="form-control" id="staff_id" value="<?= $row1['staff_id'] ?>" hidden>
        </div>
        <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" class="form-control" id="firstName" value="<?= $row1['firstName'] ?>">
        </div>
        <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" class="form-control" id="lastName" value="<?= $row1['lastName'] ?>">
        </div>
        <div class="form-group">
            <label for="sex">Sex:</label>
            <select class="form-control" name="sex" id="sex">
                <option value="0" <?php echo ($row1['sex'] == 0) ? 'selected' : null; ?>>Male</option>
                <option value="1" <?php echo ($row1['sex'] == 1) ? 'selected' : null; ?>>Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" value="<?= $row1['staff_address'] ?>">
        </div>
        <div class="form-group">
            <label for="contact">Phone Number:</label>
            <input type="number" class="form-control" id="contact" value="<?= $row1['contact_no'] ?>">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" value="<?= $row1['email'] ?>">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" value="<?= $row1['password'] ?>">
        </div>
        <div class="form-group">
            <label for="registerAt">Register At:</label>
            <input type="date" class="form-control" id="registerAt" value="<?= $row1['register_at'] ?>">
        </div>
        <div class="form-group">
            <img width='200px' height='150px' src='<?= $row1["avatar"] ?>'>
            <div>
                <label for="file">Choose Image:</label>
                <input type="text" id="existingImage" class="form-control" value="<?= $row1['avatar'] ?>" hidden>
                <input type="file" id="newImage" value="">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" style="height:40px" class="btn btn-primary">Update Item</button>
        </div>
        <?php
    }
  }
  ?>
    </form>

</div>