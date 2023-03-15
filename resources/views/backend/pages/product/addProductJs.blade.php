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
            let productprice = $('#product_price').val();
            let productqty = $('#product_qty').val();
            let categoryname = $('#category_name').val();
            let brandname = $('#brand_id').val();
            let productimage = $('.product_image').val();
            $.ajax({
                url: "{{ route('admin.product.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    // console.log("daata", data);
                    if ($.isEmptyObject(data.error)) {
                        if (data.statusCode == 200) {
                            location.reload();
                        } else if (data.statusCode == 400) {
                            location.reload();
                        }
                    } else {
                        // console.log('error', data);
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
