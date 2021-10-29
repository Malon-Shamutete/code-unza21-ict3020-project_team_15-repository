<?php
session_start();
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){


   if(!empty($_POST['email']) && !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['mobile']) && !empty($_POST['dept']) && !empty($_POST['id']) && !empty($_POST['program'])){

    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);
    $email = trim($_POST["email"]);
    $dept = trim($_POST["dept"]);
    $prog = trim($_POST["program"]);
    $phone = trim($_POST["mobile"]);
    $comp = trim($_POST["id"]);
    $date = date('d:m:Y');
    $pass = "123456";
    $str = 'Password';
    $salt = 'sdfrwurnvrjks';
    $pass = md5($pass.$salt);
    $active = 1;
 
    
        // Prepare an insert statement
        $sql = "INSERT INTO users (fname,lname,email,dept,prog,phone,computer,pass,date_,active) VALUES (?, ?, ?,?,?,?,?,?,?,?)";
 
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssssssi", $fname, $lname,$email,$dept,$prog,$phone,$comp,$pass,$date,$active);
            
           
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                //header("location: index.php");
               // exit();
               $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
               <strong>User registered!</strong> wel done.
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
            } else{
                $error = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Error !</strong> please check your inputs.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
        }
         
        // Close statement
        $stmt->close();

    
    // Close connection
    $mysqli->close();



   }

  
 
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - </title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php
        include('navbar.php');
        ?>
        <div id="layoutSidenav">
            <?php
            include('sidebar.php');
            ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">REGISTER USER</h1>
                      <?php  
                      include('navigation.php');

                      if(!empty($error)){
                          echo $error;
                      }elseif(!empty($success)){
                          echo $success;
                      }
                      ?>
                        <div class="card mb-4">
                            <div class="card-body">
                            <form class="row g-3" action="register.php"  method="POST">
                            <div class="col-md-6">
    <label for="inputEmail4" class="form-label">First Name</label>
    <input type="text" name="fname" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Last Name</label>
    <input type="text" name="lname" class="form-control"  required>
  </div>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" id="inputEmail4" required>
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Mobile</label>
    <input type="text" name="mobile" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Identity</label>
    <input type="text" name="id" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Program</label>
    <input type="text" name="program" class="form-control" required>
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">Department</label>
    <input type="text" class="form-control" name="dept" id="inputAddress" placeholder="enter dept" required>
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-dark">Submit</button>
  </div>
</form>





                            </div>
                        </div>
                
                        
                    </div>
                </main>
              <?php
              include('footer.php');
              ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
