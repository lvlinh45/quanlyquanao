<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<div>


    <?php
    include_once "../config/dbconnect.php";

    $search = ""; // Biến lưu giá trị tìm kiếm
    if (isset($_POST["btnSearch"])) {
        $search = $_POST["search"];
    }

    $rowsPerPage = 5;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $offset = ($page - 1) * $rowsPerPage;

    // Điều chỉnh câu truy vấn SQL để hỗ trợ tìm kiếm
    $sql = "SELECT * FROM product 
            JOIN category ON product.category_id = category.category_id";

    if ($search != "") {
        $sql .= " WHERE product_name LIKE '%$search%'";
    }

    $sql .= " LIMIT $offset, $rowsPerPage";
    $result = $conn->query($sql);
    ?>

    <h2>Product Items</h2>

    <table class="table">
        <thead>
            <tr>
                <th class="text-center">S.N.</th>
                <th class="text-center">Product Image</th>
                <th class="text-center">Product Name</th>
                <th class="text-center">Color</th>
                <th class="text-center">Product Description</th>
                <th class="text-center">Category Name</th>
                <th class="text-center">Unit Price</th>
                <th class="text-center" colspan="2">Action</th>
            </tr>
        </thead>
        <?php
        $count = $offset + 1;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><img height='100px' src='<?= $row["product_image"] ?>'></td>
                    <td><?= $row["product_name"] ?></td>
                    <td><?= $row["color"] ?></td>
                    <td><?= $row["product_desc"] ?></td>
                    <td><?= $row["category_name"] ?></td>
                    <td><?= $row["price"] ?></td>
                    <td><button class="btn btn-primary" style="height:40px"
                            onclick="itemEditForm('<?= $row['product_id'] ?>')">Edit</button></td>
                    <td><button class="btn btn-danger" style="height:40px"
                            onclick="itemDelete('<?= $row['product_id'] ?>')">Delete</button></td>
                </tr>
                <?php
                $count++;
            }
        } else {
            echo "<tr><td colspan='8' class='text-center'>No products found</td></tr>";
        }
        ?>
    </table>

    <?php
    // Điều chỉnh phân trang để tính toán đúng với điều kiện tìm kiếm
    $countSql = "SELECT COUNT(*) as total FROM product 
                 JOIN category ON product.category_id = category.category_id";

    if ($search != "") {
        $countSql .= " WHERE product_name LIKE '%$search%'";
    }

    $countResult = mysqli_query($conn, $countSql);
    $row = mysqli_fetch_assoc($countResult);
    $numRows = $row['total'];
    $maxPage = ceil($numRows / $rowsPerPage);

    // Tạo phân trang
    echo "<div class='pagination'>";

    if ($page > 1) {
        echo '<a href="javascript:void(0);" onclick="showProductItems(1)"><<</a>';
        echo '<a href="javascript:void(0);" onclick="showProductItems(' . ($page - 1) . ')"><</a>';
    }

    for ($i = 1; $i <= $maxPage; $i++) {
        if ($i == $page) {
            echo '<b>' . $i . '</b> ';
        } else {
            echo '<a href="javascript:void(0);" onclick="showProductItems(' . $i . ')">' . $i . '</a> ';
        }
    }

    if ($page < $maxPage) {
        echo '<a href="javascript:void(0);" onclick="showProductItems(' . ($page + 1) . ')">></a>';
        echo '<a href="javascript:void(0);" onclick="showProductItems(' . $maxPage . ')">>></a>';
    }
    echo "</div>";
    ?>

    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-secondary " style="height:40px" data-toggle="modal" data-target="#myModal">
        Add Product
    </button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Product Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' onsubmit="addItems()" method="POST">
                        <div class="form-group">
                            <label for="name">Product Name:</label>
                            <input type="text" class="form-control" id="p_name" required>
                        </div>
                        <div class="form-group">
                            <label for="color">Color:</label>
                            <input type="text" class="form-control" id="p_color" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" class="form-control" id="p_price" required>
                        </div>
                        <div class="form-group">
                            <label for="qty">Description:</label>
                            <textarea class="form-control" id="p_desc" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Category:</label>
                            <select id="category">
                                <option disabled selected>Select category</option>
                                <?php

                                $sql = "SELECT * from category";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['category_id'] . "'>" . $row['category_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file">Choose Image:</label>
                            <input type="file" divss="form-control-file" id="file">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary" id="upload" style="height:40px">Add
                                Item</button>
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