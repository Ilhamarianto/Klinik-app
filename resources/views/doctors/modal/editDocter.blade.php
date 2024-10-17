@foreach ($doctors as $item)
<div class="modal fade" id="editModal-{{$item->id}}" tabindex="-1" aria-labelledby="editModalLabel-{{$item->id}}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel-{{$item->id}}">Edit Doctor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('doctors.update', $item->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="name-{{$item->id}}" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name-{{$item->id}}" name="name" value="{{ old('name', $item->name) }}">
            @error('name')
              <div class="alert alert-danger mt-2">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="specialization-{{$item->id}}" class="form-label">Specialization</label>
            <input type="text" class="form-control @error('specialization') is-invalid @enderror" id="specialization-{{$item->id}}" name="specialization" value="{{ old('specialization', $item->specialization) }}">
            @error('specialization')
              <div class="alert alert-danger mt-2">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="email-{{$item->id}}" class="form-label">Email</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email-{{$item->id}}" name="email" value="{{ old('email', $item->email) }}">
            @error('email')
              <div class="alert alert-danger mt-2">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="phone_number-{{$item->id}}" class="form-label">Phone Number</label>
            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number-{{$item->id}}" name="phone_number" value="{{ old('phone_number', $item->phone_number) }}">
            @error('phone_number')
              <div class="alert alert-danger mt-2">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="image-{{$item->id}}" class="form-label">Image</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image-{{$item->id}}" name="image" accept="image/*">
            @error('image')
              <div class="alert alert-danger mt-2">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
