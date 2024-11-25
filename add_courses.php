<?php 
	include_once 'header.php';
	include_once 'db.php';
	if (isset($_GET['u_id'])) {
		$id = $_GET['u_id'];
		$update_data = "select * from courses where id = $id";
		$data = mysqli_query($con,$update_data);
		$s_row = mysqli_fetch_assoc($data);
	}
	if (isset($_POST['save'])) {
		$course = $_POST['c_name'];
		if (!isset($_GET['u_id'])) {
      $sql_select = "select * from courses where c_name = '$course'";
      $data = mysqli_query($con,$sql_select);
      $cnt = mysqli_num_rows($data);
      if($cnt == 1){
          $row = mysqli_fetch_assoc($data);
          $data1 = $row['c_name'];
          echo "<script>alert('This course already added.')</script>";
      }else{
         $sql_query = "insert into courses(c_name)values('$course')";
          mysqli_query($con,$sql_query);
          header('location:view_courses.php');
      }
    }
    else{
       $sql_query = "update courses set c_name = '$course' where id = '$id'";
        mysqli_query($con,$sql_query);
      header('location:view_courses.php');
    }
	}
 ?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Course Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Course Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Course Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Course</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Course Name" name="c_name" value="<?php echo @$s_row['c_name']; ?>">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" class="btn btn-primary" name="save" value="submit">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  

   <?php include_once 'footer.php'; ?>