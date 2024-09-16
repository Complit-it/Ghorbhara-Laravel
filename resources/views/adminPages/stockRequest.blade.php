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
                                            <th>Stock Id</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Vendor Name</th>
                                            <th>Vendor Phone</th>
                                            <th>Order Date & Time</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @for ($i = 0; $i < count($allStockHistory); $i++)
                                            <tr>
                                                <td>{{ $allStockHistory[$i]['stockId'] }}</td>
                                                <td>{{ $allStockHistory[$i]['productName'] }}</td>
                                                <td>{{ $allStockHistory[$i]['productQuantity'] }}</td>
                                                <td>{{ $allStockHistory[$i]['vendorName'] }}</td>
                                                <td>{{ $allStockHistory[$i]['vendorPhone'] }}</td>
                                                <td>{{ $allStockHistory[$i]['date'] }}
                                                    {{ $allStockHistory[$i]['time'] }}</td>


                                                @if ($allStockHistory[$i]['productStatus'] == 'Delivered')
                                                    <td style="color: green">Delivered</td>
                                                @endif
                                                @if ($allStockHistory[$i]['productStatus'] == 'Rejected')
                                                    <td style="color: red">Rejected</td>
                                                @endif
                                                @if ($allStockHistory[$i]['productStatus'] == 'Pending')
                                                    <td>
                                                        <form action="changeStockStatus" method="post">
                                                            @csrf
                                                            <input type="hidden" name="stockId"
                                                                value="{{ $allStockHistory[$i]['stockId'] }}" />
                                                            <select class="form-control select2" id="stockStatus"
                                                                name="stockStatus" style="width: 100%;"
                                                                onchange="getSubCategory(this);">
                                                                <option value="-1" selected>----Select Category---</option>

                                                                <option value="Delivered">Deliver</option>
                                                                <option value="Rejected">Reject</option>

                                                            </select>
                                                            <button style="border: none; background: none; color: #cf5b9f"
                                                                type="submit">Change
                                                                Status</button>
                                                        </form>
                                                    </td>
                                                @endif



                                            </tr>
                                        @endfor
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Stock Id</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Vendor Name</th>
                                            <th>Vendor Phone</th>
                                            <th>Order Date & Time</th>
                                            <th>Status</th>
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
                order: [0, 'DESC'],
            });
        });
    </script>
@endsection
