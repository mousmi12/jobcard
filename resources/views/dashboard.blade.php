<!DOCTYPE html>
<html lang="en">
@include('header')

<style>
    .primary-color {
        color: #9b2a12;
    }

    .icon-size {
        font-size: 3rem;
    }

    .rounded-card {
        border-radius: 10px;
    }

    .progress {
        width: 100%;
        background-color: #f3f3f3;
        border-radius: 0.25rem;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background-color: #007bff;
        transition: width 0.6s ease;
        text-align: center;
        color: white;
    }
</style>

<body class="">
    <div class="wrapper">
        @include('sidebar')
        <div class="main-panel" id="main-panel">
            @include('navbar')
            <div class="panel-header panel-header-lg p-5" style="height: fit-content;">
                <div class="row mt-3">
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card mx-2 rounded-card" style="height:150px">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="align-self-center">
                                            <i class="fa fa-briefcase primary-color icon-size float-left"></i>
                                        </div>
                                        <div class="media-body text-right">
                                            <h3>{{$activeProjectCount}}</h3>
                                            <span>Total Jobs</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $count = 1; @endphp
                    @foreach ($results as $result)
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card mx-2 rounded-card" style="height:150px">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="align-self-center">
                                            <i class="fa fa-heart primary-color icon-size float-left"></i>
                                        </div>
                                        <div class="media-body text-right">
                                            <h3>{{$result->project_count}}</h3>
                                            @if($result->priority_count !=0)
                                            <span style="color:green">Priority {{$result->priority_count}}</span>
                                            @endif
                                            <p>{{$result->name}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $count++; @endphp
                    @if ($count % 4 == 0)
                </div><!-- close row -->
                <div class="row"><!-- open new row -->
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="content">
                <div class="row">

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Project User</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="text-primary">
                                            <tr>
                                                <th>User Name</th>

                                                <th>Handling Project</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($activeUsersProjects as $item)
                                            <tr>
                                                <td>{{ $item->username }}</td>
                                                <td>{{ $item->projectname }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Project Status</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="text-primary">
                                            <tr>
                                                <th>Project Name</th>

                                                <th>Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($projects as $project)
                                            <tr>
                                                <td>{{ $project->name }}</td>

                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar" role="progressbar" id="progress-{{ $project->id }}" aria-valuenow="{{ floatval($project->status_percentage) }}" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                            <span id="progress-text-{{ $project->id }}">0%</span>
                                                        </div>
                                                    </div>
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
        </div>
    </div>
    @include('sidebar')
    @include('js')

    <!-- Embed projects JSON data in a hidden element -->
    <div id="projects-data" style="display:none;">
        {!! json_encode($projects) !!}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var projects = JSON.parse(document.getElementById('projects-data').textContent);

            projects.forEach(function(project) {
                var progress = document.getElementById('progress-' + project.id);
                var progressText = document.getElementById('progress-text-' + project.id);
                var percentage = parseFloat(project.status_percentage);

                // Ensure percentage is between 0 and 100
                percentage = Math.max(0, Math.min(100, percentage));

                progress.style.width = percentage + '%';
                progressText.textContent = percentage.toFixed(2) + '%';
            });
        });
    </script>
</body>

</html>
