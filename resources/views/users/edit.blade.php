<x-header></x-header>
<x-navbar></x-navbar>

<body class="vertical light">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h1 class="page-title">Edit User</h1> <!-- Perubahan di sini -->
                        <div class="card">
                            <div class="container">
                                <!-- Form untuk edit user -->
                                <form action="{{ route('users.update', $user->id) }}" method="POST"> <!-- Perubahan di sini -->
                                    @csrf
                                    @method('PUT') <!-- Menggunakan PUT untuk update -->

                                    <!-- Name Field -->
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required> <!-- Populate old value -->
                                    </div>

                                    <!-- Email Field -->
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required> <!-- Populate old value -->
                                    </div>

                                    <!-- Password Field -->
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" name="password" id="password" class="form-control">
                                        <small class="form-text text-muted">Leave blank if you don't want to change the password.</small>
                                    </div>

                                    <!-- Confirm Password Field -->
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password:</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                    </div>

                                    <!-- Role Field -->
                                    <div class="form-group">
                                        <label for="role">Role:</label>
                                        <select name="role" id="role" class="form-control">
                                            <option value="">--Pilih role--</option>
                                            <option value="patient" {{ $user->role == 'patient' ? 'selected' : '' }}>Patient</option>
                                            <option value="doctors" {{ $user->role == 'doctors' ? 'selected' : '' }}>Doctor</option>
                                            <option value="nurses" {{ $user->role == 'nurses' ? 'selected' : '' }}>Nurse</option>
                                        </select>
                                    </div>

                                    <!-- Status Field -->
                                    <div class="form-group">
                                        <label for="status">Active Status:</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" value="active" {{ $user->status == 'active' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="status">Toggle to set Active/Inactive</label>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-primary">Update</button> <!-- Ubah tombol -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
