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
                                <h5 class="title">Adding Task</h5>
                            </div>
                            <div class="card-body">
                            <form action="{{ route('task.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Enter Task</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Task Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="priority" class="form-label">Priority</label>
                                        <select class="form-control" id="priority" name="priority" required>
                                            <option value="" disabled selected>Select Priority</option>
                                            <option value="high">High</option>
                                            <option value="medium">Medium</option>
                                            <option value="low">Low</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-round btn-primary me-2">Save</button>
                                        <a href="{{ route('task.index') }}" class="btn btn-round btn-secondary">Cancel</a>
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
