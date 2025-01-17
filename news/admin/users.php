<?php 
  include "config.php";
  include "auth.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Management - Admin Panel</title>
    <link href="styles/output.css" rel="stylesheet" />
    <style>
      .main-content {
        display: flex;
        flex-direction: column;
        height: 100%;
      }
      .table-container {
        flex: 1;
        overflow-x: auto;
      }
      .pagination {
        margin-top: 1.5rem;
        display: flex;
        justify-content: space-between;
      }
      .form-modal {
        position: fixed;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.5);
        z-index: 50;
        display: none;
      }
    </style>
  </head>
  <?php 
    if(isset($_GET['page'])){
      $page=mysqli_real_escape_string($conn,$_GET['page']);
    }
    else{
      $page=1;
    }
  ?>
  <body class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
      <div class="p-6 text-2xl font-bold border-b border-gray-700">
        Admin Panel
      </div>
      <nav class="flex-1 mt-6">
        <ul class="space-y-2">
          <li>
            <a
              href="index.html"
              class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300"
              >Dashboard</a
            >
          </li>
          <li>
            <a
              href="orders.html"
              class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300"
              >Orders</a
            >
          </li>
          <li>
            <a
              href="menu.html"
              class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300"
              >Menu Management</a
            >
          </li>
          <li>
            <a
              href="users.html"
              class="block px-4 py-2 text-gray-300 bg-gray-700 hover:bg-gray-600 hover:text-white transition duration-300"
              >User Management</a
            >
          </li>
          <li>
            <a
              href="reports.html"
              class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300"
              >Reports</a
            >
          </li>
          <li>
            <a
              href="settings.html"
              class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition duration-300"
              >Settings</a
            >
          </li>
        </ul>
      </nav>
      <div class="p-4">
        <button
          class="bg-red-600 hover:bg-red-700 w-full py-2 rounded-lg text-white font-semibold transition duration-300"
        >
          Logout
        </button>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <!-- Top Navigation Bar -->
      <header class="bg-white shadow-md p-4 flex items-center justify-between">
        <div class="text-2xl font-bold text-gray-800">User Management</div>
        <button
          class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold transition duration-300"
          onclick="document.getElementById('add-user-modal').classList.remove('hidden')"
        >
          Add New User
        </button>
      </header>

      <!-- Main Content Area -->
      <main class="main-content p-6">
        <!-- User Overview -->
        <section class="bg-white p-6 shadow-lg rounded-lg table-container">
          <div class="overflow-x-auto">
            <table
              class="min-w-full divide-y divide-gray-200 border border-gray-200"
            >
              <thead class="bg-gray-300">
                <tr>
                  <th
                    class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider"
                  >
                    User ID
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider"
                  >
                    Name
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider"
                  >
                    Email
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider"
                  >
                    Role
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider"
                  >
                    Status
                  </th>
                  <th class="px-6 py-3"></th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php
                  $limit=5;#hard coded page limit
                  $offset=($page-1)*$limit; #finding the record number
                  $sqlfetch="SELECT * FROM USER ORDER BY USERID DESC LIMIT {$offset},{$limit}";
                  $result=mysqli_query($conn,$sqlfetch)or die("Connection Failed");
                  if(mysqli_num_rows($result)>0){ #assoc array fetch
                while($row=mysqli_fetch_assoc($result)){ ?>
                <!-- Example rows, replace with dynamic data -->
                <tr class="bg-gray-50 hover:bg-gray-100">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <?php echo $row['USERNAME']; ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <?php echo $row['NAME']; ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <?php echo $row['EMAIL']; ?>
                  </td>
                  <?php
                    $rol="Normal User";
                    if($row['ROLE']==0){
                      $rol="Admin";
                    }
                  ?>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <?php echo $rol; ?>
                  </td>
                  <!-- <td class="px-6 py-4 whitespace-nowrap text-green-600">
                    Active
                  </td> -->
                  <td class="px-6 py-4 whitespace-nowrap text-right">
                    <a
                      href="edit.php?id=<?php echo $row['USERID'];?>"
                      class="bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded-lg"
                    >
                      Edit
                    </a>
                    <button
                      class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded-lg ml-2"
                      onclick="confirmDeleteUser(1)"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
                <?php
              }
              }
              else{
                echo "<pre>No Data to Fetch!!</pre>";
              }
               ?>
            </tbody>
            </table>
          </div>
        </section>

