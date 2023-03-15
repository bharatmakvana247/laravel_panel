@extends('backend.layouts.master')
@section('title')
    {{ $form_title }}
@endsection
@section('content')
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


    {{-- -- Add Product Content -- --}}
    @include('backend.pages.product.addProduct')
    {{-- Edit Product Content --}}

    <div class="modal fade productEdit" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pull-left" id="exampleModalLabel1">Product Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body editProductData">

                </div>
            </div>
        </div>
    </div>

    {{-- End Product Content --}}
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
    {{-- Product Datatable --}}
    @include('backend.pages.product.datatable')
    {{-- Sweet Alert Delete Content --}}
    @include('backend.theme.deleteSweelAlert')
    {{-- Product Add Using --}}
    @include('backend.pages.product.addProductJs')
    {{-- Image Content Start --}}
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
        $(document).on("click", "a.editProduct", function(e) {
            var row = $(this);
            var id = $(this).attr('data-id');
            var url = '{{ route('admin.product.edit', ':id') }}';
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    id: id,
                },
                success: function(data) {
                    // console.log("data: ", data);
                    if ($.isEmptyObject(data.error)) {
                        $('.editProductData').html(data);
                        $('.productEdit').modal('show');
                    } else {
                        swal("Error!", 'Error in Record Not Show', "error");
                    }

                },
            });
        });
    </script>
@endsection
