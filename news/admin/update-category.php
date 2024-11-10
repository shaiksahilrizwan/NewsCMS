<?php 
    include "header.php"; 
    include "config.php"; 
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                <?php 
                if(isset($_GET['id'])){
                    $id=$_GET['id'];
                    $sql="SELECT * FROM CATEGORY WHERE CATEGORYID={$id}";
                    $result=mysqli_query($conn,$sql) or die("Can not load data");
                    while($row=mysqli_fetch_assoc($result)){
                ?>
                  <form action="save-update-category.php" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="<?php echo $row['CATEGORYID']; ?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $row['CATEGORYNAME']; ?>"  placeholder="" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                </div>
                <?php 
                    }
                } 
                else{
                    echo "<h2>No Category Found to Update!</h2>";
                }
                if(!isset($_GET['error'])){
                    $error=" ";
                }
                else{
                    $error=$_GET['error'];
                }
                echo "<br>";
                echo "<h2>",$error."</h2>";
                ?>
              </div>
            </div>
          </div>
<?php include "footer.php"; ?>
