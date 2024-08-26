<!DOCTYPE html>
<html lang="en">

@include('header')

<body class="user-profile">
    <div class="wrapper ">
        @include('sidebar')
        <div class="main-panel" id="main-panel">
            @include('navbar')
            <div class="panel-header panel-header-sm"></div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title"></h4>
                                <form action="{{ route('task.create') }}" method="GET">
                                    <button type="submit" class="btn btn-round btn-primary">Add Task</button>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table tablesorter" id="">
                                        <thead class="text-primary">
                                            <th>SNo.</th>
                                            <th>Task Name</th>
                                            <th>Description</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </thead>
                                        <tbody>
                                            @php $counter = 1 @endphp
                                            @foreach($tasks as $task)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>{{ $task->name }}</td>
                                                <td>{{ $task->description }}</td>
                                                <td>{{ $task->priority }}</td>
                                                <td>{{ $task->status }}</td>
                                                <td>
                                                    <a href="{{ route('task.views', $task->id) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a href="{{ route('task.edit', $task->id) }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    &nbsp;
                                                    <form id="deleteForm" action="{{ route('task.destroy', $task->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="button" class="btn btn-link delete-btn" style="padding: 0; background: none; border: none;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
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
            </div>
            @include('footer')
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this task?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    @include('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let taskId;

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const deleteForm = this.closest('form');
                    taskId = deleteForm.action;
                    const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
                    modal.show();
                });
            });

            document.getElementById('confirmDelete').addEventListener('click', function() {
                if (taskId) {
                    const form = document.getElementById('deleteForm');
                    form.action = taskId;
                    form.submit();
                }
            });
        });
    </script>

</body>
</html>
