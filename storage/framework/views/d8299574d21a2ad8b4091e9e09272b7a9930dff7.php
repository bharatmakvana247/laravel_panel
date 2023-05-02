
<?php $__env->startSection('title'); ?>
    <?php echo e($form_title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Product Table</h3>
                
                <a type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-block-normal"><i
                        class="fa fa-fw fa-plus me-1"></i>Add Product</a>
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
                    <form action="" method="POST" id="formID" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="container">
                            <center>
                                <div class="mb-4">
                                    <div id="imagePreview" class="profile-image">
                                        <?php if(!empty($product->product_image)): ?>
                                            <img src="<?php echo url('storage/productImage/' . @$product->product_image); ?>" alt="user-img" class="img-circle"
                                                style="height:100px;width:100px;border-radius:50px">
                                        <?php else: ?>
                                            <img src="<?php echo url('storage/productImage/default.png'); ?>" alt="user-img" class="img-circle"
                                                style="height:100px;width:100px;border-radius:50px">
                                        <?php endif; ?>
                                    </div>
                                    <?php echo Form::file('product_image', ['id' => 'hidden', 'class' => 'product_image', 'accept' => 'product_image/*']); ?>

                                    <span id="product_image_error" class="text-danger"></span>
                                </div>

                            </center>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-4">
                                        <label class="form-label" for="example-text-input-alt">Product Name<span
                                                class="text-danger">*</span></label>
                                        <?php echo Form::text('product_name', null, [
                                            'class' => 'form-control form-control-lg py-2',
                                            'id' => 'product_name',
                                            'placeholder' => 'Product Name Here',
                                        ]); ?>

                                        <span id="product_name_error" class="text-danger"></span>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label" for="example-text-input-alt">Product Price<span
                                                class="text-danger">*</span></label>
                                        <?php echo Form::text('product_price', null, [
                                            'class' => 'form-control form-control-lg py-2',
                                            'id' => 'product_price',
                                            'placeholder' => 'Product Price Here',
                                        ]); ?>

                                        <span id="product_price_error" class="text-danger"></span>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label" for="example-text-input-alt">Product Qty<span
                                                class="text-danger">*</span></label>
                                        <?php echo Form::text('product_qty', null, [
                                            'class' => 'form-control form-control-lg py-2',
                                            'id' => 'product_qty',
                                            'placeholder' => 'Product Qty Here',
                                        ]); ?>

                                        <span id="product_qty_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-4">
                                        <label class="form-label" for="example-select">Select Brand</label><span
                                            class="text-danger">*</span>
                                        <?php echo Form::select('brand_id', $brands_list, null, [
                                            'class' => 'form-select',
                                            'id' => 'brand_id',
                                            'placeholder' => 'Select Brand',
                                        ]); ?>

                                        <span id="product_brand_error" class="text-danger"></span>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label" for="example-select">Select Category</label><span
                                            class="text-danger">*</span>
                                        <?php echo Form::select('category_name', $category_list, null, [
                                            'class' => 'form-select',
                                            'id' => 'category_name',
                                            'placeholder' => 'Select Category',
                                        ]); ?>

                                        <span id="product_category_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="example-textarea-input-alt">Product Details<span
                                            class="text-danger">*</span></label>
                                    <div class="block block-rounded">
                                        <div class="mb-4">
                                            <textarea id="js-ckeditor" class="product_details_class" name="product_details"></textarea>
                                        </div>
                                    </div>
                                    
                                    <span id="product_details_error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="submit" class="btn btn-alt-success">Submit</button>
                            <button type="submit" id="resProduct" class="btn btn-alt-primary">
                                Reset
                            </button>
                            <a type="submit" href="<?php echo e(route('admin.product.index')); ?>" class="btn btn-alt-danger">
                                Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pull-left" id="exampleModalLabel1">Category Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body testdata">
                    <h3>Modal Body</h3>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('styles'); ?>
    <style>
        #hidden {
            display: none;
            height: 100px;
            width: 100px;
            border-radius: 50px;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('backend.pages.product.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('backend.theme.deleteSweelAlert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#formID").on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let productname = $('#product_name').val();
                // let productdetails = $('#js-ckeditor').val();
                let productdetails = $('.product_details_class').val();
                console.log("pro-Details  :", productdetails);
                let productprice = $('#product_price').val();
                let productqty = $('#product_qty').val();
                let categoryname = $('#category_name').val();
                let brandname = $('#brand_id').val();
                let productimage = $('.product_image').val();
                $.ajax({
                    url: "<?php echo e(route('admin.product.store')); ?>",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log("daata", data);
                        if ($.isEmptyObject(data.error)) {
                            if (data.statusCode == 200) {
                                location.reload();
                            } else if (data.statusCode == 400) {
                                location.reload();
                            }
                        } else {
                            console.log('error', data);
                            $("#product_name_error").html(data.product_name);
                            $("#product_details_error").html(data.product_details);
                            $("#product_price_error").html(data.product_price);
                            $("#product_qty_error").html(data.product_qty);
                            $("#product_brand_error").html(data.brand_id);
                            $("#product_category_error").html(data.category_name);
                            $("#product_image_error").html(data.product_image);
                        }
                    }
                });
            });
        });
    </script>

    <script>
        $(document).on("click", "a.ShowProducts", function(e) {
            console.log("Product Show was Clicked :)");
            let row = $(this);
            let id = $(this).attr('data-id');
            console.log("Id :",id);

            $.ajax({
                    url: "<?php echo e(route('admin.product.show')); ?>",
                    type: 'get',
                    data: {
                        id: id
                    },
                    success: function(msg) {
                        console.log("Msg :",msg);
                        $('.testdata').html(msg);
                        $('#basicModal').modal('show');
                    },
                    error: function(err) {
                        console.log("err", err);
                        swal("Error!", 'Error in Record Not Show', "error");
                        // smilify("Error!", 'Error in Record Not Show');
                    }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laravel_panel\resources\views/backend/pages/product/index.blade.php ENDPATH**/ ?>