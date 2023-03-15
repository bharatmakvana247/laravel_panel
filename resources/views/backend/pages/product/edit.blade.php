<div class="container ">
    {!! Form::model($product, [
        'method' => 'post',
        'id' => 'editProduct',
        'files' => true,
        'enctype' => 'multipart/form-data',
        // 'route' => ['admin.product.update', $product->product_id],
    ]) !!}
    @csrf
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <center>
                <div class="mb-4">
                    <div id="imagePreview" class="profile-image">
                        @if (!empty($product->product_image))
                            <img src="{!! url('storage/productImage/' . @$product->product_image) !!}" alt="user-img" class="img-circle"
                                style="height:100px;width:100px;border-radius:50px">
                        @else
                            <img src="{!! url('storage/productImage/default.png') !!}" alt="user-img" class="img-circle"
                                style="height:100px;width:100px;border-radius:50px">
                        @endif
                    </div>
                    {!! Form::file('product_image', [
                        'id' => 'hidden',
                        'class' => 'product_image_class',
                        'accept' => 'product_image/*',
                    ]) !!}
                </div>
            </center>
            <div class="mb-4">
                <label class="form-label" for="example-text-input-alt">Product Name<span
                        class="text-danger">*</span></label>
                {!! Form::text('product_name', null, [
                    'class' => 'form-control form-control-lg form-control-alt py-2',
                    'id' => 'product_name_id',
                    'placeholder' => 'Product Name Here',
                ]) !!}
                <span id="product_name_error" class="text-danger"></span>
            </div>

            <div class="mb-4">
                <label class="form-label" for="example-select">Select Brand</label><span class="text-danger">*</span>
                {!! Form::select('brand_id', $brand_name, null, [
                    'class' => 'form-select',
                    'id' => 'brand_name_id',
                    'placeholder' => 'Select Brands',
                ]) !!}
                <span id="brand_name_error" class="text-danger"></span>
            </div>

            <div class="mb-4">
                <label class="form-label" for="example-select">Select Category</label><span class="text-danger">*</span>
                {!! Form::select('category_name', $category_name, null, [
                    'class' => 'form-select',
                    'id' => 'category_name_id',
                    'placeholder' => 'Select Categories',
                ]) !!}
                <span id="category_name_error" class="text-danger"></span>
            </div>

            <div class="mb-4">
                <label class="form-label" for="example-textarea-input-alt">Product Details<span
                        class="text-danger">*</span></label>
                {!! Form::textarea('product_details', null, [
                    'class' => 'form-control form-control-lg form-control-alt py-2 product_details_class',
                    'rows' => '4',
                    'id' => 'product_details_id',
                    'placeholder' => 'Product Details Here',
                ]) !!}
                <span id="product_details_error" class="text-danger"></span>
            </div>

            <div class="mb-4">
                <label class="form-label" for="example-text-input-alt">Product Price<span
                        class="text-danger">*</span></label>
                {!! Form::text('product_price', null, [
                    'class' => 'form-control form-control-lg form-control-alt py-2',
                    'id' => 'product_price_id',
                    'placeholder' => 'Product Price Here',
                ]) !!}
                <span id="product_price_error" class="text-danger"></span>
            </div>

            <div class="mb-4">
                <label class="form-label" for="example-text-input-alt">Product Qty<span
                        class="text-danger">*</span></label>
                {!! Form::text('product_qty', null, [
                    'class' => 'form-control form-control-lg form-control-alt py-2',
                    'id' => 'product_qty_id',
                    'placeholder' => 'Product Qty Here',
                ]) !!}
                <span id="product_qty_error" class="text-danger"></span>
            </div>

            <div class="row items-push">
                <div class="col-lg-7 offset-lg">
                    <button type="submit" class="btn btn-alt-success">Update</button>
                    <button type="submit" class="btn btn-alt-danger"><a href="{{ route('admin.dashboard') }}">
                            Cancel</a></button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

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

<style>
    #hidden {
        display: none;
        height: 100px;
        width: 100px;
        border-radius: 50px;
    }
</style>

{{-- <script>
    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#editProduct").on('submit', function(e) {
            alert("Edit Product here", id);
            // var id = $product_id;
            console.log("id :", id);
            e.preventDefault();
            let formData = new FormData(this);
            console.log("formData  :", formData);
            let productname = $('#product_name_id').val();
            // let productdetails = $('#js-ckeditor').val();
            let productdetails = $('#product_details_id').val();
            let productprice = $('#product_price_id').val();
            let productqty = $('#product_qty_id').val();
            let categoryname = $('#category_name_id').val();
            let brandname = $('#brand_name_id').val();
            let productimage = $('.product_image_class').val();

            var url = '{{ route('admin.product.update', ':id') }}';
            url = url.replace(':id', id);
            console.log("url  :", url);
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log("Success data", data);
                    if ($.isEmptyObject(data.error)) {
                        console.log("Error");
                    } else {
                        console.log('error', data);
                        $("#product_name_error").html(data.product_name);
                        $("#product_details_error").html(data.product_details);
                        $("#product_price_error").html(data.product_price);
                        $("#product_qty_error").html(data.product_qty);
                        $("#product_brand_error").html(data.brand_id);
                        $("#product_category_error").html(data.category_name);
                        // $("#product_image_error").html(data.product_image);
                    }
                }
            });
        });
    });
</script> --}}
