<?php 
	include_once 'header.php';
	include_once 'db.php';
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	}
	else{
    	$page = 1;
  	}
  	if (isset($_GET['search'])) {
		$search = $_GET['search'];
	}
	else{
    	$search = '';
  	}

  	$sql_select = "select * from branch where branch_name like '%$search%'";
  	$data = mysqli_query($con,$sql_select);
  	$countdata = mysqli_num_rows($data);

  	$limit = 5;
  	$total_page = ceil($countdata/$limit);

  	$start = ($page-1)*$limit;
  	$sql_select = "select * from branch where branch_name like '%$search%'  limit $start,$limit";
  	$data = mysqli_query($con,$sql_select);
	if (isset($_GET['d_id'])) {
		$d_id = $_GET['d_id'];
		$delete_data = "delete from branch where id = '$d_id'";
		mysqli_query($con,$delete_data);
		header('location:view_branch.php');
	}
	if (isset($_GET['u_id'])) {
		$u_id = $_GET['u_id'];
		$update_data = "select * from branch where id = '$u_id'";
		mysqli_query($con,$update_data);
	}
 ?>
 <div class="content-wrapper">    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>View Branch</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Branch</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header bg-primary">
                <h3 class="card-title">View Branch Page</h3>
              </div>
              <div class="d-flex justify-content-center mt-2">
                <form method="get">
                 <input type="text" name="search" class="p-1" placeholder="Search">
                 <input type="submit" name="submit" value="search" class="btn-primary py-1">
              </form>
              </div>
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Id.</th>
                    <th>Branch Name</th>
                    <th>Delete</th>
                    <th>Update</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $id=1; while($row = mysqli_fetch_assoc($data)) {
                   ?>
                  <tr>
                      <td><?php echo $row['id']; ?></td>
                      <td><?php echo $row['branch_name']; ?></td>
                      <td><a href="view_branch.php?d_id=<?php echo $row['id']; ?>"><i class="fa-solid fa-trash text-danger"></i></a></td>
                      <td><a href="add_branch.php?u_id=<?php echo $row['id']; ?>"><i class="nav-icon fas fa-edit"></i></a></td>
                 </tr>
                 <?php } ?>
                  </tbody>
                </table>
                 <div class="d-flex justify-content-center ">
                 <?php 
                     for ($i=1; $i <=$total_page; $i++)
                    {  
                  ?>
                    <button class="border-0 mt-3 m-1 btn-primary">
                      <a href="view_branch.php?page=<?php echo $i; ?>
                       <?php if (isset($_GET['search'])) { ?>&search=<?php echo $search; } ?>" class="text-white"> <?php echo $i; ?>
                      </a>
                   </button>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
   <?php include_once 'footer.php' ?>