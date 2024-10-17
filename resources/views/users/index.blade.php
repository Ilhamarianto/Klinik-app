<x-header></x-header>
<x-navbar></x-navbar>

<body class="vertical light">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h1 class="page-title">Data Users</h1>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">Create New User</a>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->role }}</td>
                                                <td>
                                                    <form action="{{ route('users.updateStatus', $user->id) }}" method="POST" class="update-status-form">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" id="customSwitch{{ $user->id }}" name="status" {{ $user->status === 'active' ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="customSwitch{{ $user->id }}">{{ $user->status === 'active' ? 'active' : 'inactive' }}</label>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

<script>
    document.querySelectorAll('.custom-switch input').forEach(function(switchElement) {
        switchElement.addEventListener('change', function() {
            const form = this.closest('form');
            const formData = new FormData(form);
            const status = this.checked ? 'active' : 'inactive'; // Use 'Active' and 'Inactive'

            fetch(form.action, {
                method: 'PUT',
                body: new URLSearchParams({
                    '_token': formData.get('_token'),
                    'status': status
                }),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    form.querySelector('.custom-control-label').textContent = status;
                    alert('Status updated successfully.');
                } else {
                    alert('Failed to update status.');
                    this.checked = !this.checked; // Revert switch state if update fails
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update status.');
                this.checked = !this.checked; // Revert switch state if update fails
            });
        });
    });
</script>



</body>
