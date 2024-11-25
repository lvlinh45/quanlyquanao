<div>
  <h2>All Customers</h2>
  <table class="table ">
    <thead>
      <tr>
        <th class="text-center">S.N.</th>
        <th class="text-center">Username </th>
        <th class="text-center">Email</th>
        <th class="text-center">Contact Number</th>
        <th class="text-center">Address</th>
        <th class="text-center">Joining Date</th>
      </tr>
    </thead>
    <?php
    include_once "../config/dbconnect.php";
    $rowsPerPage = 5;
    if (!isset($_POST['page'])) {
      $_POST['page'] = 1;
    }
    $offset = ($_POST['page'] - 1) * $rowsPerPage;
    $sql = "SELECT * from users LIMIT $offset, $rowsPerPage";
    $result = $conn->query($sql);
    $count = 1;
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

        ?>
        <tr>
          <td><?= $count ?></td>
          <td><?= $row["last_name"] ?>     <?= $row["first_name"] ?></td>
          <td><?= $row["email"] ?></td>
          <td><?= $row["contact_no"] ?></td>
          <td><?= $row["user_address"] ?></td>
          <td><?= $row["registered_at"] ?></td>
        </tr>
        <?php
        $count = $count + 1;

      }
    }
    ?>
  </table>

  <?php
  echo "<div class='pagination'>";
  $re = mysqli_query($conn, 'SELECT * FROM users');
  $numRows = mysqli_num_rows($re);
  $maxPage = ($numRows > 0) ? floor($numRows / $rowsPerPage) + 1 : 0;
  $page = $_POST['page'];
  if ($_POST['page'] > 1) {
    echo '<a href="javascript:void(0);" onclick="showCustomers(1)"><<</a>';
    echo '<a href="javascript:void(0);" onclick="showCustomers(' . ($page - 1) . ')"><</a>';
  }

  //tạo link tương ứng tới các trang
  for ($i = 1; $i <= $maxPage; $i++) {
    if ($i == $_POST['page']) {
      echo '<b>' . $i . '</b> '; //trang hiện tại sẽ được bôi đậm
    } else
      echo '<a href="javascript:void(0);" onclick="showCustomers(' . $i . ')">' . $i . '</a> ';
  }
  //gắn thêm nút Next
  if ($_POST['page'] < $maxPage) {
    echo '<a href="javascript:void(0);" onclick="showCustomers(' . ($page + 1) . ')">></a>';
    echo '<a href="javascript:void(0);" onclick="showCustomers(' . $maxPage . ')">>></a>';
  }

  echo "</div>";
  ?>