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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">

                                @if(auth()->user()->role !== 'User')
                                <h4 class="card-title">User Details</h4>
                                <form action="{{ route('user.create') }}" method="GET">
                                    <button type="submit" class="btn btn-round btn-primary">Add user</button>
                                </form>
                                @else
                                <h4 class="card-title">Profile</h4>
                                @endif

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table tablesorter" id="">
                                        <thead class="text-primary">
                                            <th>SNo.</th>
                                            <th>User Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Department</th>
                                            <th>Actions</th>
                                        </thead>
                                        <tbody>
                                            @php $counter = 1 @endphp
                                            @foreach($users as $user)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->mobile }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->departmentname }}</td>
                                                <td>
                                                    <a href="{{ route('user.views', $user->id) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a href="{{ route('user.edit', $user->id) }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    &nbsp;
                                                    @if(auth()->user()->role !== 'User')
                                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirmDelete('{{ $user->name }}');">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-link" style="padding: 0; background: none; border: none;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
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
    @include('js')

    <script>
        function confirmDelete(username) {
            return confirm(`Are you sure you want to delete ${username}?`);
        }
    </script>
</body>

</html>
