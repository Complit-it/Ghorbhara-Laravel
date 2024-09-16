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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>



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
                                    @if ($productEdit != null)
                                        Update Product
                                    @else
                                        Add Product
                                    @endif
                                </h3>
                            </div>
                            @if ($productEdit == null)
                                <form role="form" action="{{ route('addProduct') }}" method="post"
                                    onsubmit="return submitForm()" enctype="multipart/form-data">
                                @else
                                    <form role="form" action="{{ route('editProductPost') }}" method="post"
                                        onsubmit="return submitForm()" enctype="multipart/form-data">
                                        <input type="hidden" name="productId" value="{{ $productEdit->id }}"></input>
                            @endif
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    {{-- <div class="col-md-12">
                                            <h3>Basic Details of the Customer</h3>
                                        </div> --}}


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="productName">Product Name <span style="color:red">*</span></label>
                                            <input type="text" name="productName" id="productName"
                                                class="form-control col-md-12" placeholder="Product Name"
                                                @if ($productEdit != null) value="{{ $productEdit->productName }}" @endif
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="productCatagory">Product Category <span
                                                    style="color:red">*</span></label>
                                            <select class="form-control select2" id="productCatagory" name="productCatagory"
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

                                    <div class="col-md-4" id="subCatSec">
                                        <div class="form-group">
                                            <label for="productSubCatagory">Product Sub Category <span
                                                    style="color:red">*</span></label>
                                            <select class="form-control select2" id="productSubCatagory"
                                                name="productSubCatagory" style="width: 100%;">
                                                <option value="-1" selected>----Select Sub Category---</option>
                                                @if ($subcategories != null)
                                                    @for ($i = 0; $i < count($subcategories); $i++)
                                                        <option value="{{ $subcategories[$i]['id'] }}">
                                                            {{ $subcategories[$i]['name'] }}
                                                        </option>
                                                    @endfor
                                                @endIf

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="productprice">Product MRP <span style="color:red">*</span></label>
                                            <input type="number" name="productprice" id="productprice"
                                                @if ($productEdit != null) value="{{ $productEdit->productMRP }}" @endif
                                                class="form-control col-md-12" step=".01" placeholder="Product MRP"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="productUnit">Product Unit <span style="color:red">*</span></label>
                                            <input type="text" name="productUnit" id="productUnit"
                                                @if ($productEdit != null) value="{{ $productEdit->productUnit }}" @endif
                                                class="form-control col-md-12" placeholder="Product Unit" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="productOfferprice">Vendor Discount<span
                                                    style="color:red">*</span></label>
                                            <input type="number" name="productOfferprice" id="productOfferprice"
                                                @if ($productEdit != null) value="{{ $productEdit->vendorDiscount }}" @endif
                                                class="form-control col-md-12" step=".01" placeholder="Vendor Discount"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="productDescription">Product Description<span
                                                    style="color:red">*</span></label>
                                            <textarea id="compose-textarea" class="form-control" name="productDescription" style="height: 300px">
                                                @if ($productEdit != null)
{{ $productEdit->productDescription }}
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
                                    @if ($productEdit != null)
                                        Update Product
                                    @else
                                        Add Product
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

    @if ($productEdit != null)
        <script>
            $('#productCatagory').val({{ $productEdit->productCategory }});
            $('#productSubCatagory').val({{ $productEdit->productSubCategory }});
            // var ne = {!! json_encode($productEdit) !!};
            // //    {{ $productEdit->productCatagory }}
            // // document.getElementById("productCatagory") e.value = {{ $productEdit->productCatagory }};
            // // document.getElementById("productSubCatagory") e.value = {{ $productEdit->productSubCatagory }};
            // console.log(ne);
        </script>
    @endif



@endsection
