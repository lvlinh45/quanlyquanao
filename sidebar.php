<!-- Sidebar -->

<div class="sidebar" id="mySidebar">
    <div class="side-header">
        <img src="./assets/images/logo.png" width="120" height="120" alt="avatar">
        <h5 style="margin-top:10px; color: #000; font-weight: bold;">Hello, 
        <?php 
            // Bắt đầu phiên
            session_start();
            
            // Kiểm tra xem người dùng đã đăng nhập chưa
            if (isset($_SESSION['login'])) {
                // Lấy dữ liệu từ session
                $user = $_SESSION['login'];
            
                // Truy cập các giá trị cụ thể
                $username = $user['first_name'];
            
                // Hiển thị thông tin người dùng
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
    <a href="#category" onclick="showCategory()"><i class="fa fa-th-large"></i> Category</a>
    <a href="#sizes" onclick="showSizes()"><i class="fa fa-th"></i> Sizes</a>
    <a href="#productsizes" onclick="showProductSizes()"><i class="fa fa-th-list"></i> Product Sizes</a>
    <a href="#products" onclick="showProductItems()"><i class="fa fa-th"></i> Products</a>
    <a href="#orders" onclick="showOrders()"><i class="fa fa-list"></i> Orders</a>
    <a href="#orders" onclick="showLogOut()"><i class="fa fa-list"></i> Log Out</a>
</div>
