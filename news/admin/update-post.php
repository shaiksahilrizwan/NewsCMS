<?php 
    include "header.php";
    include "config.php"; 
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <?php 
            if(isset($_GET['id'])){
                if($_SESSION['role']==1){
                    $sql="SELECT * FROM POST WHERE POSTID={$_GET['id']}";
            }else{
                    $sql="SELECT * FROM POST WHERE POSTID={$_GET['id']} AND AUTHOR={$_SESSION['userid']}";
                }
                $result=mysqli_query($conn,$sql) or die("Can not load the data");
                if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_assoc($result)){
        ?>
        <!-- Form for show edit-->
        <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $row['POSTID']; ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $row['POSTTITLE']; ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5"><?php echo $row['POSTDESCRIPTION']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="category">
                <?php 
                    $sql2="SELECT * FROM CATEGORY";
                    $result2=mysqli_query($conn,$sql2) or die("Can not load data");
                    while($row2=mysqli_fetch_assoc($result2)){
                        if($row['CATEGORY']==$row2['CATEGORYID']){
                ?>
                    
                    <option value="<?php echo $row2['CATEGORYID']; ?>" selected><?php echo $row2['CATEGORYNAME']; ?></option>
                <?php 
                        }
                        else{
                            ?>
                            <option value="<?php echo $row2['CATEGORYID']; ?>"><?php echo $row2['CATEGORYNAME']; ?></option>
                <?php
                        }
                    }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
                <img  src="<?php echo "upload/".$row['POSTIMAGE']; ?>" height="150px">
                <!-- Will be helpful when user doesn't update the image  -->
                <input type="hidden" name="old-image" value="<?php echo $row['POSTIMAGE']; ?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <?php 
                    }
                }else{
                    echo "<h2>No Post found to edit</h2>";
                }
            }else{
                echo "<h2>No Post Found !</h2>";
            }
        ?>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
