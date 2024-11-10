<?php 
        include "header.php";
        include "config.php"; 
        if(!mysqli_num_rows(mysqli_query($conn,"SELECT * FROM user WHERE USERID='{$_SESSION['userid']}' AND role=1"))>0){
            header("Location: ".$site."Admin/post.php");
        }
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
            <?php 
                if(!isset($_GET['page'])){
                    $page=1;
                }else{
                    $page=$_GET['page'];
                }
                $limit=5;
                $offset=($page-1)*$limit;
            ?>
                    <tbody>
            <?php 
                $sql="SELECT * FROM CATEGORY ORDER BY CATEGORYID DESC LIMIT {$offset},{$limit}";
                $result=mysqli_query($conn,$sql) or die("Can not process data");
                if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_assoc($result)){
            ?>
                        <tr>
                            <td class='id'><?php echo $row['CATEGORYID']; ?></td>
                            <td><?php echo $row['CATEGORYNAME']; ?></td>
                            <td><?php echo $row['POST']; ?></td>
                            <td class='edit'><a href='update-category.php?id=<?php echo $row['CATEGORYID']; ?>'><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-category.php?id=<?php echo $row['CATEGORYID']; ?>'><i class='fa fa-trash-o'></i></a></td>
                        </tr>
                        <?php
                    }
                        ?>
                    </tbody>
                </table>
                <ul class='pagination admin-pagination'>
                  <?php 
                 
                }else{
                    echo "No records to dispaly";
                }
                    if($page>1){
                        $prev=$page-1;
                        echo "<li><a href='category.php?page=$prev'>Prev</a></li>";
                    }
                    $totalrecords=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM CATEGORY"));
                    if($totalrecords>0){
                        $totalpages=ceil($totalrecords/$limit);
                        for($i=1;$i<=$totalpages;$i++){ 
                            if($i==$page){   
                    
                  ?>
                      <li class="active"><a href="category.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php 
                            }
                            else{
                                ?>
                                <li><a href="category.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php
                            }
                    
                    }    
                }
                
                if($page<$totalpages){
                    $next=$page+1;
                    echo "<li><a href='category.php?page=$next'>Next</a></li>";
                }
                ?>
                 </ul>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
