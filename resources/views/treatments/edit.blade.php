<x-header></x-header>
<x-navbar></x-navbar>

<body class="vertical light">
    <div class="wrapper">
        <main role="main" class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <h1 class="page-title">Treatments</h1>
                        <div class="card">
                            <div class="card-header">
                                <p>Edit Treatment</p>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('treatments.update', $treatment->id) }}" method="POST">
                                    @csrf
                                    @method('PUT') <!-- Menandakan bahwa ini adalah request update -->

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $treatment->name) }}" required>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control">{{ old('description', $treatment->description) }}</textarea>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="cost">Cost</label>
                                        <input type="number" step="0.01" name="cost" id="cost" class="form-control" value="{{ old('cost', $treatment->cost) }}" required>
                                    </div>
                                    <input type="hidden" name="id" value="{{ $treatment->id }}">
                                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

<x-footer></x-footer>
