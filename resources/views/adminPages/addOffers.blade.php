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
                            <h3 class="card-title">Add Offer</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if ($singleOffer == null)
                            <form role="form" id="addOffers" onsubmit="return submitForm()"
                                action={{ route('addOffers') }} method="post" enctype="multipart/form-data">
                        @endif
                        @if ($singleOffer != null)
                            <form role="form" id="editOffersPost" onsubmit="return submitForm()"
                                action={{ route('editOffersPost') }} method="post" enctype="multipart/form-data">
                                <input type="hidden" name="offerId" id="offerId" class="form-control col-md-12"
                                    value="{{ $singleOffer[0]->id }}" readonly />
                        @endif

                        <input name="_token" type="hidden" value="{{ csrf_token() }}" />

                        <div class="card-body">
                            <div class="row">


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="productCatagory">Offer On <span style="color:red">*</span></label>
                                        <select class="form-control select2" id="categoryId" name="categoryId"
                                            style="width: 100%;" onchange="getSubCategory(this);">
                                            <option value="-1" selected>----Select Category---</option>

                                            @for ($i = 0; $i < count($catagories); $i++)
                                                <option value="{{ $catagories[$i]['id'] }}">
                                                    {{ $catagories[$i]['name'] }}
                                                </option>
                                            @endfor

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="productName">Offer From <span style="color:red">*</span></label>
                                        <input type="datetime-local" name="scheduledfrom" id="scheduledfrom"
                                            class="form-control col-md-12"
                                            @if ($singleOffer != null) value="{{ $singleOffer[0]->scheduledfrom }}" @endIf />
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="productCategory">Offer Till<span style="color:red">*</span></label>
                                        <input type="datetime-local" name="scheduledto" id="scheduledto"
                                            class="form-control col-md-12"
                                            @if ($singleOffer != null) value="{{ $singleOffer[0]->scheduledto }}" @endIf />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subCategory">Offer Status <span style="color:red">*</span></label>
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
                                <button type="submit" class="btn btn-primary">Add Offer</button>
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
                                                <th>Offer Image</th>
                                                <th>Offer On</th>
                                                <th>Scheduled From</th>
                                                <th>Scheduled To</th>
                                                <th>Offer Status</th>
                                                <th>Edit</th>
                                                <th>Delete</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allOffers as $data)
                                                <tr>
                                                    <td class="text-center"><img
                                                            src="{{ asset(urldecode($data['imageLink'])) }}"
                                                            height="40" width="60" /></td>
                                                    <td>{{ $data['name'] }}</td>
                                                    <td>{{ $data['scheduledfrom'] }}</td>
                                                    <td>{{ $data['scheduledto'] }}</td>
                                                    @if ($data['status'] == '1')
                                                        <td>Active</td>
                                                    @endif
                                                    @if ($data['status'] == '2')
                                                        <td>Deactive</td>
                                                    @endif

                                                    <td>
                                                        <form action="{{ route('editOffer') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="offerId"
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
                                                        <form action="{{ route('deleteOffer') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="offerId"
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
                                                <th>Offer Image</th>
                                                <th>Offer On</th>
                                                <th>Scheduled From</th>
                                                <th>Scheduled To</th>
                                                <th>Offer Status</th>
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
            $('#categoryId').val({{ $singleOffer[0]->categoryId }});
            $('#status').val({{ $singleOffer[0]->status }});

            $('#imageTo').hide();
        </script>
    @endif
@endsection
