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
        @if(session('message'))
            Toastify({
                text: "{{ session('message') }}",
                duration: 3000,  // Adjust the duration as needed (in milliseconds)
                position: 'right',
                gravity: 'auto',
                backgroundColor: 'red', // Example background color
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
                            <h3 class="card-title">Add Banner</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if ($singleOffer == null)
                            <form role="form" id="addOffers" onsubmit="return submitForm()"
                                action={{ route('app-banner') }} method="post" enctype="multipart/form-data">
                        @endif
                        @if ($singleOffer != null)
                            <form role="form" id="edit-app-banner" onsubmit="return submitForm()"
                                action={{ route('edit-app-banner-post') }} method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" id="id" class="form-control col-md-12"
                                    value="{{ $singleOffer->id }}" readonly />
                        @endif

                        <input name="_token" type="hidden" value="{{ csrf_token() }}" />

                        <div class="card-body">
                            <div class="row">




                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="productName">From <span style="color:red">*</span></label>
                                        <input type="datetime-local" name="scheduledfrom" id="scheduledfrom"
                                            class="form-control col-md-12"
                                            @if ($singleOffer != null) value="{{ $singleOffer->scheduledfrom }}" @endIf />
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="productCategory">Till<span style="color:red">*</span></label>
                                        <input type="datetime-local" name="scheduledto" id="scheduledto"
                                            class="form-control col-md-12"
                                            @if ($singleOffer != null) value="{{ $singleOffer->scheduledto }}" @endIf />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subCategory">Status <span style="color:red">*</span></label>
                                        <select class="form-control select2" id="status" name="status"
                                            style="width: 100%;" onchange="getSubCategory(this);">
                                            <option value="-1" selected>----Select Status---</option>
                                            <option value="1">Active</option>
                                            <option value="2">Deactive</option>

                                        </select>
                                    </div>
                                </div>



                                <div class="col-md-4" id="imageTo">
                                    <div class="form-group">
                                        <label for="customFile">Promotion Image (720 x 240)</label>

                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" id="customFile"
                                                @if ($singleOffer == null) required @endIf>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Add Banner</button>
                            </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="row">
                        <div class="col-12">


                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Master Data</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="table21" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Scheduled From</th>
                                                <th>Scheduled To</th>
                                                <th>Status</th>
                                                <th>Image</th>
                                                <th>Edit</th>
                                                <th>Delete</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allBanners as $data)
                                                <tr>
                                                    <td>{{ $data['scheduledfrom'] }}</td>
                                                    <td>{{ $data['scheduledto'] }}</td>
                                                    @if ($data['status'] == '1')
                                                        <td>Active</td>
                                                    @endif
                                                    @if ($data['status'] == '2')
                                                        <td>Deactive</td>
                                                    @endif
                                                    <td class="text-center"><a href="{{ asset(urldecode($data['imageUrl'])) }}" target="_blank">Preview</a></td>

                                                    <td>
                                                        <form action="{{ route('edit-app-banner') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $data['id'] }}">
                                                            <button type="submit"
                                                                style="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    text-decoration: none;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    border: none;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    background-color: transparent;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                "
                                                                name="ViewDetails"><i class="fa fa-edit"
                                                                    aria-hidden="true"></i></button>
                                                        </form>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('delete-app-banner') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $data['id'] }}">

                                                            <button type="submit"
                                                                style="                                                                                                                                                                                                                                                                                                                                                                                                                          text-decoration: none;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            border: none;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            background-color: transparent;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        "
                                                                name="ViewDetails"><i class="fa fa-trash"
                                                                    aria-hidden="true"></i></button>
                                                        </form>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Scheduled From</th>
                                                <th>Scheduled To</th>
                                                <th>Status</th>
                                                <th>Image</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
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


    <script src="adminAsset/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>

    @if ($singleOffer != null)
        <script>
            $('#status').val({{ $singleOffer->status }});
        </script>
    @endif
@endsection
