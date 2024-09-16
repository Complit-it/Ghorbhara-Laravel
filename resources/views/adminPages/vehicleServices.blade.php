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
                            <li class="breadcrumb-item active">Add Vehicle Services</li>
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


                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">

                                <h3 class="card-title">
                                    @if ($selectSubCatId != null)
                                        Update Vehicle Services
                                    @else
                                        Add Vehicle Services
                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            @if ($selectSubCatId == null)
                            <form role="form" action="/vehicle-services" method="post" enctype="multipart/form-data">
                                @else
                                    <form role="form" action="/edit-vehicle-services" method="post"
                                        enctype="multipart/form-data">

                                        <input type="hidden" name="id" value="{{ $selectSubCatId }}"></input>
                            @endif
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="brandId">Select Brand <span style="color:red">*</span></label>
                                            <select class="form-control select2" id="brandId" name="brandId" style="width: 100%;" onchange>
                                                <option value="-1">----Select Brand---</option>
                                                @foreach ($vehicleBrand as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="categoryId">Select Category <span style="color:red">*</span></label>
                                            <select class="form-control select2" id="categoryId" name="categoryId" style="width: 100%;" onchange>
                                                <option value="-1">----Select Category---</option>


                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="modelId">Select Model <span style="color:red">*</span></label>
                                            <select class="form-control select2" id="modelId" name="modelId" style="width: 100%;" onchange>
                                                <option value="-1">----Select Model---</option>


                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="ssptype">Select Service Provider Type <span style="color:red">*</span></label>
                                            <select class="form-control select2" id="ssptype" name="ssptype" style="width: 100%;" onchange>
                                                <option value="-1">----Select Service Provider Type---</option>
                                                @foreach ($ssptype as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach


                                            </select>
                                        </div>
                                    </div>




                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="serviceId">Select Services <span style="color:red">*</span></label>
                                            <select class="form-control select2" id="serviceId" name="serviceId" style="width: 100%;">
                                                <option value="-1">----Select Services---</option>
                                            </select>
                                        </div>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Vehicle Service List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <h2>Filter</h2>
                                </div>
                            <div class="row">


                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="filterbrandId">Select Brand <span style="color:red">*</span></label>
                                        <select class="form-control select2" id="filterbrandId" name="filterbrandId" style="width: 100%;" onchange>
                                            <option value="-1">----Select Brand---</option>
                                            @foreach ($vehicleBrand as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>



                            </div>
                            <div class="row">
                                    <h2>Results</h2>
                                </div>

                                <table id="table21" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Brand</th>
                                            <th>Category</th>
                                            <th>Model</th>
                                            <th>Service Provider</th>
                                            <th>Service</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>





                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Brand</th>
                                            <th>Category</th>
                                            <th>Model</th>
                                            <th>Service Provider</th>
                                            <th>Service</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./col -->
    </div>
    <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>


    <link rel="stylesheet" href=" https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.js"></script>



    <!-- Summernote -->
    <script src="adminAsset/plugins/summernote/summernote-bs4.min.js"></script>
    <script>
        $(function() {
            //Add text editor
            $('#compose-textarea').summernote()
        })
    </script>



    <link rel="stylesheet" href="{{ asset('adminAsset/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAsset/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <script src="{{ asset('adminAsset/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            })
        });
    </script>

<script>
    $(document).ready(function() {
        $('#brandId').on('change', function() {

            // console.log('Selected brand ID:', $(this).val());
            $.ajax({
                url: "/api/get-vehicle-category-from-brand",
                type: "POST",
                data: {
                    "brandId": $(this).val(),
                },
                success: function(response) {
                    //populate the results to the select list with id serviceId
                    var selectList = document.getElementById('categoryId');

                    // Clear any existing options
                    selectList.innerHTML = '';
                    var option = document.createElement('option');
                        option.value = -1; // Set the value of the option
                        option.text = "--Select Category--";   // Set the text displayed in the option
                        selectList.appendChild(option);

                    // Loop through the data and create option elements
                    for (var i = 0; i < response.length; i++) {
                        var option = document.createElement('option');
                        option.value = response[i].id; // Set the value of the option
                        option.text = response[i].name;   // Set the text displayed in the option
                        selectList.appendChild(option);

                    }
                },
            });
        });


        $('#categoryId').on('change', function() {

            // console.log('Selected category ID:', $(this).val());

            $.ajax({
                url: "/api/get-vehicle-model-from-category",
                type: "POST",
                data: {
                    "categoryId": $(this).val(),
                },
                success: function(response) {
                    //populate the results to the select list with id serviceId
                    var selectList = document.getElementById('modelId');

                    // Clear any existing options
                    selectList.innerHTML = '';
                    var option = document.createElement('option');
                        option.value = -1; // Set the value of the option
                        option.text = "--Select Model--";   // Set the text displayed in the option
                        selectList.appendChild(option);

                    // Loop through the data and create option elements
                    for (var i = 0; i < response.length; i++) {
                        var option = document.createElement('option');
                        option.value = response[i].id; // Set the value of the option
                        option.text = response[i].name;   // Set the text displayed in the option
                        selectList.appendChild(option);

                    }
                },
            });
        });


        $('#ssptype').on('change', function() {

            // console.log('Selected ssptype ID:', $(this).val());

            $.ajax({
                url: "/api/get-services-from-service-type",
                type: "POST",
                data: {
                    "ssptype": $(this).val(),
                },
                success: function(response) {
                    //populate the results to the select list with id serviceId
                    var selectList = document.getElementById('serviceId');

                    // Clear any existing options
                    selectList.innerHTML = '';
                    var option = document.createElement('option');
                        option.value = -1; // Set the value of the option
                        option.text = "--Select Services--";   // Set the text displayed in the option
                        selectList.appendChild(option);

                    // Loop through the data and create option elements
                    for (var i = 0; i < response.length; i++) {
                        var option = document.createElement('option');
                        option.value = response[i].id; // Set the value of the option
                        option.text = response[i].name;   // Set the text displayed in the option
                        selectList.appendChild(option);

                    }
                },
            });
        });

        var dataTable = $('#table21').DataTable({
                                    // Add the "columnDefs" option to define custom rendering for specific columns
                                    dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [0, 'DESC'],


                                });


        $('#filterbrandId').on('change', function() {

            // console.log('Selected brand ID:', $(this).val());
            $.ajax({
                url: "/api/get-services-detail-by-brand",
                type: "POST",
                data: {
                    "brandId": $(this).val(),
                },
                success: function(response) {
                   console.log('response' , response);


                    // Clear existing rows from the DataTable

                    dataTable.clear().draw();

                    // Iterate over the response data array
                    for (var i = 0; i < response.length; i++) {
                        var row = response[i];

                        // Generate HTML for the Edit and Delete buttons
                        // var editButton = '<a href="/edit-vehicle-services/' + row.id + '" class="btn btn-primary btn-sm">Edit</a>';
                        var deleteButton = '<a href="/delete-vehicle-services/' + row.id + '" class="btn btn-danger btn-sm">Delete</a>';

                        // Add the row data and buttons to the DataTable
                        dataTable.row.add([
                        row.id,
                        row.brand_name,
                        row.model_name,
                        row.category_name,
                        row.service_name,
                        row.services_provider_type,
                        // editButton + ' ' +
                         deleteButton // Add the buttons column to the row
                        ]);
                    }


                    // Draw all the added rows at once
                    dataTable.draw();
                },
            });
        });


    });
</script>


@endsection
