<?php 
    include "header.php"; 
    include "config.php"; #This is for DataBase Connection
    if(!mysqli_num_rows(mysqli_query($conn,"SELECT * FROM user WHERE USERID='{$_SESSION['userid']}' AND role=1"))>0){
        header("Location: ".$site."Admin/post.php");
    }
?>
<?php 
        if(isset($_POST['save'])):
            $fname=mysqli_real_escape_string($conn,$_POST['fname']);
            $lname=mysqli_real_escape_string($conn,$_POST['lname']);
            $uname=mysqli_real_escape_string($conn,$_POST['user']);
            $pass=mysqli_real_escape_string($conn,sha1($_POST['password']));
            $urole=mysqli_real_escape_string($conn,$_POST['role']);
            $sql="SELECT username FROM USER WHERE username='{$uname}'";
            $result=mysqli_query($conn,$sql) or die("Unable to Fetch Details");
                if(mysqli_num_rows($result)>0){
                    echo "<script>alert('Username Already Exists');</script>";
                }else{
                    $sql="INSERT INTO USER(FIRSTNAME,LASTNAME,PASSWORD,role,username) VALUES('{$fname}','{$lname}','{$pass}',{$urole},'{$uname}')";
                   if(mysqli_query($conn,$sql)){
                        header("Location: ".$site."Admin/users.php");
                   }else{
                        echo '<script>alert("Can not Process the Request Please Fill Again!");</script>';
                    }   
                }
        endif;
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add User</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="post" autocomplete="off">
                      <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                      </div>
                          <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="user" class="form-control" placeholder="Username" required>
                      </div>

                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" placeholder="Password" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" >
                              <option value="0">Normal User</option>
                              <option value="1">Admin</option>
                          </select>
                      </div>
                      <input type="submit"  name="save" class="btn btn-primary" value="Save" required />
                  </form>
                   <!-- Form End-->
                    
               </div>
           </div>
       </div>
   </div>
<?php include "footer.php"; ?>
