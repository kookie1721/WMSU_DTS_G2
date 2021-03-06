<?php
session_start();
if(!isset($_SESSION["c_username"])) {
  header("location: ../index.php");
}
?>

<?php
//include our connection
include_once('../include/database.php');

$database = new Connection();
$db = $database->open();
try{	
    $sql = "SELECT * FROM documents 
    WHERE documents.trackingID = '".$_POST['trackingID']."';";
    foreach ($db->query($sql) as $row) {
      }
    }
catch(PDOException $e){
    echo "There is some problem in connection: " . $e->getMessage();
    }

    //close connection
    $database->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/wmsu_logo.png"/>
    <title>Release Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/footer.css">
</head>
<body style="background-color:#fff;">
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

    <nav class="navbar navbar-expand-sm navbar-dark border-bottom border-dark" style="background-color:#8e0413;">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold">WMSU|DTS</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link fw-bold" href="HomePageC.php">Home</a>
              </li> 

              <li class="nav-item">
                <a class="nav-link fw-bold text-white">--></a>
              </li>

              <?php
              if($_POST['status'] == 'draft'){
                ?>
                  <li class="nav-item">
                    <a class="nav-link fw-bold" href="pending_docs.php" aria-current="page">Pending Documents</a>
                  </li>
                <?php
              } 
              elseif($_POST['status'] != 'draft')
              {
                ?>
                <li class="nav-item">
                  <a class="nav-link fw-bold" href="office_docs.php" aria-current="page">Office Documents</a>
                </li>
              <?php
              }
              
              ?>
              

              <li class="nav-item">
                <a class="nav-link fw-bold text-white">--></a>
              </li>
              <?php if(empty($row)){
                ?>
                  <li class="nav-item">
                    <a class="nav-link fw-bold text-white">INCORRECT TRACKING ID!</a>
                  </li>
                <?php
              }
              else{
                ?>
                  <li class="nav-item">
                    <a class="nav-link fw-bold text-white"><?php echo $_POST['trackingID'];?></a>
                  </li>
                <?php
              }
              ?>
              

            </ul>
          </div>
        </div>
      </nav>
      <br>
      <br>
      
      <div class="container text-center">
        <h4>RELEASE DOCUMENT</h4>
        <?php
        if(empty($row)){
          $_SESSION['e_message'] = "The tracking ID is incorrect! Please double check it and try again!";
          $_SESSION['e_id'] = $_POST['trackingID'];
            header("Location: ../clerk/HomePageC.php?error=incorrect?id");
            die();
        }
        ?>
      </div>

      <br>

      <div class="container">
        <div id="liveAlertPlaceholder"></div>
      </div>

      <hr style="color: black;">
      <br>

      <div class="container">

        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                  <th class="text-center fs-4" colspan="2">OVERVIEW OF <?php echo $_POST['trackingID'];?></th>
                </tr>
            </thead>

            <tbody>
              <tr>
                <th class="fs-5 text-center">
                    Tracking ID:
                </th>

                <td class="fs-5 text-center">
                    <?php echo $row['trackingID'];?>
                </td>
              </tr>

              <tr>
                  <th class="fs-5 text-center">
                      Title:
                  </th>

                  <td class="fs-5 text-center">
                      <?php echo $row['title'];?>
                  </td>
              </tr>

              <tr>
                  <th class="fs-5 text-center">
                      Type:
                  </th>

                  <td class="fs-5 text-center">
                      <?php echo $row['type'];?>
                  </td>
              </tr>

              <tr>
                  <th class="fs-5 text-center">
                      Reason:
                  </th>

                  <td class="fs-5 text-center">
                      <?php echo $row['reason'];?>
                  </td>
              </tr>

              <tr>
                  <th class="fs-5 text-center">
                      Status:
                  </th>

                  <td class="fs-5 text-center">
                    <?php
                        if ($row['status'] == "draft"){
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
              </tr>
            </tbody>
          </table>
        </div>


        <form action="../clerk_funcs/release_doc_func.php"  id="mainSec" method="POST">
          <br>
          <br>
          <input type="number" name="userID" class="form-control border border-dark" value="<?php echo $_POST["userID"];?>" hidden>
          
          <?php 
          if($_POST['status'] == 'draft'){
            ?>
              <div class="row">
                <div class="col md-4">
                  <div class="input-group mb-3">
                  <label class="input-group-text" for="trackingID">Tracking ID</label>
                  <input type="text" class="form-control" name="trackingID" value="<?php echo $_POST['trackingID']?>" id = "trackingID" readonly>
                  </div>
                  <p class="text-center text-muted fw-bold">Tracking ID of the document.</p>
                </div>

                <div class="col md-4">
                <p class="text-center text-muted fw-bold">After confirmation, the document will be tag as released.</p>
                </div>

                <input type="text" name="action" value="released" hidden>

              </div>
            <?php
            
          }
          elseif($_POST['status'] != 'draft')
          {
            ?>
             <div class="row">
              <div class="col md-4">
                <div class="input-group mb-3">
                <label class="input-group-text" for="trackingID">Tracking ID</label>
                <input type="text" class="form-control" name="trackingID" value="<?php echo $_POST['trackingID']?>" id = "trackingID" readonly>
                </div>
                <p class="text-center text-muted fw-bold">Tracking ID of the document.</p>
              </div>

                
              <div class="col md-4">
                <div class="input-group mb-3">
                <select class="form-select text-dark" name="action" id = "action" onchange="checkvalue(this.value)" required>
                  <option value="" selected>Please select the action.</option>
                  <option value="Endorse">Endorsed</option>
                  <option value="Approved">Approved</option>
                  <option value="Disapproved">Disapproved</option>
                  <option value="No action">No action</option>
                  <option value="Received">Received</option>
                  <option value="Return to sender">Return to sender</option>
                  <option value="other">Other</option>
                </select> 
                </div>
                <input type="text" name="oaction" id="checkA" placeholder="Please enter here the action:" style='display:none'>
                <p class="text-center text-muted fw-bold"> Enter the appropriate action that was made in this office.</p>
              </div>
            </div>

            <?php
          }
          ?>
          
          <br>
          <br>
          <br>
        </form>
        <div class="d-flex justify-content-center">
            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
              <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#resetModal">Reset</button>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sendModal">Save changes</button>
            </div>
          </div>
      </div>
      <br>
      <br>
      <br>
      
      <!-- Modal for reset button-->
      <div class="modal fade" id="resetModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="resetModalLabel">Reset</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <p>Are you sure to reset all the fields?</p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" for>No</button>
              <button type="reset" class="btn btn-success" id="liveAlertBtn" data-bs-dismiss="modal" form="mainSec">Yes</button>
              
           </div>
         </div>
       </div>
      </div>

     
      <!-- Modal for finalize document-->
      <div class="modal fade" id="sendModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
          <?php if(isset($_POST['release_mod'])){
            ?>
            <div class="modal-header">
              <h5 class="modal-title" id="finalModalLabel">Update Status</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
             
              <div class="modal-body">
                <p style="text-align: center;color:green;">This will update the status of the document, based in the chosen action. Make the changes??</p>
              </div>
              <?php
            }
            else{
              if($_POST['status'] == 'draft'){
                ?>
                  <div class="modal-header">
                  <h5 class="modal-title" id="finalModalLabel">Release Document</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    <p style="text-align: center;color:green;">Do you wish to release this document now? After confirmation the document will be now tagged as release.
                      <br>
                      <br>
                      Note: The status of the document will be 'release' now and it is now possible for other offices to process it.
                    </p>
                  </div>
                <?php
              }
              ?>
              <?php
            }
              ?>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" for>No</button>
              <button type="submit" name="submit" class="btn btn-success" data-bs-dismiss="modal" form="mainSec">Yes</button>
           </div>
         </div>
       </div>
      </div>

      <script>
        function checkvalue(val)
          {
              if(val==="other")
              {
                document.getElementById('checkA').style.display='block';
                document.getElementById('checkA').style.marginTop='10px';
              }
              else{
                document.getElementById('checkA').style.display='none'; 
              }
                
          }
        </script>



      <script>
        var alertPlaceholder = document.getElementById('liveAlertPlaceholder')
        var alertTrigger = document.getElementById('liveAlertBtn')

        function alert(message, type) {
          var wrapper = document.createElement('div')
          wrapper.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'

          alertPlaceholder.append(wrapper)
        }

        if (alertTrigger) {
          alertTrigger.addEventListener('click', function () {
            alert('Fields has been successfully reset', 'success')
          })
        }

      </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>