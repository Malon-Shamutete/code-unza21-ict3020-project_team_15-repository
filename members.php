<?php
session_start();

    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT id,fname,lname,email,dept,prog,phone,computer,pass,date_ FROM users WHERE active = 1";
    $result = mysqli_query($mysqli, $sql);
 
      
        
        

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Members - </title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
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
                        <h1 class="mt-4">MEMBERS</h1>
                      <?php
                      include('navigation.php');
                      ?>
                        <div class="card mb-4">
                            <div class="card-body">
                               
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>FirstName</th>
                                            <th>LastName</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Dept</th>
                                            <th>ID</th>
                                            <th>Program</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                            <th>FirstName</th>
                                            <th>LastName</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Dept</th>
                                            <th>ID</th>
                                            <th>Program</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>


                                    <?php
                                    
                                    if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '
                                            <tr>
                                            <td>'.$row['fname'].'</td>
                                            <td>'.$row['lname'].'</td>
                                            <td>'.$row['email'].'</td>
                                            <td>'.$row['phone'].'</td>
                                            <td>'.$row['dept'].'</td>
                                            <td>'.$row['computer'].'</td>
                                            <td>'.$row['prog'].'</td>
                                            <td>'.$row['date_'].'</td>
                                            <td> 
                            
<!-- Button trigger modal -->
<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal_'.$row['id'].'">
  Delete
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal_'.$row['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel">Delete Member</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete user <b>'.$row['fname'].' '.$row['lname'].'</b> ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="deleteuser.php?id='.$row['id'].'" class="btn btn-sm btn-dark">Delete</a>
      </div>
    </div>
  </div>
</div>
                                            
                                            </td>
                                            
                                           </tr>
                                            ';
                                        }
                                      }
                                    
                                    ?>
 
                                    </tbody>
                                </table>
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
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
