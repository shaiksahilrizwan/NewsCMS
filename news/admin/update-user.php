<?php 
    include "header.php"; 
    include "config.php"; 
    if(!mysqli_num_rows(mysqli_query($conn,"SELECT * FROM user WHERE USERID='{$_SESSION['userid']}' AND role=1"))){
        header("Location: ".$site."Admin/post.php");
    }
?>
<?php  
                    if(isset($_POST['submit'])){
                        $fname=mysqli_real_escape_string($conn,$_POST['f_name']);
                        $lname=mysqli_real_escape_string($conn,$_POST['l_name']);
                        $uname=mysqli_real_escape_string($conn,$_POST['username']);
                        $role=mysqli_real_escape_string($conn,$_POST['role']);
                        $uid=$_POST['user_id'];
                        $sqlcheck="SELECT * FROM USER WHERE username='{$uname}'";
                        if(mysqli_query($conn,$sqlcheck)){
                            if(mysqli_num_rows(mysqli_query($conn,$sqlcheck))>0){
                                echo "<script>alert('Same Username Already Exists Use new');</script>";
                                header("Location: $site/Admin/update-user.php?id=$uid");
                            }
                        }else{
                            echo $sqlcheck;
                        }
                        $sql="UPDATE USER SET FIRSTNAME='{$fname}',LASTNAME='{$lname}',username='{$uname}',role={$role} WHERE USERID={$uid}";
                        if(mysqli_query($conn,$sql)){
                            header("http://localhost/news/Admin/users.php");
                            header("Location: $site/Admin/users.php");
                            echo "Good!";
                        }else{
                            echo "<script>alert('Cant');</script>";
                            header("Location: $site/Admin/users.php");
                        }
                       
                    }
                  ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                  <!-- Form Start -->
                   <?php 
                    $id=$_GET['id'];
                    $sql="SELECT FIRSTNAME,LASTNAME,username,role FROM USER WHERE USERID='{$id}'";
                    $result=mysqli_query($conn,$sql) or die("Cant Process Request !");
                    if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_assoc($result)){
                   ?>
                  <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $id; ?>" placeholder="">
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $row['FIRSTNAME']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $row['LASTNAME']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" value="<?php echo $row['role']; ?>">
                            <?php if($row['role']==1){ ?>
                              <option value="0">normal User</option>
                              <option value="1" selected>Admin</option>
                              <?php }else{?>
                                <option value="0" selected>normal User</option>
                              <option value="1">Admin</option>
                                <?php }?>
                            </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <!-- /Form -->
                  <?php 
                            } 
                        } 
                    else{
                        echo '<script>alert("No such Record Found!");</script>';
                        header("http://localhost/news/Admin/users.php");
                  }
                    mysqli_close($conn);
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>