@foreach ($patient as $item)
<div class="modal fade" id="editModal-{{$item->id}}" tabindex="-1" aria-labelledby="editModalLabel-{{$item->id}}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel-{{$item->id}}">Edit Patient</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form is managed by JavaScript to handle AJAX -->
        <form id="editForm-{{$item->id}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <input type="hidden" name="id" value="{{ $item->id }}">

          <div class="mb-3">
            <label for="name-{{$item->id}}" class="form-label">Name</label>
            <input type="text" class="form-control" id="name-{{$item->id}}" name="name" value="{{ $item->name }}">
          </div>

          <div class="mb-3">
            <label for="date_of_birth-{{$item->id}}" class="form-label">Date Of Birth</label>
            <input type="date" class="form-control" id="date_of_birth-{{$item->id}}" name="date_of_birth" value="{{ $item->date_of_birth }}">
          </div>

          <div class="mb-3">
            <label for="gender-{{$item->id}}" class="form-label">Gender</label>
            <select name="gender" id="gender-{{$item->id}}" class="form-control">
                <option value="">--- Pilih Gender ---</option>
                <option value="M" {{ $item->gender === 'M' ? 'selected' : '' }}>Male</option>
                <option value="F" {{ $item->gender === 'F' ? 'selected' : '' }}>Female</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="address-{{$item->id}}" class="form-label">Address</label>
            <textarea name="address" id="address-{{$item->id}}" class="form-control" cols="30" rows="10">{{ $item->address }}</textarea>
          </div>

          <div class="mb-3">
            <label for="email-{{$item->id}}" class="form-label">Email</label>
            <input type="email" class="form-control" id="email-{{$item->id}}" name="email" value="{{ $item->email }}">
          </div>

          <div class="mb-3">
            <label for="phone_number-{{$item->id}}" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone_number-{{$item->id}}" name="phone_number" value="{{ $item->phone_number }}">
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
