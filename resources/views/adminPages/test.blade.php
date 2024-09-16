<!DOCTYPE html>
<html>

<head>
    <title>Laravel Multiple Images Upload Using Dropzone</title>
    <meta name="_token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
</head>

<body>
    <div class="container">

        <form method="post" class="dropzone" action="{{ url('image/upload/store') }}"
            enctype="multipart/form-data">


            <div class="row">

                {{-- <div class="col-md-12">
                    <h3>Basic Details of the Customer</h3>
                </div> --}}


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="productName">Product Name <span style="color:red">*</span></label>
                        <input type="text" name="productName" id="productName" class="form-control col-md-12"
                            placeholder="Product Name" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="productCatagory">Product Category <span style="color:red">*</span></label>
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
                        <label for="productSubCatagory">Product Sub Category <span style="color:red">*</span></label>
                        <select class="form-control select2" id="productSubCatagory" name="productSubCatagory"
                            style="width: 100%;">
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
                        <input type="number" name="productprice" id="productprice" class="form-control col-md-12"
                            step=".01" placeholder="Product MRP" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="productUnit">Product Unit <span style="color:red">*</span></label>
                        <input type="text" name="productUnit" id="productUnit" class="form-control col-md-12"
                            placeholder="Product Unit" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="productOfferprice">Vendor Discount<span style="color:red">*</span></label>
                        <input type="number" name="productOfferprice" id="productOfferprice"
                            class="form-control col-md-12" step=".01" placeholder="Vendor Discount" required>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <div class="dropzone" id="dropzone">

                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <label for="productDescription">Product Description<span style="color:red">*</span></label>
                        <textarea id="compose-textarea" class="form-control" name="productDescription" style="height: 300px">
                            <p>Product Description here.</p>

                        </textarea>
                    </div>
                </div>




            </div>
            @csrf
        </form>
        <script type="text/javascript">
            Dropzone.options.dropzone = {
                maxFilesize: 12,
                renameFile: function(file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    return time + file.name;
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                timeout: 50000,
                removedfile: function(file) {
                    var name = file.upload.filename;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ url('image/delete') }}',
                        data: {
                            filename: name
                        },
                        success: function(data) {
                            console.log("File has been successfully removed!!");
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    });
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },

                success: function(file, response) {
                    console.log(response);
                },
                error: function(file, response) {
                    return false;
                }
            };
        </script>
</body>

</html>
