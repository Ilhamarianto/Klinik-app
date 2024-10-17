<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Nurses</h5>
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
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" class="form-control">
            </div>
             <div class="form-group mb3">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label class="font-weight-bold">Image</label>
                <input type="file" id="image" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="saveChanges" class="btn btn-primary">Save changes</button>
        </div>
    </div>
  </div>
</div>
