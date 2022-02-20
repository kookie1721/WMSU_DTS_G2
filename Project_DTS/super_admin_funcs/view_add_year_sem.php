<div class="modal fade" id="add_year_sem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add School Year and Semester</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../super_admin_funcs/add_year_sem.php" method="post">
        <div class="modal-body">
            <div class="form-floating mb-3">
              <input type="number" class="form-control" id="schoolYear" name="schoolYear" min="2020" max="2030" required>
              <label for="schoolYear">Year:</label>
            </div>

            <select name="semester" class="form-select text-dark" name="semester" aria-label="Default select example" required>
              <option selected>Select Semester:</option>
              <option value="1st semester">1st semester</option>
              <option value="2nd semester">2nd semester</option>
            </select>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="add" class="btn btn-success">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>