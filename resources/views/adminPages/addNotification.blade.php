@extends('layouts.app')

@section('content')
    @include('layouts.adminMenu')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script type="text/javascript">
        @if (isset($alertTitle))
            Swal.fire(
                '{{ $alertTitle }}',
                '{{ $alertDescription }}',
                '{{ $alertIcon }}'
            )
        @endif
    </script>


@if(session('message'))
    <div id="flash-message" style="position: fixed; top:10%; right:0; z-index: 9999" class="p-3" >
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
        </div>
    </div>


@endif

<script>
    setTimeout(function() {
        $('#flash-message').fadeOut('slow');
    }, 5000); // 5 seconds
</script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>

                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active">Add Sub Category</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">


                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">

                                <h3 class="card-title">

                                        Post Notification
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="/add-notification" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="categoryId">Send To <span style="color:red">*</span></label>
                                            <select class="form-control select2" id="sendTo" name="sendTo" style="width: 100%;">
                                            <option value="-1">----Select Viewers---</option>
                                            <option value="1">Customers</option>
                                            <option value="2" selected>Vendors</option>
                                            <option value="3">Both</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="exampleInputEmail1">Add Title<span
                                                style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title">
                                    </div>


                                    <div class="form-group col-md-12">
                                        <label for="exampleInputEmail1">Add Description<span
                                                style="color: red;">*</span></label>
                                     <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Description"></textarea>
                                    </div>

                                </div>


                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" name="addSubCategory">Submit</button>
                        </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>

                </div>
            </div>
            <!-- ./col -->
    </div>
    <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

@endsection
