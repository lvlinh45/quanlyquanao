<div class="sidebar" id="mySidebar"
    style="border-right: 1px solid rgba(0, 0, 0, 0.1); box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);">
    <div class="side-header">
        <?php
        if (isset($_SESSION['login'])) {
            $user = $_SESSION['login'];
            // Kiểm tra nếu có avatar trong thông tin user
            if (!empty($user['avatar'])) {
                echo '<img src="' . $user['avatar'] . '" width="120" height="120" alt="User avatar">';
            } else {
                echo '<img src="./assets/images/default-avatar.png" width="120" height="120" alt="Default avatar">';
            }
        } else {
            echo '<img src="./assets/images/logo.png" width="120" height="120" alt="Default avatar">';
        }
        ?>
        <h5 style="margin-top:10px; color: #000; font-weight: bold;">Hello,
            <?php
            // Start session only if it hasn't already been started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Check if the user is logged in
            if (isset($_SESSION['login'])) {
                // Retrieve data from session
                $user = $_SESSION['login'];
                $username = $user['firstName'];

                // Display user information
                echo htmlspecialchars($username);
            } else {
                echo "Bạn chưa đăng nhập.";
            }
            ?>
        </h5>
    </div>

    <hr style="border:1px solid #000; background-color:#fff;">
    <a href="./index.php"><i class="fa fa-home"></i> Dashboard</a>
    <a href="#customers" onclick="showCustomers()"><i class="fa fa-users"></i> Customers</a>
    <a href="#staff" onclick="showStaff()"><i class="fa fa-users"></i> Staff</a>
    <a href="#category" onclick="showCategory()"><i class="fa fa-th-large"></i> Category</a>
    <a href="#sizes" onclick="showSizes()"><i class="fa fa-th"></i> Sizes</a>
    <a href="#productsizes" onclick="showProductSizes()"><i class="fa fa-th-list"></i> Product Sizes</a>
    <a href="#products" onclick="showProductItems()"><i class="fa fa-th"></i> Products</a>
    <a href="#orders" onclick="showOrders()"><i class="fa fa-list"></i> Orders</a>
    <a href="#logout" onclick="showLogOut()"><i class="fa fa-sign-out"></i> Log Out</a>
</div>