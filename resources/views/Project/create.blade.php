<!DOCTYPE html>
<html lang="en">
@include('header')
<style>
    .task-item {
        margin-bottom: 10px;
        padding: 5px 5px 5px 15px;
        /* Added left padding */
        background-color: #f8f9fa;
        border-radius: 4px;
        display: flex;
        align-items: center;
    }

    .task-item input[type="checkbox"] {
        margin-right: 10px;
    }
</style>

<body class="user-profile">
    <div class="wrapper">
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
                                <form action="{{ route('project.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Enter Project Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Project Name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="department" class="form-label">Department Name</label>
                                        <select class="form-control" id="department" name="department" required>
                                            <option value="" disabled selected>Select Department</option>
                                            @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="user" class="form-label">User</label>
                                        <select class="form-control" id="user" name="user" required>
                                            <option value="" disabled selected>Select User</option>
                                        </select>
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
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="checkbox" id="has_tasks" name="has_tasks">
                                        <label for="has_tasks">Does this project have tasks?</label>
                                    </div>
                                    <div class="mb-3" id="tasks-container" style="display: none;">
                                        <label class="form-label">Tasks</label>
                                        <div id="tasks">
                                            <!-- Tasks will be loaded here dynamically -->
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-round btn-primary me-2">Save</button>
                                        <a href="{{ route('project.index') }}" class="btn btn-round btn-secondary">Cancel</a>
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

    <!-- Modal
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
    @endif -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const departmentSelect = document.getElementById('department');
            const userSelect = document.getElementById('user');
            const hasTasksCheckbox = document.getElementById('has_tasks');
            const tasksContainer = document.getElementById('tasks-container');
            const tasksDiv = document.getElementById('tasks');

            departmentSelect.addEventListener('change', function() {
                const departmentId = this.value;
                userSelect.innerHTML = '<option value="" disabled selected>Select User</option>';

                if (departmentId) {
                    fetch(`../project/${departmentId}/users`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            data.forEach(user => {
                                const option = document.createElement('option');
                                option.value = user.id;
                                option.text = user.name;
                                userSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching users:', error));
                }
            });

            hasTasksCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    tasksContainer.style.display = 'block';
                    fetchTasks();
                } else {
                    tasksContainer.style.display = 'none';
                    tasksDiv.innerHTML = '';
                }
            });

            function fetchTasks() {
                fetch(`{{ route('project.task') }}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        tasksDiv.innerHTML = '';
                        data.forEach(task => {
                            const taskItem = document.createElement('div');
                            taskItem.classList.add('task-item');

                            const checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.id = `task_${task.id}`;
                            checkbox.name = 'tasks[]';
                            checkbox.value = task.id;
                            checkbox.classList.add('form-check-input');

                            const label = document.createElement('label');
                            label.htmlFor = `task_${task.id}`;
                            label.innerText = task.name;
                            label.classList.add('form-check-label', 'ms-2');

                            taskItem.appendChild(checkbox);
                            taskItem.appendChild(label);

                            tasksDiv.appendChild(taskItem);
                        });
                    })
                    .catch(error => console.error('Error fetching tasks:', error));
            }
        });
    </script>

    @include('js')
</body>
</html>
