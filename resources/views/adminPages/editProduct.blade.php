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

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">


                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Users</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="table21" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Product MRP</th>
                                            <th>Unit</th>
                                            <th>Vendor Discount</th>
                                            <th>Image</th>
                                            <th>Edit</th>
                                            <th>Remove</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @for ($i = 0; $i < count($allProducts); $i++)
                                            <tr>
                                                <td>{{ $allProducts[$i]['productName'] }}</td>
                                                <td>{{ $allProducts[$i]['productCategory'] }}</td>
                                                @if ($allProducts[$i]['productSubCategory'] == '')
                                                    <td>NA </td>
                                                @else
                                                    <td>{{ $allProducts[$i]['productSubCategory'] }}</td>
                                                @endif

                                                <td>{{ $allProducts[$i]['productMRP'] }}</td>
                                                <td>{{ $allProducts[$i]['productUnit'] }}</td>
                                                <td>{{ $allProducts[$i]['vendorDiscount'] }}</td>
                                                @if (count($allProducts[$i]['productImages']) > 0)
                                                    <td>
                                                        <form action="addImages" method="post">
                                                            @csrf
                                                            <input type="hidden" name="productId"
                                                                value="{{ $allProducts[$i]['id'] }}" /><button
                                                                style="border: none; background: none; color: #e30de9;"
                                                                type="submit">Edit</button>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form action="addImages" method="post">
                                                            @csrf
                                                            <input type="hidden" name="productId"
                                                                value="{{ $allProducts[$i]['id'] }}" /><button
                                                                style="border: none; background: none;  color: #e30de9;"
                                                                type="submit">Add</button>
                                                        </form>
                                                    </td>
                                                @endif
                                                <td>
                                                    <form action="editProductForm" method="post">
                                                        @csrf
                                                        <input type="hidden" name="productId"
                                                            value="{{ $allProducts[$i]['id'] }}" /><button
                                                            style="border: none; background: none;" type="submit"><i
                                                                class="fas fa-edit"></i></button>
                                                    </form>

                                                </td>
                                                <td>
                                                    <form action="deleteProduct" method="post">
                                                        @csrf
                                                        <input type="hidden" name="productId"
                                                            value="{{ $allProducts[$i]['id'] }}" /><button
                                                            style="border: none; background: none;" type="submit"><i
                                                                class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>


                                            </tr>
                                        @endfor
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Product MRP</th>
                                            <th>Unit</th>
                                            <th>Vendor Discount</th>
                                            <th>Image</th>
                                            <th>Edit</th>
                                            <th>Remove</th>
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
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
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
@endsection
