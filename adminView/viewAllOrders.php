<div id="ordersBtn" >
  <h2>Order Details</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>O.N.</th>
        <th>Customer</th>
        <th>Contact</th>
        <th>Product Name</th>
        <th>Email</th>
        <th>OrderDate</th>
        <th>Payment Method</th>
        <th>Order Status</th>
        <th>Payment Status</th>
        <th>More Details</th>
     </tr>
    </thead>
     <?php
      include_once "../config/dbconnect.php";
      $rowsPerPage = 5; 
      if (!isset($_POST['page'])) {
          $_POST['page'] = 1;
      }
      $offset = ($_POST['page'] - 1) * $rowsPerPage;
      $sql="SELECT * from orders 
            INNER Join users on orders.user_id = users.user_id
            INNER Join order_details on order_details.order_id = orders.order_id
            Inner Join product_size_variation on order_details.variation_id = product_size_variation.variation_id
            inner join product on product.product_id = product_size_variation.product_id
             LIMIT $offset, $rowsPerPage";
      $result=$conn-> query($sql);
      
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
    ?>
       <tr>
          <td><?=$row["order_id"]?></td>
          <td><?=$row["first_name"]?></td>
          <td><?=$row["contact_no"]?></td>
          <td><?=$row["product_name"]?></td>
          <td><?=$row["email"]?></td>
          <td><?=$row["order_date"]?></td>
          <td><?=$row["pay_method"]?></td>
           <?php 
                if($row["order_status"]==0){
                            
            ?>
                <td><button class="btn btn-danger" onclick="ChangeOrderStatus('<?=$row['order_id']?>')">Pending </button></td>
            <?php
                        
                }else{
            ?>
                <td><button class="btn btn-success" onclick="ChangeOrderStatus('<?=$row['order_id']?>')">Delivered</button></td>
        
            <?php
            }
                if($row["pay_status"]==0){
            ?>
                <td><button class="btn btn-danger"  onclick="ChangePay('<?=$row['order_id']?>')">Unpaid</button></td>
            <?php
                        
            }else if($row["pay_status"]==1){
            ?>
                <td><button class="btn btn-success" onclick="ChangePay('<?=$row['order_id']?>')">Paid </button></td>
            <?php
                }
            ?>
              
        <td><button class="btn btn-primary openPopup" onclick='

              // xử lí sự kiện click hiện thị order detail
              var dataURL = this.getAttribute("data-href");
              console.log("Loading URL:", dataURL); // Debug: kiểm tra URL

              // Kiểm tra nếu dataURL không hợp lệ
              if (!dataURL) {
                  console.error("Error: data-href is missing or invalid.");
                  alert("Invalid order details URL.");
                  return;
              }

              // Sử dụng jQuery để load nội dung
              $(".order-view-modal").load(dataURL, function (response, status, xhr) {
                  if (status === "error") {
                      console.error("Error loading URL:", xhr.status, xhr.statusText);
                      alert("Cannot load order details. Please try again.");
                  } else {
                      // Hiển thị modal
                      $("#viewModal").modal({ show: true });
                  }
              });

        ' data-href="./adminView/viewEachOrder.php?orderID=<?=$row['order_id']?>">View</button></td>
        </tr>
    <?php
            
        }
      }
    ?>
     
  </table>

  <?php 
    echo "<div class='pagination'>"; 
      $re = mysqli_query($conn, 'SELECT * from orders');
      $numRows = mysqli_num_rows($re);
      $maxPage = ($numRows > 0) ? floor($numRows / $rowsPerPage) + 1 : 0;  
      $page = $_POST['page'];

      if ($_POST['page'] > 1)
      { 
          echo '<a href="javascript:void(0);" onclick="showOrders(1)"><<</a>';
          echo '<a href="javascript:void(0);" onclick="showOrders(' . ($page - 1) . ')"><</a>';
      }

      //tạo link tương ứng tới các trang
      for ($i = 1; $i <= $maxPage; $i++) {
          if ($i == $_POST['page']) {
              echo '<b>' . $i . '</b> '; //trang hiện tại sẽ được bôi đậm
          } else
              echo '<a href="javascript:void(0);" onclick="showOrders(' . $i . ')">' . $i . '</a> ';
      }
      //gắn thêm nút Next
      if ($_POST['page'] < $maxPage)
      { 
          echo '<a href="javascript:void(0);" onclick="showOrders(' . ($page + 1) . ')">></a>';
          echo '<a href="javascript:void(0);" onclick="showOrders(' . $maxPage . ')">>></a>';
      }

      echo "</div>";

  ?>
   
</div>
<!-- Modal -->
<div class="modal fade" id="viewModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Order Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="order-view-modal modal-body">
                <!-- Nội dung sẽ được load ở đây -->
            </div>
        </div>
    </div>
</div>

<script>
    // for view order modal  
    // Chọn tất cả các nút với class .openPopup
      var open = document.querySelectorAll('.openPopup');

      // Duyệt qua từng nút
      open.forEach((element) => {
          element.addEventListener('click', (e) => {
              // Lấy thuộc tính data-href từ element
              var dataURL = element.getAttribute('data-href');
              console.log("Loading URL:", dataURL); // Debug: kiểm tra URL

              // Kiểm tra nếu dataURL không hợp lệ
              if (!dataURL) {
                  console.error("Error: data-href is missing or invalid.");
                  alert("Invalid order details URL.");
                  return;
              }

              // Sử dụng jQuery để load nội dung
              $('.order-view-modal').load(dataURL, function (response, status, xhr) {
                  if (status === "error") {
                      console.error("Error loading URL:", xhr.status, xhr.statusText);
                      alert("Cannot load order details. Please try again.");
                  } else {
                      // Hiển thị modal
                      $('#viewModal').modal({ show: true });
                  }
              });
          });
      });


    
 </script>