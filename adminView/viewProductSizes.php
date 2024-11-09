
<div >
  <h2>Product Sizes Item</h2>
  <table class="table ">
    <thead>
      <tr>
        <th class="text-center">S.N.</th>
        <th class="text-center">Product Name</th>
        <th class="text-center">Size</th>
        <th class="text-center">Stock Quantity</th>
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
      $sql="SELECT * from product_size_variation v, product p, sizes s WHERE p.product_id=v.product_id AND v.size_id=s.size_id LIMIT $offset, $rowsPerPage";
      $result=$conn-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
    ?>
    <tr>
      <td><?=$count?></td>
      <td><?=$row["product_name"]?></td>
      <td><?=$row["size_name"]?></td>      
      <td><?=$row["quantity_in_stock"]?></td>     
      <td><button class="btn btn-primary" style="height:40px" onclick="variationEditForm('<?=$row['variation_id']?>')">Edit</button></td>
      <td><button class="btn btn-danger" style="height:40px"  onclick="variationDelete('<?=$row['variation_id']?>')">Delete</button></td>
      </tr>
      <?php
            $count=$count+1;
          }
        }
      ?>
  </table>

  <?php 
    echo "<div class='pagination'>";
      $re = mysqli_query($conn, 'SELECT * from product_size_variation v, product p, sizes s WHERE p.product_id=v.product_id AND v.size_id=s.size_id');
      $numRows = mysqli_num_rows($re);
      $maxPage = ($numRows > 0) ? floor($numRows / $rowsPerPage) + 1 : 0;  
      $page = $_POST['page'];

      if ($_POST['page'] > 1)
      { 
          echo '<a href="javascript:void(0);" onclick="showProductSizes(1)"><<</a>';
          echo '<a href="javascript:void(0);" onclick="showProductSizes(' . ($page - 1) . ')"><</a>';
      }

      //tạo link tương ứng tới các trang
      for ($i = 1; $i <= $maxPage; $i++) {
          if ($i == $_POST['page']) {
              echo '<b>' . $i . '</b> '; //trang hiện tại sẽ được bôi đậm
          } else
              echo '<a href="javascript:void(0);" onclick="showProductSizes(' . $i . ')">' . $i . '</a> ';
      }
      //gắn thêm nút Next
      if ($_POST['page'] < $maxPage)
      { 
          echo '<a href="javascript:void(0);" onclick="showProductSizes(' . ($page + 1) . ')">></a>';
          echo '<a href="javascript:void(0);" onclick="showProductSizes(' . $maxPage . ')">>></a>';
      }

      echo "</div>";

  ?>

  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-secondary" style="height:40px" data-toggle="modal" data-target="#myModal">
    Add Size Variation
  </button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Product Size Variation</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form  enctype='multipart/form-data' action="./controller/addVariationController.php" method="POST">
            
            <div class="form-group">
              <label>Product:</label>
              <select name="product" >
                <option disabled selected>Select product</option>
                <?php

                  $sql="SELECT * from product";
                  $result = $conn-> query($sql);

                  if ($result-> num_rows > 0){
                    while($row = $result-> fetch_assoc()){
                      echo"<option value='".$row['product_id']."'>".$row['product_name'] ."</option>";
                    }
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label>Size:</label>
              <select name="size" >
                <option disabled selected>Select size</option>
                <?php

                  $sql="SELECT * from sizes";
                  $result = $conn-> query($sql);

                  if ($result-> num_rows > 0){
                    while($row = $result-> fetch_assoc()){
                      echo"<option value='".$row['size_id']."'>".$row['size_name'] ."</option>";
                    }
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="qty">Stock Quantity:</label>
              <input type="number" class="form-control" name="qty" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary" name="upload" style="height:40px">Add Variation</button>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  
</div>
   