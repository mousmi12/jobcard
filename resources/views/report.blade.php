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
                                <h4 class="card-title">Project Report</h4>
                            </div>
                            <div class="input-group" style="width: 80%;">
                                <input type="text" id="searchInput" style="border-radius: 30px;" class="form-control" placeholder="Search by Project, Department, User, or Priority">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-fab btn-icon btn-round" onclick="searchTable()">
                                        <i class="now-ui-icons ui-1_zoom-bold"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table tablesorter" id="projectTable">
                                        <thead class="text-primary">
                                            <tr>
                                                <th>SNo.</th>
                                                <th>Job Name</th>
                                                <th>Department</th>
                                                <th>User</th>

                                                <th>Priority</th>
                                                <th>Last Date</th>
                                                <th>Work Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $counter = 1 @endphp
                                            @foreach($projects as $project)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>{{ $project->projectname }}</td>
                                                <td>{{ $project->departmentname }}</td>
                                                <td>{{ $project->username }}</td>

                                                <td>{{ $project->priority }}</td>
                                                <td>{{ $project->enddate }}</td>
                                                <td>
                                                    <div style="display: flex; align-items: center;">
                                                        <canvas id="chart-{{ $project->id }}" width="100" height="100"></canvas>
                                                        <div id="legend-{{ $project->id }}" style="margin-left: 10px;"></div>
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
            @include('footer')
        </div>
    </div>
    @include('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach($projects as $project)
                var ctx = document.getElementById('chart-{{ $project->id }}').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Pending', 'In Progress', 'Completed'],
                        datasets: [{
                            data: [{{ $project->pending_tasks }}, {{ $project->in_progress_tasks }}, {{ $project->completed_tasks }}],
                            backgroundColor: ['#ff6384', '#36a2eb', '#4bc0c0']
                        }]
                    },
                    options: {
                        responsive: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });

                // Generate custom legend
                var legendContainer = document.getElementById('legend-{{ $project->id }}');
                chart.legend.legendItems.forEach(function(item) {
                    var label = document.createElement('div');
                    label.style.marginBottom = '5px';
                    label.style.display = 'flex';
                    label.style.alignItems = 'center';
                    label.innerHTML =
                        '<span style="background-color:' + item.fillStyle + '; width: 10px; height: 10px; display: inline-block; margin-right: 5px;"></span>' +
                        '<span style="font-size: 10px;">' + item.text + '</span>';
                    legendContainer.appendChild(label);
                });
            @endforeach
        });

        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.getElementById("projectTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }
    </script>
</body>

</html>
