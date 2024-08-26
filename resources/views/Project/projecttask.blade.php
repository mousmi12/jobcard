<!DOCTYPE html>
<html lang="en">

@include('header')

<body class="user-profile">
    <div class="wrapper">
        @include('sidebar')
        <div class="main-panel" id="main-panel">
            @include('navbar')
            <div class="panel-header panel-header-sm"></div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="title">Job Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="projectsAccordion">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" aria-expanded="true">
                                                    {{ $project->projectname }}
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse{{ $project->projectid }}" class="collapse show" aria-labelledby="heading{{ $project->projectid }}" data-parent="#projectsAccordion">
                                            <div class="card-body">
                                                <form action="{{ route('updateTaskStatus') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <input type="hidden" name="projectid" value="{{ $project->projectid }}">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            @if ($tasks->isEmpty())
                                                                <div class="mb-3">
                                                                    <label for="projectwork" class="form-label">Edit Project Status</label>
                                                                    <select name="projectwork" id="projectwork" class="form-control form-control-sm no-padding-select">
                                                                        <option value="Pending" {{ $project->projectwork == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                                        <option value="In Progress" {{ $project->projectwork == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                                        <option value="Completed" {{ $project->projectwork == 'Completed' ? 'selected' : '' }}>Completed</option>
                                                                    </select>
                                                                </div>
                                                            @else
                                                                @foreach ($tasks as $task)
                                                                    <div class="mb-3">
                                                                        <label for="status[{{ $task->taskid }}]" class="form-label">{{ $task->taskname }}</label>
                                                                        <select name="status[{{ $task->taskid }}]" class="form-control form-control-sm no-padding-select">
                                                                            <option value="Pending" {{ $task->taskstatus == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                                            <option value="In Progress" {{ $task->taskstatus == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                                            <option value="Completed" {{ $task->taskstatus == 'Completed' ? 'selected' : '' }}>Completed</option>
                                                                        </select>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="image" class="form-label">Upload Image:</label>
                                                                <input type="file" name="image" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm mt-3">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Additional content can go here -->
                    </div>
                </div>
            </div>
            @include('footer')
        </div>
    </div>
    @include('js')

    <script>
        // Initialize Bootstrap tooltips and other JS components
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>

</html>
