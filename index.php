<?php
session_start();

// Set session timeout duration (e.g., 30 minutes)
$timeout_duration = 1800; // 1800 seconds = 30 minutes

// Check if the last activity timestamp is set and if the session has expired
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    // Destroy the session and redirect to the login page with a session expired flag
    session_unset();
    session_destroy();
    echo "<script>
            alert('Your session has expired. You will be redirected to the login page.');
            window.location.href = 'LogIn.php?session=expired';
          </script>";
    exit();
}

// Update last activity timestamp
$_SESSION['last_activity'] = time();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>

    <div class="content-main">
        <?php
        include "./sidebar.php";
        include_once "./config/dbconnect.php";
        ?>
        <div id="main-content" style="margin-left: 350px;" class="container allContent-section py-4">
            <div class="row">
                <!-- Existing Cards Section -->
                <div class="col-sm-3">
                    <div class="card">
                        <i class="fa fa-users mb-2" style="font-size: 70px;"></i>
                        <h4>Total Users</h4>
                        <h5>
                            <?php
                            $sql = "SELECT * from users";
                            $result = $conn->query($sql);
                            $count = 0;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $count = $count + 1;
                                }
                            }
                            echo $count;
                            ?>
                        </h5>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <i class="fa fa-th-large mb-2" style="font-size: 70px;"></i>
                        <h4>Total Categories</h4>
                        <h5>
                            <?php
                            $sql = "SELECT * from category";
                            $result = $conn->query($sql);
                            $count = 0;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $count = $count + 1;
                                }
                            }
                            echo $count;
                            ?>
                        </h5>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <i class="fa fa-th mb-2" style="font-size: 70px;"></i>
                        <h4>Total Products</h4>
                        <h5>
                            <?php
                            $sql = "SELECT * from product";
                            $result = $conn->query($sql);
                            $count = 0;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $count = $count + 1;
                                }
                            }
                            echo $count;
                            ?>
                        </h5>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <i class="fa fa-list mb-2" style="font-size: 70px;"></i>
                        <h4>Total Orders</h4>
                        <h5>
                            <?php
                            $sql = "SELECT * from orders";
                            $result = $conn->query($sql);
                            $count = 0;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $count = $count + 1;
                                }
                            }
                            echo $count;
                            ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_GET['category']) && $_GET['category'] == "success") {
        echo '<script> alert("Category Successfully Added")</script>';
    } else if (isset($_GET['category']) && $_GET['category'] == "error") {
        echo '<script> alert("Adding Unsuccessful")</script>';
    }
    if (isset($_GET['size']) && $_GET['size'] == "success") {
        echo '<script> alert("Size Successfully Added")</script>';
    } else if (isset($_GET['size']) && $_GET['size'] == "error") {
        echo '<script> alert("Adding Unsuccessful")</script>';
    }
    if (isset($_GET['variation']) && $_GET['variation'] == "success") {
        echo '<script> alert("Variation Successfully Added")</script>';
    } else if (isset($_GET['variation']) && $_GET['variation'] == "error") {
        echo '<script> alert("Adding Unsuccessful")</script>';
    }
    ?>

    <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>
