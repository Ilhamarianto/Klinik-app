<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Patients</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="form-group mb3">
                <label for="name">Full Name</label>
                <input type="text" id="name" class="form-control">
            </div>
            <div class="form-group mb3">
                <label for="date_of_birth"> Date of Birth</label>
                <input type="date" id="date_of_birth" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label for="gender"> Gender</label>
                <select name="gender" id="gender" class="form-control">
                    <option value="">--- Pilih Gender ---</option>
                    <option name="gender" id="gender" value="M">Male</option>
                    <option name="gender" id="gender" value="F">Female</option>
                </select>
            </div>

             <div class="form-group mb3">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" class="form-control">
            </div>
             <div class="form-group mb3">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label class="font-weight-bold">address</label>
                <textarea name="address" id="address" class="form-control"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="saveChanges" class="btn btn-primary">Save changes</button>
        </div>
    </div>
  </div>
</div>
