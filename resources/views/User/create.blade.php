<!DOCTYPE html>
<html lang="en">

@include('header')

<body class="user-profile">
    <div class="wrapper ">
        @include('sidebar')
        <div class="main-panel" id="main-panel">
            <!-- Navbar -->

            @include('navbar')
            <!-- End Navbar -->
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="title">Adding User</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('user.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">User Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter user Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="priority" class="form-label">Qualification</label>
                                        <input type="text" class="form-control" id="qualification" name="qualification" placeholder="Enter Qualification" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="priority" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="priority" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="priority" class="form-label">Mobile No</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile No." required>
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-control" id="department" name="department" required>
                                            <option value="" disabled selected>Select Department</option>
                                            @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="priority" class="form-label">User Role</label>

                                        <select class="form-control" id="role" name="role" required>
                                            <option value="" disabled selected>Select Role</option>
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>

                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-round btn-primary me-2">Save</button>
                                        <a href="{{ route('user.index') }}" class="btn btn-round btn-secondary">Cancel</a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>
            </div>
            @include('footer')
        </div>
    </div>
    @include('js')
    <!-- Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (session('success'))
                        {{ session('success') }}
                    @elseif (session('error'))
                        {{ session('error') }}
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    @if (session('success') || session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
                statusModal.show();
            });
        </script>
    @endif
</body>

</html>
