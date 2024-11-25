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
                echo "You must be login";
            }
            ?>
        </h5>
    </div>

    <hr style="border:1px solid #000; background-color:#fff;">
    <a href="./index.php"><i class="fa fa-home"></i> Dashboard</a>
    <a href="./search.php"><i class="fa fa-home"></i> Search</a>
    <a href="javascript:void(0)" onclick="handleNavigation('customers')"><i class="fa fa-users"></i> Customers</a>
    <a href="javascript:void(0)" onclick="handleNavigation('staff')"><i class="fa fa-users"></i> Staff</a>
    <a href="javascript:void(0)" onclick="handleNavigation('category')"><i class="fa fa-th-large"></i> Category</a>
    <a href="javascript:void(0)" onclick="handleNavigation('sizes')"><i class="fa fa-th"></i> Sizes</a>
    <a href="javascript:void(0)" onclick="handleNavigation('productsizes')"><i class="fa fa-th-list"></i> Product
        Sizes</a>
    <a href="javascript:void(0)" onclick="handleNavigation('products')"><i class="fa fa-th"></i> Products</a>
    <a href="javascript:void(0)" onclick="handleNavigation('orders')"><i class="fa fa-list"></i> Orders</a>
    <a href="javascript:void(0)" onclick="handleNavigation('logout')"><i class="fa fa-sign-out"></i> Log Out</a>
</div>

<script>
    function handleNavigation(section) {
        // Kiểm tra nếu đang ở trang search.php
        if (window.location.pathname.includes('search.php')) {
            // Chuyển hướng về index.php với anchor tương ứng
            window.location.href = `./index.php#${section}`;
            return false;
        }
        // Nếu đang ở index.php thì gọi hàm show tương ứng
        switch (section) {
            case 'customers':
                showCustomers();
                break;
            case 'staff':
                showStaff();
                break;
            case 'category':
                showCategory();
                break;
            case 'sizes':
                showSizes();
                break;
            case 'productsizes':
                showProductSizes();
                break;
            case 'products':
                showProductItems();
                break;
            case 'orders':
                showOrders();
                break;
            case 'logout':
                showLogOut();
                break;
        }
        return false;
    }

    // Thêm event listener khi trang được load
    document.addEventListener('DOMContentLoaded', function () {
        // Nếu có hash trong URL và đang ở trang index.php
        if (window.location.hash && window.location.pathname.includes('index.php')) {
            // Lấy section từ hash (bỏ dấu #)
            const section = window.location.hash.substring(1);
            // Gọi hàm tương ứng
            switch (section) {
                case 'customers':
                    showCustomers();
                    break;
                case 'staff':
                    showStaff();
                    break;
                case 'category':
                    showCategory();
                    break;
                case 'sizes':
                    showSizes();
                    break;
                case 'productsizes':
                    showProductSizes();
                    break;
                case 'products':
                    showProductItems();
                    break;
                case 'orders':
                    showOrders();
                    break;
                case 'logout':
                    showLogOut();
                    break;
            }
        }
    });
</script>