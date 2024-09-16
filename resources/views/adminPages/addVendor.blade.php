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
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-md-12 ">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    @if ($vendorDetails != null)
                                        Update Vendor
                                    @else
                                        Add Vendor
                                    @endif
                                </h3>
                            </div>
                            @if ($vendorDetails == null)
                                <form role="form" action="{{ route('addVendor') }}" method="post"
                                    onsubmit="return submitForm()" enctype="multipart/form-data">
                                @else
                                    <form role="form" action="{{ route('editVendorPost') }}" method="post"
                                        onsubmit="return submitForm()" enctype="multipart/form-data">
                                        <input type="hidden" name="vendorId" value="{{ $vendorDetails->phone }}"></input>
                            @endif
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-12">
                                            <h3>Basic Details of the Customer</h3>
                                        </div> --}}


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Vendor Name <span style="color:red">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control col-md-12"
                                                placeholder="Vendor Name"
                                                @if ($vendorDetails != null) value="{{ $vendorDetails->name }}" @endif
                                                required>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phone">Vendor Phone <span style="color:red">*</span></label>
                                            <input type="tel" name="phone" id="phone" class="form-control col-md-12"
                                                placeholder="Vendor Phone"
                                                @if ($vendorDetails != null) value="{{ $vendorDetails->phone }}" @endif
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="email">Vendor Email </label>
                                            <input type="email" name="email" id="email" class="form-control col-md-12"
                                                placeholder="Vendor Email"
                                                @if ($vendorDetails != null) value="{{ $vendorDetails->email }}" @endif>
                                        </div>
                                    </div>
                                    @if ($vendorDetails == null)
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="password">Vendor Password <span
                                                        style="color:red">*</span></label>
                                                <input type="password" name="password" id="password"
                                                    class="form-control col-md-12" placeholder="Vendor Password"
                                                    autocomplete="new-password" required>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gstin">Vendor GSTIN <span style="color:red">*</span></label>
                                            <input type="text" name="gstin" id="gstin" class="form-control col-md-12"
                                                placeholder="Vendor GSTIN"
                                                @if ($vendorDetails != null) value="{{ $vendorDetails->gstin }}" @endif
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="productprice">Vendor PIN<span style="color:red">*</span></label>
                                            <input type="number" name="pin" id="pin"
                                                @if ($vendorDetails != null) value="{{ $vendorDetails->pin }}" @endif
                                                class="form-control col-md-12" step=".01" placeholder="Product PIN"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Vendor Address <span style="color:red">*</span></label>
                                            <textarea type="text" name="address" id="address" class="form-control col-md-12">
@if ($vendorDetails != null)
{{ $vendorDetails->address }}
@endif
</textarea>

                                        </div>
                                    </div>










                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" onclick="return submitAgentForm()" class="btn btn-primary"
                                    name="search">
                                    @if ($vendorDetails != null)
                                        Update Vendor
                                    @else
                                        Add Vendor
                                    @endif
                                </button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->

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
            $('#table21').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [4, 'DESC'],
            });
        });
    </script>







    <script>
        function getSubCategory(sel) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var categoryId = sel.value;
            // var subCategorySelect = document.getElementById('productSubCategory');
            $.ajax({
                url: '/getSubCategory',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    options: categoryId
                },
                dataType: 'JSON',
                success: function(data) {
                    data = data['subcategories'];
                    var sel2 = $("#productSubCatagory");
                    if (data.length == 0) {
                        $('#subCatSec').hide();
                    } else {
                        $('#subCatSec').show();
                        // document.getElementById('subCatSec').style.visibility = 'show';
                        sel2.empty();
                        sel2.append('<option value="-1">----Select Sub Category---</option>');
                        for (var i = 0; i < data.length; i++) {
                            sel2.append('<option value="' + data[i]['id'] + '">' + data[i]['name'] +
                                '</option>');
                        }
                    }

                }
            });

        }
    </script>

    @if ($vendorDetails != null)
        <script>
            $('#productCatagory').val({{ $vendorDetails->productCategory }});
            $('#productSubCatagory').val({{ $vendorDetails->productSubCategory }});
            // var ne = {!! json_encode($vendorDetails) !!};
            // //    {{ $vendorDetails->productCatagory }}
            // // document.getElementById("productCatagory") e.value = {{ $vendorDetails->productCatagory }};
            // // document.getElementById("productSubCatagory") e.value = {{ $vendorDetails->productSubCatagory }};
            // console.log(ne);
        </script>
    @endif
@endsection
