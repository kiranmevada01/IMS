<?php include_once 'header.php';
  include_once 'db.php';
    if (isset($_GET['u_id'])) {
      $id = $_GET['u_id'];

    $sql_data = "select * from admin where id = $id";
    $data = mysqli_query($con,$sql_data);
    $s_row = mysqli_fetch_assoc($data);

    }
   if(isset($_POST['save'])){
      $name = $_POST['name'];
      $email = $_POST['email'];
      $pass = $_POST['password'];
      $branch = $_POST['branch'];
      $role = $_POST['role'];
      $image = $_FILES['image']['name'];
          if($branch == ''){
              $branch = $s_row['branch'];
          }
          if($role == ''){
              $role = $s_row['role'];
          }
          if($image == "" )
          {
              $image = $s_row['image'];
          }
          else{
              $update_img = "select * from admin where id = '$id'";
              $img_res = mysqli_query($con,$update_img);
              $imgdata = mysqli_fetch_assoc($img_res);
              unlink('image/admin/'.$imgdata['image']);

              $image = rand(10000,99999).'-'.$_FILES['image']['name'];
              $path = "image/admin/".$image;
              move_uploaded_file($_FILES['image']['tmp_name'],$path);
  
          }
        if(!isset($_GET['u_id'])){
              $sql = "select * from admin where email = '$email'";
              $data1 = mysqli_query($con, $sql);
              $cnt = mysqli_num_rows($data1);
                  if($cnt == 1) {
                      $row = mysqli_fetch_assoc($data1);
                      $data = $row['email'];
                      echo "<script>alert('Admin with this email already exists.')</script>";
                  }else{
                      $sql_query = "insert into admin(name,email,password,branch,role,image)values('$name','$email','$pass','$branch','$role','$image')";
                      mysqli_query($con,$sql_query);
                      header('location:view_admin.php'); 
                  }
          }
          else{
                  $sql_query = "update admin set name = '$name',email = '$email',password = '$pass',branch = '$branch',role = '$role',image = '$image' where id = $id";
                  mysqli_query($con,$sql_query);
                  header('location:view_admin.php'); 
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
            <h1>Admin Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin Form</li>
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
                <h3 class="card-title">Admin Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" name="name" value="<?php echo @$s_row['name']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Email" name="email" value="<?php echo @$s_row['email']; ?>">
                  </div>
                   <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Password" name="password" value="<?php echo @$s_row['password']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Branch Name</label>
                    <select class="form-select form-select-lg mt-1 form-control" name="branch">
                      <option selected disabled>Select Branch</option>
                     <?php 
                          $sql = "select * from branch";
                          $res = mysqli_query($con, $sql);
                          while ($row = mysqli_fetch_assoc($res)) {
                          $selected = ($s_row['branch'] == $row['branch_name']) ? "selected" : "";
                          echo "<option value='{$row['branch_name']}' $selected>{$row['branch_name']}</option>";
                          }
                       ?>    
                  </select>
                  </div>
                   <div class="form-group">
                    <label for="exampleInputEmail1">Role Name</label>
                    <select class="form-select form-select-lg mt-1 form-control" name="role">
                      <option selected disabled>Select Role</option>
                    <?php 
                        $sql = "select * from role";
                        $res = mysqli_query($con,$sql);
                        while($row = mysqli_fetch_assoc($res)){
                          $selected = ($s_row['role'] == $row['role_name']) ? "selected" : "";
                          echo "<option value='{$row['role_name']}' $selected>{$row['role_name']}</option>";
                   } ?>
                  </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Admin Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image" value="<?php echo @$s_row['slider_name']; ?>">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                  </div>
                  <div>
                    <?php if(isset($_GET['u_id'])){ ?>
                    <img src="image/admin/<?php echo @$s_row['image'] ?>" width="100px">
                  <?php } ?>
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
  

 


