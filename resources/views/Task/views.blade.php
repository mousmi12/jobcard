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
                                <h5 class="title">Task Details</h5>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">Task Name </label>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">{{ $task->name }}</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Description </label>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">{{ $task->description }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Priority </label>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">{{ $task->priority }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Status </label>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">{{ $task->status }}</span>
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
