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
                                <h5 class="title">Editing user</h5>
                            </div>
                            <div class="card-body">
                            <form action="{{ route('user.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT') <!-- Use PUT method for updating resources -->
    <div class="mb-3">
        <label for="name" class="form-label">User Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="User Name" value="{{ $user->name }}" required>
    </div>
    <div class="mb-3">
        <label for="mobile" class="form-label">Mobile No.</label>
        <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $user->mobile }}">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password (leave blank to keep unchanged)</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mb-3">
        <label for="department" class="form-label">Department</label>
        <select class="form-control" id="department" name="department" required>
            <option value="{{ $user->department }}">{{ $user->departmentname }}</option>
            @foreach($departments as $dept_id => $dept_name)
                @if ($dept_id != $user->department)
                    <option value="{{ $dept_id }}">{{ $dept_name }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-control" id="role" name="role" required>
            <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
            <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-control" id="status" name="status" required>
            <option value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>
            <option value="Inactive" {{ $user->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
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
                <button type="button" class="btn btn-primary" id="modalOkButton" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

@if (session('success') || session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
            statusModal.show();

            // Redirect to task.index when the OK button is clicked
            document.getElementById('modalOkButton').addEventListener('click', function() {
                window.location.href = "{{ route('user.index') }}";
            });
        });
    </script>
@endif

</body>

</html>
