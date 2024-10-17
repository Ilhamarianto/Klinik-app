<x-header></x-header>
<x-navbar></x-navbar>

<body class="vertical light">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h1 class="page-title">Create New Users</h1>
                        <div class="card">
                            <div class="container">
                                <form action="{{ route('users.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" name="name" id="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" name="email" id="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" name="password" id="password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password:</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role:</label>
                                        <select name="role" id="role "  class="form-control">
                                            <option name="role" value=""  class="form-control">--Pilih role --</option>
                                            <option name="role" value="patient"  class="form-control">Patients</option>
                                            <option name="role" value="docotrs"  class="form-control">Doctors</option>
                                            <option name="role" value="nurses" class="form-control">Nurses</option>
                                        </select>
                                        {{-- <input type="text" name="role" id="role" class="form-control" required> --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Active Status:</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" value="Active">
                                            <label class="custom-control-label" for="status">Toggle to set Active/Inactive</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
