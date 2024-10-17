<x-header></x-header>
<x-navbar></x-navbar>

<body class="vertical  light  ">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h1 class="page-title">Treatments</h1>
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('treatments.create') }}" class="btn btn-primary">Add New Treatment</a>
                            </div>
                            <div class="card-body">
                            <table class="table mt-3">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Cost</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($treatments as $treatment)
                                        <tr>
                                            <td>{{ $treatment->name }}</td>
                                            <td>{{ $treatment->description }}</td>
                                            <td>{{ $treatment->cost }}</td>
                                            <td>
                                                <a href="{{ route('treatments.edit', $treatment) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('treatments.destroy', $treatment) }}" method="POST" style="display:inline;">
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
</body>

<x-footer></x-footer>
