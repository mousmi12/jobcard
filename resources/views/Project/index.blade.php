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
                                @if(auth()->user()->role !== 'User')
                                <form action="{{ route('project.create') }}" method="GET">
                                    <button type="submit" class="btn btn-round btn-primary">Add project</button>
                                </form>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table tablesorter" id="">
                                        <thead class="text-primary">
                                            <th>SNo.</th>
                                            <th>Job</th>
                                            <th>Department</th>
                                            <th>User</th>
                                            <th>Priority</th>
                                            <th>Actions</th>
                                        </thead>
                                        <tbody>
                                            @php $counter = 1 @endphp
                                            @foreach($projects as $project)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>{{ $project->name }}</td>
                                                <td>{{ $project->departmentname }}</td>
                                                <td>{{ $project->username }}</td>
                                                <td>{{ $project->priority }}</td>
                                                <td>
                                                    <a href="{{ route('project.views', $project->id) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    &nbsp;
                                                    @if(auth()->user()->role !== 'User')
                                                    <a href="{{ route('project.edit', $project->id) }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    &nbsp;
                                                    <form id="deleteForm" action="{{ route('project.destroy', $project->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="button" class="btn btn-link delete-btn" style="padding: 0; background: none; border: none;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @else
                                                    <a href="{{ route('project.projecttask', $project->id) }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    @endif

                                                    @if($project->document)
                                                    <a href="{{ asset('uploads/' . $project->document) }}" download>
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    @endif
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
                    Are you sure you want to delete this project?
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
            let projectId;

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const deleteForm = this.closest('form');
                    projectId = deleteForm.action;
                    const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
                    modal.show();
                });
            });

            document.getElementById('confirmDelete').addEventListener('click', function() {
                if (projectId) {
                    const form = document.getElementById('deleteForm');
                    form.action = projectId;
                    form.submit();
                }
            });
        });
    </script>

</body>
</html>
