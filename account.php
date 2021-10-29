<?php
session_start();

include('config.php');
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){


    // Processing form data when form is submitted
    if(isset($_POST["id"]) && !empty($_POST["id"])){
        // Get hidden input value
        $id = $_POST["id"];
        
        // Check input errors before inserting in database
        if(!empty($_POST['email']) && !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['mobile']) && !empty($_POST['dept']) && !empty($_POST['id']) && !empty($_POST['program'])){

            $fname = trim($_POST["fname"]);
            $lname = trim($_POST["lname"]);
            $email = trim($_POST["email"]);
            $dept = trim($_POST["dept"]);
            $prog = trim($_POST["program"]);
            $phone = trim($_POST["mobile"]);
            $comp = trim($_POST["id"]);
            $active = 1;
            // Prepare an update statement
            $sql = "UPDATE users SET fname=?, lname=?, email=?,dept=?,prog=?,phone=?,computer=? WHERE id=? and active=?";
             
            if($stmt = mysqli_prepare($mysqli, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssssssssi", $fname, $lname, $email, $dept,$prog,$phone,$comp,$_GET['id'],$active);
                
            
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Records updated successfully. Redirect to landing page
                    $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
               <strong>User registered!</strong> well done.
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
                } else{
                    $error = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error !</strong> please check your inputs.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                }
            }
             
           
        }
        
      
    } 
    


      // Validate credentials
      if( !empty($_POST['pass']) && !empty($_POST['pass1']) && !empty($_POST['pass2']) && $_POST['pass']==$_POST['pass1']){

     
        $pass4 = trim($_POST["pass2"]);
        $pass5 = trim($_POST["pass"]);
        // Prepare a select statement
        $sql = "SELECT pass FROM users WHERE id = ?";
        
        if($stmt = mysqli_prepare($mysqli, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['id']);
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
         
             
                $salt = 'sdfrwurnvrjks';
                $pass = md5($pass4.$salt);
                $pass_real = md5($pass5.$salt);
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $hashed_password);
                    
                    if(mysqli_stmt_fetch($stmt)){
                        if($pass == $hashed_password){
                            // Password is correct, so start a new session
                           $active = 1;
                            
                            // Store data in session variables
                            $sql = "UPDATE users SET pass=? WHERE id=? and active=?";

                            if($stmt = mysqli_prepare($mysqli, $sql)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "ssi", $pass_real,$_GET['id'],$active);
                                
                            
                                
                                // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                    // Records updated successfully. Redirect to landing page
                                    $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                               <strong>Password Changed!</strong> 
                               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                             </div>';
                                } else{
                                    $error = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Error !</strong> please check your inputs.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>';
                                }                     
                            
                            // Redirect user to welcome page
                          
                        } else{
                            // Password is not valid, display a generic error message
                            $error = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error !</strong> please check your inputs.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $error = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error !</strong> please check your inputs.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                }
            } else{
                $error = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error !</strong> please check your inputs.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
            }

            // Close statement
           
        }
    }
    
    // Close connection
    
      }
    }







// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT fname,lname,email,dept,prog,phone,computer,pass,date_ FROM users WHERE id = ?";
    
    if($stmt = mysqli_prepare($mysqli, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $fname = $row["fname"];
                $lname = $row["lname"];
                $email = $row["email"];
                $dept = $row["dept"];
                $prog = $row["prog"];
                $phone = $row["phone"];
                $comp = $row["computer"];
               
              
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                $error = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Error !</strong> please check your inputs.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
            
        } else{
            $error = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error !</strong> please check your inputs.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($mysqli);
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
        <title>Account - </title>
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
                        <h1 class="mt-4">ACCOUNT </h1>
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
                            <form class="row g-3" action="account.php?id=<?php echo $_GET['id'];?>"  method="POST">
                            <div class="col-md-6">
    <label for="inputEmail4" class="form-label">First Name</label>
    <input type="text" name="fname" value ="<?php echo (!empty($fname)) ? $fname : '';?>" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Last Name</label>
    <input type="text" name="lname" value ="<?php echo (!empty($lname)) ? $lname : '';?>" class="form-control"  required>
  </div>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Email</label>
    <input type="email" name="email" value ="<?php echo (!empty($email)) ? $email : '';?>" class="form-control" id="inputEmail4" required>
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Mobile</label>
    <input type="text" name="mobile"  value ="<?php echo (!empty($phone)) ? $phone : '';?>" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Identity</label>
    <input type="text" name="id" value ="<?php echo (!empty($comp)) ? $comp : '';?>" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Program</label>
    <input type="text" name="program" value ="<?php echo (!empty($prog)) ? $prog : '';?>" class="form-control" required>
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">Department</label>
    <input type="text" class="form-control" value ="<?php echo (!empty($dept)) ? $dept : '';?>" name="dept" id="inputAddress" placeholder="enter dept" required>
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-sm btn-dark">Submit</button>
  </div>
</form>
<br>
<form class="row g-3" action="account.php?password=true&id=<?php echo $_GET['id'];?>"  method="POST">
                            <div class="col-md-6">
    <label for="inputEmail4" class="form-label">NewPassword</label>
    <input type="text" name="pass" placeholder="New Password" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Re-enter Password</label>
    <input type="text" name="pass1"  placeholder="Re-enter Password" class="form-control"  required>
  </div>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Old password</label>
    <input type="text" name="pass2"  placeholder="Old Password" class="form-control"  required>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-sm btn-dark">Submit</button>
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
