<?php
session_start();
if(!isset($_SESSION["a_username"])) {
  header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Received Documents</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/loading.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    <div id="preloader">
	</div>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </symbol>
    </svg>

    <input type="checkbox" id="nav-toggle">
    
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="las la-book"></span> <span>WMSU|DTS</span></h2>
        </div>
        <div class="sidebar-menu">
        <ul>
                <li>
                    <a href="homePageAdmin.php"><span class="las la-home"></span>
                    <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="clerk_users.php"><span class="las la-search-location"></span>
                    <span>Clerk Users</span></a>
                </li>
                <li>
                    <a href="view_track.php"><span class="las la-search-location"></span>
                    <span>Track Documents</span></a>
                </li>
                <li>
                    <a href="office_docs.php"><span class="las la-file-alt"></span>
                    <span>Office Documents</span></a>
                </li>
                <li>
                    <a href="pending_docs.php"><span class="las la-arrow-circle-up"></span>
                    <span>Pending For Release</span></a>
                </li>
                <li>
                    <a class="active"><span class="las la-arrow-circle-down"></span>
                    <span>Received</span></a>
                </li>
                <li>
                    <a href="released_docs.php"><span class="las la-chevron-circle-up"></span>
                    <span>Released</span></a>
                </li>   
             
               
            </ul>
        </div>
    </div>

    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>
                Received Documents
            </h2>

            <div class="user-wrapper">
                <div class="profile" onclick="menuToggle();">
                    <img src="../assets/img/wmsu_logo.png" alt="user">
                </div>   
                <div class="menu">
                    <h3><?php echo $_SESSION["a_username"]; ?>  (<?php echo $_SESSION['a_officeName']; ?>) <span>admin</span></h3> 
                    <ul>
                        <?php
                            //include our connection
                            include_once('../include/database.php');

                            $database = new Connection();
                            $db = $database->open();
                            try{	
                                $sql = "SELECT * FROM users WHERE username = '".$_SESSION['a_username']."'";
                    
                                foreach ($db->query($sql) as $row) {
                                ?>
                                    <li> <i class="las la-user-tie"></i> <a data-bs-toggle="modal" data-bs-target="#edit_profile<?php echo $row['id']; ?>">Edit Profile</a> </li>
                                <?php
                                
                                }
                            }
                            catch(PDOException $e){
                                echo "There is some problem in connection: " . $e->getMessage();
                            }

                            //close connection
                            $database->close();
                        ?>

                        <li> <i class="las la-file-export"></i> <a type="button" href="view_generate.php">Generate Report</a> </li>
                        <li> <i class="las la-chevron-circle-right"></i> <a type="button" data-bs-toggle="modal" data-bs-target="#logout_modal">Logout</a> </li>
                    </ul>
                              
                </div>
            </div>
        </header>

        <?php  include('../admin_funcs/view_edit_profile.php'); ?>

        <main>
        <?php 
            if(isset($_SESSION['message'])){
                ?>
                <div class="container">
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <button style="margin-right:10px;" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        <div style="margin-left:10px;">
                            <?php 
                                echo $_SESSION['message'];
                            ?>
                        </div>
                    </div>
                </div>
                <?php

                unset($_SESSION['message']);
            }
        ?>
           <div class="container">
            <div class="table-responsive">
                    <table id="data_table" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>
                                    No.
                                </th>

                                <th>
                                    Tracking ID
                                </th>
                                <th>
                                    Title
                                </th>
                                <th>
                                    Type
                                </th>
                                <th>
                                    Reason
                                </th>

                                <th>
                                    Remarks
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    View
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                //include our connection
                                include_once('../include/database.php');

                                $database = new Connection();
                                $db = $database->open();
                                try{	
                                    $sql = "SELECT DISTINCT documents.*, yearsemester.schoolYear, yearsemester.stat
                                        FROM documents 
                                        INNER JOIN logs ON logs.trackingID = documents.trackingID INNER JOIN yearsemester ON yearsemester.id = documents.yearSemID
                                        WHERE logs.received_at != 'none' AND logs.office = '".$_SESSION['a_officeName']."';";
                                    $no=0;
                                    foreach ($db->query($sql) as $row) {
                                        $no++;
                            ?>
                            <tr>
                                <td>
                                    <?php echo $no ?>
                                </td>

                                <td>
                                    <?php echo $row['trackingID']; ?>
                                </td>

                                <td>
                                    <?php echo $row['title']; ?>
                                </td>

                                <td>
                                    <?php echo $row['type']; ?>
                                </td>

                                <td>
                                    <?php echo $row['reason']; ?>
                                </td>

                                <td>
                                    <?php echo $row['remarks']; ?>
                                </td>
                                <td>
                                    <?php
                                        if ($row['status'] == "pending"){
                                        ?>
                                            <span style="color: red;"><?php echo $row['status']; ?></span>
                                    <?php
                                        }
                                        else {
                                        ?>
                                            <span style="color: green;"><?php echo $row['status']; ?></span>
                                        <?php
                                        }
                                    ?>
                                    
                                </td>
                                

                                <td>
                                    <form id="viewForm" action="view_documentA.php" method="POST">
                                        <input type="text" name="track_ID" id="track_ID" value= "<?php echo $row['trackingID'];?>" hidden>
                                        <input type="text" name="title" id="title" value= "<?php echo $row['title'];?>" hidden>
                                        <input type="text" name="type" id="type" value= "<?php echo $row['type'];?>" hidden>
                                        <input type="text" name="reason" id="reason" value= "<?php echo $row['reason'];?>" hidden>
                                        <input type="text" name="remarks" id="remarks" value= "<?php echo $row['remarks'];?>" hidden>
                                        <input type="text" name="status" id="status" value= "<?php echo $row['status'];?>" hidden>
                                        <input type="text" name="file" id="file" value= "<?php echo $row['file'];?>" hidden>
                                        <input type="text" name="schoolYear" id="schoolYear" value= "<?php echo $row['schoolYear'];?>" hidden>
                                        <button id="submit" type="submit"><span class = "las la-info"></span></button>
                                    </form>
                                </td>

                            </tr>
                            
                            <?php 
                                    }
                                }
                                catch(PDOException $e){
                                    echo "There is some problem in connection: " . $e->getMessage();
                                }

                                //close connection
                                $database->close();
                            ?>
                                        
                        </tbody>
                    </table>
                </div>
           </div>
        </main>
    </div>

    <?php include('../validation/view_logout.php'); ?>

    <script>
        var loader =  document.getElementById("preloader");
        window.addEventListener("load", function(){
            loader.style.display = "none";
        })
	</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#data_table').DataTable();
        } );
    </script>

    <footer>
        <p>&copy;Copyright 2021 by <a href="#" class="text-dark">WMSU</a>.</p>
    </footer>
    
    <script>
        function menuToggle(){
            const toggleMenu = document.querySelector('.menu');
            toggleMenu.classList.toggle('active')
        }
    </script>
    
</body>
</html>