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
                            $sql = "SELECT * from users where isAdmin=0";
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

            <!-- New Line Chart Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <h4>Claims Over the Years</h4>
                    <canvas id="claimsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_GET['category']) && $_GET['category'] == "success") {
        echo '<script> alert("Category Successfully Added")</script>';
    } else if (isset($_GET['category']) && $_GET['category'] == "error") {
        echo '<script> alert("Adding Unsuccess")</script>';
    }
    if (isset($_GET['size']) && $_GET['size'] == "success") {
        echo '<script> alert("Size Successfully Added")</script>';
    } else if (isset($_GET['size']) && $_GET['size'] == "error") {
        echo '<script> alert("Adding Unsuccess")</script>';
    }
    if (isset($_GET['variation']) && $_GET['variation'] == "success") {
        echo '<script> alert("Variation Successfully Added")</script>';
    } else if (isset($_GET['variation']) && $_GET['variation'] == "error") {
        echo '<script> alert("Adding Unsuccess")</script>';
    }
    ?>

    <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Line Chart for Claims
        var ctx = document.getElementById('claimsChart').getContext('2d');
        var claimsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['2019', '2020', '2021', '2022', '2023', '2024'],
                datasets: [
                    {
                        label: 'Approved',
                        data: [20, 30, 25, 35, 40, 30],
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2,
                        tension: 0.4, // Smooth line
                        pointRadius: 0, // Hide points
                        fill: true // Fill area under line
                    },
                    {
                        label: 'Submitted',
                        data: [15, 25, 30, 35, 45, 40],
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2,
                        tension: 0.4, // Smooth line
                        pointRadius: 0, // Hide points
                        fill: true // Fill area under line
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `${context.dataset.label}: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 50,
                        ticks: {
                            stepSize: 10
                        },
                        grid: {
                            color: 'rgba(200, 200, 200, 0.2)'
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>
