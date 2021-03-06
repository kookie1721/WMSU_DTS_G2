<?php
include ("../include/alt_db.php");
try {

  $query = "SELECT * FROM office WHERE officeName = '".$_SESSION['a_officeName']."'";
  $result = mysqli_query($data, $query);
  $row = mysqli_fetch_array($result);
}
catch(PDOException $e) {
  $_SESSION['message_fail'] = $e->getMessage();
}
?>
<div class="modal fade" id="add_clerk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Clerk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../admin_funcs/add_clerk.php" method="post">
        <input name="added_by" type="text" value="<?php echo $_SESSION['a_name'];?>" hidden>
        <input name="office" type="text" value="<?php echo $_SESSION['a_officeName'];?>" hidden>
        <div class="modal-body">
            <label for="office">Office:</label>
                <select class="form-select text-dark" name="officeName" id="officeName" readonly>
                  <option selected value="<?php echo $_SESSION['a_officeName']?>"><?php echo $_SESSION['a_officeName']." - ".$row['description']?></option>
                </select>

                <br>
                
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
              <label for="name">Name:</label>
            </div>

            <div class="form-floating mb-3">
              <input title="Please enter the correct email format (eg. xxx@xxx.com)" pattern='^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$' type="email" class="form-control" id="username" name="username" placeholder="Username" required>
              <label for="username">Email:</label>
            </div>

            <div class="form-floating mb-3">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
              <label for="password">Password:</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="userType" name="userType" value="clerk" hidden>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="add" class="btn btn-success">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>