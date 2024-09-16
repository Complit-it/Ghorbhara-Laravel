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
                            <h3 class="card-title">Add Messages</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="saveImages" onsubmit="return submitForm()" action={{ route('saveImages') }}
                            method="post" enctype="multipart/form-data">
                            <input type="hidden" name="productId" id="productId" class="form-control col-md-12"
                                value="{{ $productDetails[0]->id }}" readonly />



                            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

                            <div class="card-body">
                                <div class="row">


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="productName">Product Name <span style="color:red">*</span></label>
                                            <input type="text" name="productName" id="productName"
                                                class="form-control col-md-12"
                                                value="{{ $productDetails[0]->productName }}" readonly />
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="productCategory">Product Category <span
                                                    style="color:red">*</span></label>
                                            <input type="text" name="productCategory" id="productCategory"
                                                class="form-control col-md-12" value="{{ $productDetails[0]->category }}"
                                                readonly />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="subCategory">Product Sub Category <span
                                                    style="color:red">*</span></label>
                                            <input type="text" name="subCategory" id="subCategory"
                                                class="form-control col-md-12"
                                                value="{{ $productDetails[0]->subCategory }}" readonly />
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="customFile">Photo (270 x 220)</label>

                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="image" id="customFile"
                                                    required>
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Add Photo</button>
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
                                            <th>Image</th>
                                            <th>Product Name</th>


                                            {{-- <th>Edit</th> --}}
                                            <th>Delete</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allImages as $data)
                                            <tr>
                                                <td class="text-center"><img
                                                        src="{{ asset(urldecode($data->productImage)) }}" height="40"
                                                        width="60" /></td>
                                                <td>{{ $data->productName }}</td>

                                                {{-- <td>
                                                        <form action="{{ route('editGalleryPhoto') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="editId" value="{{ $data->id }}">
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
                                                    </td> --}}
                                                <td>
                                                    <form action="{{ route('deletePhoto') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="photoId" value="{{ $data->id }}">
                                                        <input type="hidden" name="productId"
                                                            value="{{ $data->productId }}">
                                                        <button type="submit"
                                                            style="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            text-decoration: none;
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
                                            <th>Image</th>
                                            <th>Product Name</th>


                                            {{-- <th>Edit</th> --}}
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

    <script src="adminAsset/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>


    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function submitForm() {

            if (document.getElementById('typeId').value == -1) {
                swal("Select Valid Type Id");
                return false;
            }

            if (document.getElementById('optionName').value == '') {
                swal("Enter Valid Option Name");
                return false;
            }

            if (document.getElementById('optionPrice').value == '') {
                swal("Enter Valid Option Price");
                return false;
            } else {
                return true;
                document.forms["searchbyform"].submit();
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#table21').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [2, 'DESC']
            });
        });
    </script>


    <link rel="stylesheet" href="{{ asset('adminAsset/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAsset/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <script src="{{ asset('adminAsset/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection
