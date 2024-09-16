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


<!-- Include Toastify CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<!-- Include Toastify JS -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,  // Adjust the duration as needed (in milliseconds)
                position: 'right',
                gravity: 'auto',
                backgroundColor: 'green', // Example background color
                close: true,
            }).showToast();
        @endif

        @if(session('danger'))
            Toastify({
                text: "{{ session('danger') }}",
                duration: 3000,  // Adjust the duration as needed (in milliseconds)
                position: 'right',
                gravity: 'auto',
                backgroundColor: 'red', // Example background color
                close: true,
            }).showToast();
        @endif

        @if(session('warning'))
            Toastify({
                text: "{{ session('warning') }}",
                duration: 3000,  // Adjust the duration as needed (in milliseconds)
                position: 'right',
                gravity: 'auto',
                backgroundColor: 'orange', // Example background color
                close: true,
            }).showToast();
        @endif
    });
</script>





    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <section class="content">
            @if ($errors->count())
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Questionaire</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if ($singleOffer == null)
                            <form role="form" id="addOffers" onsubmit="return submitForm()"
                                action={{ route('problem-questionaire') }} method="post" enctype="multipart/form-data">
                        @endif
                        @if ($singleOffer != null)
                            <form role="form" id="edit-problem-questionaire" onsubmit="return submitForm()"
                                action={{ route('edit-problem-questionaire-post') }} method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" id="id" class="form-control col-md-12"
                                    value="{{ $singleOffer->id }}" readonly />
                        @endif

                        <input name="_token" type="hidden" value="{{ csrf_token() }}" />

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h4>Select Vehicle </h4>
                                    </div>
                                </div>

                            <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="brandId">Select Brand <span style="color:red">*</span></label>
                                            <select class="form-control select2" id="brandId" name="brandId" style="width: 100%;" onchange>
                                                <option value="-1">----Select Brand---</option>
                                                @foreach ($vehicleBrand as $item)
                                                    @if ($selectCatId != null)
                                                        <option @if ($selectCatId->brandId  ==  $item->id) selected @endif value="{{ $item->id }}" >{{ $item->name }}</option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endIf
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="categoryId">Select Category <span style="color:red">*</span></label>
                                            <select class="form-control select2" id="categoryId" name="categoryId" style="width: 100%;" onchange>
                                                <option value="-1">----Select Category---</option>
                                                @foreach ($getCategory as $item)
                                                    @if ($selectCatId != null)
                                                        <option @if ($selectCatId->categoryId  ==  $item->id) selected @endif value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endIf

                                                @endforeach



                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="modelId">Select Model <span style="color:red">*</span></label>
                                            <select class="form-control select2" id="modelId" name="modelId" style="width: 100%;" onchange>
                                                <option value="-1">----Select Model---</option>
                                                @foreach ($getModel as $item)
                                                    @if ($selectCatId != null)
                                                        <option @if ($selectCatId->modelId  ==  $item->id) selected @endif value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endIf

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h4>Problem Questionaire </h4>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="productName">Question <span style="color:red">*</span></label>
                                        <input type="text" name="question" id="question"
                                            class="form-control col-md-12"
                                            @if ($selectCatId != null) value="{{ $selectCatId->question }}" @endIf />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="question_type">Question Type <span style="color:red">*</span></label>
                                        <select class="form-control select2" id="question_type" name="question_type"
                                            style="width: 100%;">
                                            <option value="-1" >----Select Status---</option>
                                            <option value="1"  @if ($selectCatId != null) @if ($selectCatId->question_type == 1) selected  @endIf @endIf >MCQ</option>
                                        </select>
                                    </div>
                                </div>




                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_options">Total Options <span style="color:red">*</span></label>
                                        <input type="number" name="total_options" id="total_options"
                                            class="form-control col-md-12"
                                            @if ($selectCatId != null) value="{{ $selectCatId->total_options }}" @endIf />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="priority">Question Priority <span style="color:red">*</span></label>
                                        <input type="number" name="priority" id="priority"
                                            class="form-control col-md-12"
                                            @if ($selectCatId != null) value="{{ $selectCatId->priority }}" @endIf />
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h4>Problem Options </h4>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div  class= "col-md-12" id="dynamicFieldsContainer"></div>
                                    </div>
                                </div>




                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Add Question</button>
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

                                <table id="table212" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Category</th>
                                            <th>Model</th>
                                            <th>Question</th>
                                            <th>Question Type</th>
                                            <th>Total Options</th>
                                            <th>Priority</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>





                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Category</th>
                                            <th>Model</th>
                                            <th>Question</th>
                                            <th>Question Type</th>
                                            <th>Total Options</th>
                                            <th>Priority</th>
                                            <th>Delete</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->



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
    <link rel="stylesheet"
        href="{{ asset('adminAsset/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
            $('#table21').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [4, 'DESC'],
            });
        });
    </script>

<!--
    <script src="adminAsset/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script> -->

    <script>


var dataTable = $('#table212').DataTable({
                                    // Add the "columnDefs" option to define custom rendering for specific columns
                                    dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [0, 'DESC'],


                                });



$('#filterbrandId').on('change', function() {

// console.log('Selected brand ID:', $(this).val());
    filterBrand($(this).val());

});

$(document).ready(function() {
    filterBrand(1);
});

function filterBrand(brandId){
    $.ajax({
    url: "/api/get-questions-by-brand",
    type: "POST",
    data: {
        "brandId": brandId,
    },
    success: function(response) {
        // Clear existing rows from the DataTable

        dataTable.clear().draw();

        // Iterate over the response data array
        for (var i = 0; i < response.length; i++) {
            var row = response[i];

            // Generate HTML for the Edit and Delete buttons
            // var editButton = '<a href="/edit-vehicle-services/' + row.id + '" class="btn btn-primary btn-sm">Edit</a>';
            var deleteButton = '<a href="/delete-question/' + row.id + '" class="btn btn-danger btn-sm">Delete</a>';
            var editButton = '<a href="/edit-question/' + row.id + '" class="btn btn-info btn-sm">Edit</a>';

            if(row.question_type == 1){
                row.question_type = 'MCQ';
            }

            // Add the row data and buttons to the DataTable
            dataTable.row.add([
            row.id,
            row.category_name,
            row.model_name,
            row.question,
            row.question_type,
            row.total_options,
            row.priority,
            editButton + ' ' +
             deleteButton // Add the buttons column to the row
            ]);
        }


        // Draw all the added rows at once
        dataTable.draw();
    },
});
}
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

    });

    </script>

        <script>

    // Function to generate dynamic input fields
    function generateDynamicFields(totalOptions) {

        var dynamicFieldsContainer = $('#dynamicFieldsContainer');
        dynamicFieldsContainer.empty(); // Clear previous fields

        // @if($options != null){
        //             // dynamicFieldsContainer.empty(); // Clear previous fields
        //             var options = {!! json_encode($options) !!};
        //             var totalOptions = options.length + totalOptions;

        // }
        //             @else{

                    // }
                    // @endIf

        for (var i = 1; i <= totalOptions; i++) {
            var inputField = $(
                '<div class="row">'+
                    '<div class="col-md-4">'+
                        '<div class="form-group">' +
                            '<label for="option' + i + '">Option ' + i + '</label>' +
                            '<input type="text" name="option' + i + '" id="option' + i + '"  class="form-control" />' +
                        '</div>'+
                    '</div>'+

                    '<div class="col-md-4">'+
                        '<div class="form-group">'+
                            '<label for= "servicecategory'+i+'">Select Service Category <span style="color:red">*</span></label>'+
                            '<select class="form-control select23" onchange="getService(this,servicerequired'+i+')" id="servicecategory'+i+'" name="servicecategory'+i+'"'+
                                'style="width: 100%;">'+
                                '<option value="-1" selected>----Select Service Category---</option>'+
                                @foreach ($ssptype as $item)
                                    '<option value="{{ $item->id }}">{{ $item->name }}</option>'+
                                @endforeach
                            '</select>'+
                        '</div>'+
                    '</div>'+


                    '<div class="col-md-4">'+
                        '<div class="form-group">'+
                            '<label for= "servicerequired'+i+'">Select Service <span style="color:red">*</span></label>'+
                            '<select class="form-control select23" id="servicerequired'+i+'" name="servicerequired'+i+'"'+
                                'style="width: 100%;">'+
                                '<option value="-1" selected>----Select Services---</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>'+




                '</div>');

            dynamicFieldsContainer.append(inputField);
        }
        $('.select23').select2()

        //Initialize Select2 Elements
        $('.select23').select2({
            theme: 'bootstrap4'
        })

    }

    // Initial generation based on the default value


    // Update fields when Total Options changes
    $('#total_options').on('input', function () {
        var totalOptions = $(this).val();
        generateDynamicFields(totalOptions);
    });


    $(document).ready(function() {
        var initialTotalOptions = 0;

        @if($options != null){

            var options = {!! json_encode($options) !!};

            // console.log('options', options);

            initialTotalOptions = options.length;
            generateDynamicFields(initialTotalOptions);

            if (initialTotalOptions > 0) {
                for(var i = 0 ; i < initialTotalOptions ; i++){
                    // setTimeout((options) => {
                        $('#option'+(i+1)).val(options[i].option);
                        var selectedValue = options[i].service_category.id;
                        $('#servicecategory' + (i + 1)).val(selectedValue).trigger('change');
                        var serviceRequired =    $('#servicerequired' + (i + 1));

                }

                timeout = setTimeout(function(options) {
                    var options = {!! json_encode($options) !!};
                    for(var j = 0; j < initialTotalOptions; j++){

                        var serviceRequired =    $('#servicerequired' + (j + 1));
                        var serviceId = options[j].service_id.id;
                        serviceRequired.val(serviceId).trigger('change');
                    }
            }, 1000);


            }




        }@else{
            initialTotalOptions = $('#total_options').val();
            generateDynamicFields(initialTotalOptions);
        }@endIf



    });
</script>





<script>



function getService(e, servicerequired) {
    // alert(e.value);

    // var servicerequired1 = document.getElementById('servicerequired1');
    // console.log('servicerequired1', servicerequired1);
    $.ajax({
                url: "/api/get-services-from-service-type",
                type: "POST",
                data: {
                    "ssptype": e.value,
                },
                success: function(response) {

                    var selectList = servicerequired;

                    // Clear any existing options
                    selectList.innerHTML = '';
                    var option = document.createElement('option');
                        option.value = -1; // Set the value of the option
                        option.text = "----Select Services---";   // Set the text displayed in the option
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


}
    $(document).ready(function() {


    });
</script>



    @if ($singleOffer != null)
        <script>
            $('#status').val({{ $singleOffer->status }});
        </script>
    @endif


@endsection
