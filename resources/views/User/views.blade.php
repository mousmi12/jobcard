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
                                <h5 class="title">User Details</h5>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label  class="form-label">User Name </label>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">{{ $user->name }}</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Mobile </label>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">{{ $user->mobile }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Email </label>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">{{ $user->email }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Department </label>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">{{ $user->departmentname }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Qualification </label>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">{{ $user->qualification }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">User Role </label>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">{{ $user->role }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Status </label>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">{{ $user->status }}</span>
                                    </div>
                                </div>


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
</body>

</html>