<!-- Pagination -->
<div class="pagination">
  <div class="flex space-x-4">
    <?php 
      if($page>1){
    ?>
  <a
      href="users.php?page=<?php echo $page-1; ?>"
      class="bg-gray-300 mr-2 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-300"
    >Prev</a>
    <?php }?>
    <?php 
    #checking no of records present
      $sqlpage="SELECT * FROM USER";
      $resultpages=mysqli_query($conn,$sqlpage) or die("Fatal error!");
      $noofrecords=mysqli_num_rows($resultpages);
      if($noofrecords>0){
        $totalpages=ceil($noofrecords/5);
        for($i=1;$i<=$totalpages;$i++){
          #no of pages and sending the page into url
    ?>
    <a
      href="users.php?page=<?php echo $i; ?>"
      class="bg-gray-300 mr-2 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-300"
    >
      <?php echo $i; ?>
    </a>
    <?php
        }
      }
    ?>
    <?php 
      if($page!=$totalpages){
        #if last page then if not executed;
    ?>
  <a
      href="users.php?page=<?php echo $page+1; ?>"
      class="bg-gray-300 mr-2 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-300"
    >Next</a>
    <?php }?>
  </div>

</div>


    <!-- Add/Edit User Modal -->
    <div
      id="add-user-modal"
      class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50 hidden"
    >
      <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-2xl font-semibold text-gray-800">Add New User</h2>
          <button
            class="text-gray-600 hover:text-gray-800 text-2xl"
            onclick="document.getElementById('add-user-modal').classList.add('hidden')"
          >
            &times;
          </button>
        </div>
        <form id="add-user-form" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="space-y-4">
            <div class="flex flex-col">
              <label
                for="user-name"
                class="text-sm font-medium text-gray-700 mb-1"
                >User Name</label
              >
              <input
                type="text"
                id="user-name"
                class="block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm px-3 py-2"
                placeholder="Enter user name"
                required
              />
            </div>
            <?php # Did not write the username input and Address input as well?>

            <div class="flex flex-col">
              <label
                for="user-email"
                class="text-sm font-medium text-gray-700 mb-1"
                >Email</label
              >
              <input
                type="email"
                id="user-email"
                class="block w-full border border-gray-300 rounded-lg shadow focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm px-3 py-2"
                placeholder="Enter email"
                required
              />
            </div>

            <div class="flex flex-col"></div>
              <label
                for="address"
                class="text-sm font-medium text-gray-700 mb-1"
                >Address</label
              >
              <input
                type="text"
                name="address"
                id="user-email"
                class="block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm px-3 py-2"
                placeholder="Enter address "
                required
              />
            </div>

            <div class="flex flex-col">
              <label
                for="user-role"
                class="text-sm font-medium text-gray-700 mb-1"
                >Role</label
              >
              <select
                id="user-role"
                class="block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm px-3 py-2"
              >
                <option value="admin">Admin</option>
                <option value="editor">Customer</option>
                <option value="viewer">Vendor</option>
              </select>
            </div>

            <div class="flex flex-col">
              <label
                for="user-status"
                class="text-sm font-medium text-gray-700 mb-1"
                >Status</label
              >
              <select
                id="user-status"
                class="block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm px-3 py-2"
              >
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>

          <div class="mt-6 flex justify-end">
            <button
              type="button"
              class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg mr-2"
              onclick="document.getElementById('add-user-modal').classList.add('hidden')"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg"
            >
              Save User
            </button>
          </div>
        </form>
      </div>
    </div>

    <?php # JS removed due to submit problem !!!?>
    <?php 

      #Handel the User add form data
      if(isset($_POST['adduser'])):
        $name=mysqli_real_escape_string($conn,$_POST['name']);
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        $username=mysqli_real_escape_string($conn,$_POST['username']);
        $password=mysqli_real_escape_string($conn,sha1($_POST['password']));
        $address=mysqli_real_escape_string($conn,$_POST['address']);
        $role=$_POST['role'];
        # Check for same Username 
        $sqlcheck="SELECT * FROM USER WHERE USERNAME='{$username}'";
        if(mysqli_num_rows(mysqli_query($conn,$sqlcheck))>0){
          echo '<script>alert("Username Already Exit Give a new Username Re-Enter Details");</script>';
        }
        else{
          $sql="INSERT INTO USER(NAME,ADDRESS,USERNAME,EMAIL,PASSWORD,ROLE) VALUES('{$name}','{$address}','{$username}','{$email}','{$password}',{$role})";
          $result=mysqli_query($conn,$sql) or die("Can't Do the Operation at moment!");

        }
      endif;
    ?>
  </body>
</html>
