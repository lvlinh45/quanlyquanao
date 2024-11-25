<?php
session_start();
include_once "./config/dbconnect.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Search Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
    .search-container {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .product-card {
        transition: transform 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .product-image {
        height: 200px;
        object-fit: cover;
    }

    .filters {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="content-main">
        <?php include "./sidebar.php"; ?>

        <div id="main-content" style="margin-left: 350px;" class="container allContent-section py-4">
            <div class="row">
                <div class="col-12">
                    <div class="search-container">
                        <h2 class="mb-4">Search Products</h2>

                        <!-- Search Form -->
                        <form method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search by product name..."
                                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>

                            <!-- Filters section -->
                            <div class="filters mt-3">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label>Category</label>
                                        <select name="category" class="form-control">
                                            <option value="">All Categories</option>
                                            <?php
                                            $cat_sql = "SELECT * FROM category";
                                            $cat_result = $conn->query($cat_sql);
                                            while($cat_row = $cat_result->fetch_assoc()) {
                                                $selected = (isset($_GET['category']) && $_GET['category'] == $cat_row['category_id']) ? 'selected' : '';
                                                echo "<option value='".$cat_row['category_id']."' ".$selected.">".$cat_row['category_name']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Color</label>
                                        <select name="color" class="form-control">
                                            <option value="">All Colors</option>
                                            <?php
                                            $color_sql = "SELECT DISTINCT color FROM product WHERE color IS NOT NULL AND color != '' ORDER BY color";
                                            $color_result = $conn->query($color_sql);
                                            while($color_row = $color_result->fetch_assoc()) {
                                                $selected = (isset($_GET['color']) && $_GET['color'] == $color_row['color']) ? 'selected' : '';
                                                echo "<option value='".$color_row['color']."' ".$selected.">".$color_row['color']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Price Range</label>
                                        <select name="price_range" class="form-control">
                                            <option value="">All Prices</option>
                                            <option value="0-100"
                                                <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '0-100') ? 'selected' : ''; ?>>
                                                $0 - $100</option>
                                            <option value="100-500"
                                                <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '100-500') ? 'selected' : ''; ?>>
                                                $100 - $500</option>
                                            <option value="500+"
                                                <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '500+') ? 'selected' : ''; ?>>
                                                $500+</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Sort By</label>
                                        <select name="sort" class="form-control">
                                            <option value="">Sort By</option>
                                            <option value="price_asc"
                                                <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : ''; ?>>
                                                Price: Low to High</option>
                                            <option value="price_desc"
                                                <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : ''; ?>>
                                                Price: High to Low</option>
                                            <option value="name_asc"
                                                <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name_asc') ? 'selected' : ''; ?>>
                                                Name: A to Z</option>
                                            <option value="name_desc"
                                                <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name_desc') ? 'selected' : ''; ?>>
                                                Name: Z to A</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Search Results -->
                        <div class="row">
                            <?php
                            if (isset($_GET['search']) || isset($_GET['category']) || isset($_GET['price_range']) || isset($_GET['sort'])) {
                                $where_conditions = array();
                                $params = array();

                                // Search term condition
                                if (!empty($_GET['search'])) {
                                    $search_term = '%' . trim($_GET['search']) . '%';
                                    $where_conditions[] = "p.product_name LIKE ?";
                                    $params[] = $search_term;
                                }

                                // Category condition
                                if (!empty($_GET['category'])) {
                                    $where_conditions[] = "p.category_id = ?";
                                    $params[] = $_GET['category'];
                                }

                                // Price range condition
                                if (!empty($_GET['price_range'])) {
                                    $price_range = explode('-', $_GET['price_range']);
                                    if (count($price_range) == 2) {
                                        $where_conditions[] = "p.price BETWEEN ? AND ?";
                                        $params[] = $price_range[0];
                                        $params[] = $price_range[1];
                                    } elseif (strpos($_GET['price_range'], '+') !== false) {
                                        $where_conditions[] = "p.price >= ?";
                                        $params[] = str_replace('+', '', $_GET['price_range']);
                                    }
                                }

                                // Color condition
                                if (!empty($_GET['color'])) {
                                    $where_conditions[] = "p.color = ?";
                                    $params[] = $_GET['color'];
                                }

                                // Build the base query
                                $sql = "SELECT p.*, c.category_name 
                                       FROM product p 
                                       LEFT JOIN category c ON p.category_id = c.category_id";

                                // Add where conditions if any
                                if (!empty($where_conditions)) {
                                    $sql .= " WHERE " . implode(' AND ', $where_conditions);
                                }

                                // Add sorting
                                if (!empty($_GET['sort'])) {
                                    switch ($_GET['sort']) {
                                        case 'price_asc':
                                            $sql .= " ORDER BY p.price ASC";
                                            break;
                                        case 'price_desc':
                                            $sql .= " ORDER BY p.price DESC";
                                            break;
                                        case 'name_asc':
                                            $sql .= " ORDER BY p.product_name ASC";
                                            break;
                                        case 'name_desc':
                                            $sql .= " ORDER BY p.product_name DESC";
                                            break;
                                    }
                                }

                                $stmt = $conn->prepare($sql);
                                if (!empty($params)) {
                                    $types = str_repeat('s', count($params));
                                    $stmt->bind_param($types, ...$params);
                                }
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                            <div class="col-md-4 mb-4">
                                <div class="card product-card">
                                    <img src="<?php echo $row['product_image']; ?>" class="card-img-top product-image"
                                        alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($row['product_name']); ?>
                                        </h5>
                                        <p class="card-text">
                                            Category: <?php echo htmlspecialchars($row['category_name']); ?><br>
                                            Price: $<?php echo number_format($row['price'], 2); ?>
                                        </p>
                                        <p class="card-text small">
                                            <?php echo htmlspecialchars(substr($row['product_desc'], 0, 100)) . '...'; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    }
                                } else {
                                    echo '<div class="col-12"><div class="alert alert-info">No products found matching your criteria.</div></div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>