@extends('backend.layouts.master')
@section('title')
    {{ $form_title }}
@endsection
@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Product Table</h3>
                {{-- <a href="{{ route('admin.product.create') }}" class="btn btn-sm btn-primary"> <i
                        class="fa fa-fw fa-plus me-1"></i> Add
                    Product</a> --}}
                <a type="button" class="btn btn-alt-primary push" data-bs-toggle="modal"
                    data-bs-target="#modal-block-normal">Add Product</a>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-striped table-bordered dt-responsive" id="quiztable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">ID</th>
                            <th class="d-none d-sm-table-cell">Name</th>
                            <th class="d-none d-sm-table-cell">Details</th>
                            <th class="d-none d-sm-table-cell">Category</th>
                            <th class="d-none d-sm-table-cell">brand</th>
                            <th class="d-none d-sm-table-cell">Price</th>
                            <th class="d-none d-sm-table-cell">Image</th>
                            <th class="d-none d-sm-table-cell notexport">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- -- Modal Add Product -- --}}
    <div class="modal" id="modal-block-normal" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">add product</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>

                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    <div class="form-group">
                        <input type="hidden" name="_token" id="csrf" value="{{ Session::token() }}">
                        <label for="email">Product name:</label>
                        <input type="text" class="form-control" id="product_name" placeholder="Enter Name"
                            name="product_name">
                        <div class="alert alert-danger product_name_error" style="display:none">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Product details:</label>
                        <input type="email" class="form-control" id="product_details" placeholder="Enter Email"
                            name="product_details">
                    </div>
                    <div class="form-group">
                        <label for="email">Product Price:</label>
                        <input type="text" class="form-control" id="product_price" placeholder="Enter Phone"
                            name="product_price">
                    </div>
                    <div class="form-group">
                        <label for="email">Product Qty:</label>
                        <input type="text" class="form-control" id="product_qty" placeholder="Enter City"
                            name="product_qty">
                    </div>
                    <button type="submit" class="btn btn-primary" id="butsave">Submit</button>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
@section('styles')
    <style>
        #hidden {
            display: none;
            height: 100px;
            width: 100px;
            border-radius: 50px;
        }
    </style>
@endsection
@section('scripts')
    @include('backend.pages.product.datatable')
    @include('backend.theme.deleteSweelAlert')

    {{-- Image Content --}}
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $('#imagePreview img').on('click', function() {
            $('input[type="file"]').trigger('click');
            $('input[type="file"]').change(function() {
                readURL(this);
            });
        });
    </script>

    <script>
        $(document).ready(function(e) {
            $('#butsave').on('click', function() {
                let productname = $('#product_name').val();
                let productdetails = $('#product_details').val();
                let productprice = $('#product_price').val();
                let productqty = $('#product_qty').val();
                // if (productname != "" && productdetails != "" && productprice != "" && productqty != "") {
                /*  $("#butsave").attr("disabled", "disabled"); */
                $.ajax({
                    url: "{{ route('admin.product.store') }}",
                    type: "POST",
                    data: {
                        _token: $("#csrf").val(),
                        product_name: productname,
                        product_details: productdetails,
                        product_price: productprice,
                        product_qty: productqty
                    },
                    cache: false,
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            if (data.statusCode == 200) {
                                location.reload();
                            } else if (data.statusCode == 400) {
                                location.reload();
                            }
                        } else {
                            // $('#product_name_error').html("EnterProd");
                            $("#product_name_error").html("Hello <b>world!</b>");
                            // 'product_name' => $validatedData - > errors() - > first(
                            //         'product_name'),
                            //     'product_details' => $validatedData - > errors() - > first(
                            //         'product_details'),
                            //     'product_price' => $validatedData - > errors() - > first(
                            //         'product_price'),
                            //     'product_qty' => $validatedData - > errors() - > first(
                            //         'product_qty'),
                            console.log(data);
                            // printErrorMsg(data.error);
                        }
                    }
                });
                // } else {
                //     alert('Please fill all the field !');
                // }
            });
        });

        // function printErrorMsg(msg) {
        //     $(".print-error-msg").find("ul").html('');
        //     $(".print-error-msg").css('display', 'block');
        //     $.each(msg, function(key, value) {
        //         $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        //     });
        // }
    </script>
@endsection
