@foreach ($nurses as $item)
<div class="modal fade" id="editModal-{{$item->id}}" tabindex="-1" aria-labelledby="editModalLabel-{{$item->id}}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel-{{$item->id}}">Edit Nurse</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form is managed by JavaScript to handle AJAX -->
        <form id="editForm-{{$item->id}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <input type="hidden" id="nurse_id-{{$item->id}}" value="{{ $item->id }}">

          <div class="mb-3">
            <label for="name-{{$item->id}}" class="form-label">Name</label>
            <input type="text" class="form-control" id="name-{{$item->id}}" value="{{ $item->name }}">
          </div>

          <div class="mb-3">
            <label for="email-{{$item->id}}" class="form-label">Email</label>
            <input type="email" class="form-control" id="email-{{$item->id}}" value="{{ $item->email }}">
          </div>

          <div class="mb-3">
            <label for="phone_number-{{$item->id}}" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone_number-{{$item->id}}" value="{{ $item->phone_number }}">
          </div>

          <div class="mb-3">
            <label for="image-{{$item->id}}" class="form-label">Image</label>
            <input type="file" class="form-control" id="image-{{$item->id}}" accept="image/*">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="saveChangesBtn-{{$item->id}}" class="btn btn-primary saveChangesBtn" data-id="{{$item->id}}">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
