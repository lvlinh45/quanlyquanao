<div>
    <h3>Available Sizes</h3>
    <table class="table ">
        <thead>
            <tr>
                <th class="text-center">S.N.</th>
                <th class="text-center">Size</th>
                <th class="text-center">Sex</th>
                <th class="text-center">Weight</th>
                <th class="text-center">Height</th>
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
        $sql = "SELECT * from sizes LIMIT $offset, $rowsPerPage";
        $result = $conn->query($sql);
        $count = 1;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $row["size_name"] ?></td>
                    <td><?= $row["sex"] == 0 ? "Male" : "Female" ?></td>
                    <td><?= $row["weight"] ?></td>
                    <td><?= $row["height"] ?></td>
                    <!-- <td><button class="btn btn-primary" >Edit</button></td> -->
                    <td><button class="btn btn-danger" style="height:40px"
                            onclick="sizeDelete('<?= $row['size_id'] ?>')">Delete</button></td>
                </tr>
                <?php
                $count = $count + 1;
            }
        }
        ?>
    </table>

    <?php
    echo "<div class='pagination'>";
    $re = mysqli_query($conn, 'SELECT * from sizes');
    $numRows = mysqli_num_rows($re);
    $maxPage = ceil($numRows / $rowsPerPage);
    $page = $_POST['page'];

    if ($_POST['page'] > 1) {
        echo '<a href="javascript:void(0);" onclick="showSizes(1)"><<</a>';
        echo '<a href="javascript:void(0);" onclick="showSizes(' . ($page - 1) . ')"><</a>';
    }

    //tạo link tương ứng tới các trang
    for ($i = 1; $i <= $maxPage; $i++) {
        if ($i == $_POST['page']) {
            echo '<b>' . $i . '</b> '; //trang hiện tại sẽ được bôi đậm
        } else
            echo '<a href="javascript:void(0);" onclick="showSizes(' . $i . ')">' . $i . '</a> ';
    }
    //gắn thêm nút Next
    if ($_POST['page'] < $maxPage) {
        echo '<a href="javascript:void(0);" onclick="showSizes(' . ($page + 1) . ')">></a>';
        echo '<a href="javascript:void(0);" onclick="showSizes(' . $maxPage . ')">>></a>';
    }

    echo "</div>";

    ?>

    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-secondary" style="height:40px" data-toggle="modal" data-target="#myModal">
        Add Size
    </button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Size Record</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' action="./controller/addSizeController.php" method="POST">
                        <div class="form-group">
                            <label for="size">Size:</label>
                            <input type="text" class="form-control" name="size" required>
                        </div>
                        <div class="form-group">
                            <label for="sex">Sex:</label>
                            <select class="form-control" name="sex" id="">
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="weight">Weight:</label>
                            <input type="text" class="form-control" name="weight" required>
                        </div>
                        <div class="form-group">
                            <label for="height">Height:</label>
                            <input type="text" class="form-control" name="height" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary" name="upload" style="height:40px">Add
                                Size</button>
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