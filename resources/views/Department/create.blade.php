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
                    <!-- Left Block: Form -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="title">Add Department</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('department.store') }}" method="POST">
                                @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Department Name</label>
                                                <input type="text" class="form-control" placeholder="Department Name" id="name" name="name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="" disabled selected>Select Status</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-round btn-primary me-2">Save</button>
                                        <a href="" class="btn btn-round btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Right Block: Table -->
                    <div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="title">Departments</h5>
        </div>
        <div class="card-body">
            <table class="table tablesorter" id="">
                <thead class="text-primary">
                    <tr>
                        <th>SNo.</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $counter = 1 @endphp
                    @foreach($departments as $department)
                    <tr data-id="{{ $department->id }}">
                        <td>{{ $counter++ }}</td>
                        <td>{{ $department->name }}</td>
                        <td class="status">{{ $department->status }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm edit-btn"><i class="fas fa-pencil-alt"></i></button>
                            <button class="btn btn-primary btn-sm delete-btn">
                                <i class="fas fa-trash-alt"></i>
                            </button>
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
            @include('footer')
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const statusCell = row.querySelector('.status');
            const currentStatus = statusCell.innerText;
            const select = document.createElement('select');
            const options = ['Active', 'Inactive'];

            options.forEach(optionText => {
                const option = document.createElement('option');
                option.value = optionText;
                option.text = optionText;
                if (optionText === currentStatus) {
                    option.selected = true;
                }
                select.appendChild(option);
            });

            statusCell.innerHTML = '';
            statusCell.appendChild(select);
            select.focus();

            const saveStatus = () => {
                const newStatus = select.value;
                const departmentId = row.dataset.id;

                fetch(`../department/${departmentId}/update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        statusCell.innerText = newStatus;
                        console.log('Status updated successfully');
                    } else {
                        statusCell.innerText = currentStatus;
                        console.error('Error updating status');
                    }
                })
                .catch(error => {
                    statusCell.innerText = currentStatus;
                    console.error('Error:', error);
                });
            };

            select.addEventListener('change', saveStatus);
            select.addEventListener('blur', saveStatus);
        });
    });
});

document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const departmentId = row.dataset.id;

            if (confirm('Are you sure you want to delete this department?')) {
                fetch(`../department/${departmentId}/destroy`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        row.remove();
                        console.log('Department deleted successfully');
                    } else {
                        console.error('Error deleting department');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    });

</script>
    @include('js')
</body>

</html>
