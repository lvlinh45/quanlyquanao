<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<div>
    <h2>All Staffs</h2>
    <table class="table">
        <thead>
            <tr>
                <th class="text-center">S.N.</th>
                <th class="text-center">Avatar</th>
                <th class="text-center">FullName</th>
                <th class="text-center">sex</th>
                <th class="text-center">Address</th>
                <th class="text-center">Phone Number</th>
                <th class="text-center">Email</th>
                <th class="text-center">Password</th>
                <th class="text-center">Register At</th>
                <th class="text-center" colspan="2">Action</th>
            </tr>
        </thead>
        <?php
    include_once "../config/dbconnect.php";

    $rowsPerPage = 5; 
    if (!isset($_POST['page'])) {
        $_POST['page'] = 1;
    }
    $offset = ($_POST['page'] - 1) * $rowsPerPage;

    $sql = "SELECT * from staff LIMIT $offset, $rowsPerPage  ";
    $result = $conn->query($sql);
    $count = 1;
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?= $count ?></td>
            <td><img height='100px' src='<?= $row["avatar"] ?>'></td>
            <td><?= $row["lastName"] . " " . $row["firstName"] ?></td>
            <td><?= $row["sex"] == 0 ? "Male" : "Female" ?></td>
            <td><?= $row["staff_address"] ?></td>
            <td><?= $row["contact_no"] ?></td>
            <td><?= $row["email"] ?></td>
            <td><?= $row["password"] ?></td>
            <td><?= $row["register_at"] ?></td>
            <td><button class="btn btn-primary" style="height:40px"
                    onclick="StaffEditForm('<?= $row['staff_id'] ?>')">Edit</button></td>
            <td><button class="btn btn-danger" style="height:40px"
                    onclick="StaffDelete('<?= $row['staff_id'] ?>')">Delete</button></td>
        </tr>
        <?php
        $count = $count + 1;
      }
    }
    ?>
    </table>

    <?php 
        echo "<div class='pagination'>"; 
            $re = mysqli_query($conn, 'SELECT * from staff');
            $numRows = mysqli_num_rows($re);
            $maxPage = ($numRows > 0) ? floor($numRows / $rowsPerPage) + 1 : 0;  
            $page = $_POST['page'];

            if ($_POST['page'] > 1)
            { 
                echo '<a href="javascript:void(0);" onclick="showStaff(1)"><<</a>';
                echo '<a href="javascript:void(0);" onclick="showStaff(' . ($page - 1) . ')"><</a>';
            }

            //tạo link tương ứng tới các trang
            for ($i = 1; $i <= $maxPage; $i++) {
                if ($i == $_POST['page']) {
                    echo '<b>' . $i . '</b> '; //trang hiện tại sẽ được bôi đậm
                } else
                    echo '<a href="javascript:void(0);" onclick="showStaff(' . $i . ')">' . $i . '</a> ';
            }
            //gắn thêm nút Next
            if ($_POST['page'] < $maxPage)
            { 
                echo '<a href="javascript:void(0);" onclick="showStaff(' . ($page + 1) . ')">></a>';
                echo '<a href="javascript:void(0);" onclick="showStaff(' . $maxPage . ')">>></a>';
            }

            echo "</div>";

        ?>


    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-secondary " style="height:40px" data-toggle="modal" data-target="#myModal">
        Add Staff
    </button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Staff Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' onsubmit="addStaffs()" method="POST">
                    <div class="form-group">
                            <label for="firstName">First Name:</label>
                            <input type="text" class="form-control" id="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name:</label>
                            <input type="text" class="form-control" id="lastName" required>
                        </div>
                        <div class="form-group">
                            <label for="sex">Sex:</label>
                            <select class="form-control" name="sex" id="sex">
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" id="address" required>
                        </div>
                        <div class="form-group">
                            <label for="contact">Phone Number:</label>
                            <input type="text" class="form-control" id="contact" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <!-- <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" required>
                        </div> -->
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()">
                                    <i class="fa fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>
                    </div>


                        <div class="form-group">
                            <label for="registerAt">Register At:</label>
                            <input type="date" class="form-control" id="registerAt" required>
                        </div>
                        <div class="form-group">
                            <label for="file">Choose Image:</label>
                            <input type="file" divss="form-control-file" id="file">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary" id="upload" style="height:40px">Add
                                Staff</button>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                        style="height:40px">Close</button>
                </div>
            </div>
            
        </div>
    </div>


</div>


<script type="text/javascript" src="./assets/js/ajaxWork.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
