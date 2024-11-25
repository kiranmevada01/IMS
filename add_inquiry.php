<?php include_once 'header.php';
  include_once 'db.php';
  $s_row = []; 
    if (isset($_GET['u_id'])) {
      	$id = $_GET['u_id'];
		    $sql_data = "select * from inquiry where id = $id";
    	 $data = mysqli_query($con,$sql_data);
    	$s_row = mysqli_fetch_assoc($data);
    }
   if(isset($_POST['save'])){
      $name = $_POST['name'];
      $contact = $_POST['contact'];
      $email = $_POST['email'];
      $date = $_POST['date'];
      $course = $_POST['course']?? ($s_row['course'] ?? '');
      $status = $_POST['status'] ?? ($s_row['status'] ?? '');
      $reference = $_POST['reference'];
      $education = $_POST['education'];
      $fees = $_POST['fees'];
      $details = $_POST['details'];
      $added = $_POST['added_by']?? ($s_row['added_by'] ?? '');
         
       if(!isset($_GET['u_id'])){
            $sql_select = "select * from inquiry where name = '$name'";
            $data = mysqli_query($con,$sql_select);
            $cnt = mysqli_num_rows($data);
            if($cnt == 1){
                echo "<script>alert('This Inquiry already exists.')</script>";
            }else{
               $sql_query = "insert into inquiry(name,contact,email,date,status,course,reference,education,fees,details,added_by)values('$name','$contact','$email','$date','$status','$course','$reference','$education','$fees','$details','$added')";
                mysqli_query($con,$sql_query);
                header('location:view_status.php');
            }
        }
        else{
             $sql_query = "update inquiry set name = '$name',contact = '$contact',email = '$email',date = '$date',status = '$status',course = '$course',reference = '$reference',education = '$education',fees = '$fees',details = '$details',added_by = '$added' where id = $id";
              mysqli_query($con,$sql_query);
              header('location:view_inquiry.php'); 
        }
  }
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Inquiry Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Inquiry Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Inquiry Form Details</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
         <form method="post">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
              	<div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control my-colorpicker1" placeholder="Enter Name" name="name" value="<?php echo @$s_row['name']; ?>">
                </div>
                <div class="form-group">
                  <label>Contact</label>
                  <input type="text" class="form-control my-colorpicker1" placeholder="Enter Contact" name="contact" value="<?php echo @$s_row['contact']; ?>">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control my-colorpicker1" placeholder="Enter Email" name="email" value="<?php echo @$s_row['email']; ?>">
                </div>
                <div class="form-group">
                    <label>Intrested Course</label>
                    <select class="form-control select2" style="width: 100%;" name="course">
                      <option selected disabled>Select Course</option>
                       <?php 
                          $sql = "select * from courses";
                          $res = mysqli_query($con, $sql);
                          while ($row = mysqli_fetch_assoc($res)) {
                          $selected = ($s_row['course'] == $row['c_name']) ? "selected" : "";
                          echo "<option value='{$row['c_name']}' $selected>{$row['c_name']}</option>";
                          }
                       ?>     
                  </select>
                </div>
                 <div class="form-group">
                  <label>Date</label>
                    <input type="date" class="form-control my-colorpicker1" id="exampleInputPassword1" name="date" value="<?php echo @$s_row['date']; ?>">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control select2" style="width: 100%;" name="status">
                      <option selected disabled>Select Status</option>
                       <?php 
                          $sql = "select * from status";
                          $res = mysqli_query($con, $sql);
                          while ($row = mysqli_fetch_assoc($res)) {
                          $selected = ($s_row['status'] == $row['s_name']) ? "selected" : "";
                          echo "<option value='{$row['s_name']}' $selected>{$row['s_name']}</option>";
                          }
                       ?>     
                  </select>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Reference</label>
                  <input type="text" class="form-control my-colorpicker1" placeholder="Enter Refrence" name="reference" value="<?php echo @$s_row['reference']; ?>">
                </div>
                <div class="form-group">
                  <label>Education</label>
                  <input type="text" class="form-control my-colorpicker1" placeholder="Enter Education" name="education" value="<?php echo @$s_row['education']; ?>">
                </div>
                <div class="form-group">
                  <label>Fees</label>
                  <input type="text" class="form-control my-colorpicker1" placeholder="Enter Fees" name="fees" value="<?php echo @$s_row['fees']; ?>">
                </div>
                <div class="form-group">
                  <label>Inquiry Details</label>
                  <input type="text" class="form-control my-colorpicker1" placeholder="Enter Details" name="details" value="<?php echo @$s_row['details']; ?>">
                </div>
                <div class="form-group">
                    <label>Added By</label>
                    <select class="form-control select2" style="width: 100%;" name="added_by">
                      <option selected disabled>Added By</option>
                        <?php 
                          $role = $_SESSION['login_role'];
                          $sql = "select * from admin";
                          $res = mysqli_query($con, $sql);
                          while ($row = mysqli_fetch_assoc($res)) {
                          $selected = ($role == $row['role']) ? "selected" : "";
                          echo "<option value='{$row['role']}' $selected>{$row['role']}</option>";
                          }
                        ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
           <div class="card-footer">
                 <input type="submit" class="btn btn-primary" name="save" value="submit">
            </div>
         </form>
        </div>
      </div>
    </section>
  </div>
 
   <?php include_once 'footer.php'; ?>
  

 


