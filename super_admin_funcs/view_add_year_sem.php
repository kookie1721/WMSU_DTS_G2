<?php 
if(empty($row1)){
$_SESSION['year_m'] = "No school year. Please add it first as soon as possible.";
}

?>

<div class="modal fade" id="add_year_sem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add School Year</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/add_year_sem.php" method="post">
        <div class="modal-body">
            <?php
            if(empty($row2)){
              ?>
                <div class="container">
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div style="margin-left:10px;text-align:center;">
                            <?php 
                                echo "<h5>No date range set for semesters and summer. Please add it as soon as possible by initializing default date range first.<h5>";
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
              <?php
            }
            else {

                $first_sem = strtotime($row2['first_sem_date']);
                $end_first_sem = strtotime($row2['end_first_sem_date']);
                $second_sem = strtotime($row2['sec_sem_date']);
                $end_second_sem = strtotime($row2['end_sec_sem_date']);

                $summer = strtotime($row2['summer_date']);
                $end_summer = strtotime($row2['end_summer_date']);

                $first_sem_date = date("m-d", $first_sem);
                $e_first_sem_date = date("m-d", $end_first_sem);

                $second_sem_date = date("m-d", $second_sem);
                $e_second_sem_date = date("m-d", $end_second_sem);

                $summer_date = date("m-d", $summer);
                $e_summer_date = date("m-d", $end_summer);


                if($first_sem_date <= date("m-d") && date("m-d") <= $e_first_sem_date){
                    $status = "1st semester";
                }
                else if($second_sem_date <= date("m-d") && date("m-d") <=  $e_second_sem_date) {
                    $status = "2nd semester";
                }
                else if($summer_date <= date("m-d") && date("m-d") <=  $e_summer_date){
                    $status = "summer";
              }
              ?>
                <div class="row d-flex justify-content-center align-content-center">
                  <div class="col">
                    <div class="form-floating mb-3">
                      <input type="number" class="form-control" id="startYear" name="startYear" min="2020" max="2030" required>
                      <label for="startYear">Year:</label>
                    </div>     
                  </div>

                  <div class="col-1">
                      <span>TO</span>
                  </div>

                  <div class="col">
                    <div class="form-floating mb-3">
                      <input type="number" class="form-control" id="endYear" name="endYear" min="2020" max="2030" required>
                      <label for="endYear">Year:</label>
                    </div>
                  </div>
                </div>

                <input type="text" class="form-control" id="status" name="status" value="<?php echo $status?>" hidden>

              <?php

                if(empty($row1)){
                  ?>  
                  <select class="form-select text-dark" name="activate" id="officeName" required>
                    <option value="" selected>Activate: click to select yes/no</option>
                    <option value="yes">Activate: yes</option>
                    <option value="no">Activate: no</option>
                  </select>
                  <?php
                }
                elseif(!empty($row1)){
                  ?>
                  <select class="form-select text-dark" name="activate" id="officeName" required>
                    <option value="no" selected>Activate: no</option>
                  </select>

                  <br>
                  <p style="text-align:center;color:red;">Note: There is already an active school year. you can still add school years,
                  however it is not possible to have more than 1 active school year at the same time.
                  </p>
                  <?php
                }
                ?>
                <br>
                <p style="text-align:center;color:green;">Note: The semester/summer is automatically set base on the date range set by the system.
                  If you want to change the date range, please click the "edit date range" button to change
                  the date range of semester/summer.
                </p>

                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                  <button type="submit" name="add" class="btn btn-success">Save changes</button>
                </div>
              <?php
            }
              ?>                  
        </div>
      </form>
    </div>
  </div>
</div>