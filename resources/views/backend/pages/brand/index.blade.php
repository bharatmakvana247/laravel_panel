@extends('backend.layouts.master')
@section('title')
    {{ $form_title }}
@endsection
@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ $form_title }} Table</h3>
                <a href="javascript:void(0)" onClick="addBrandModal()" href="javascript:void(0)"
                    class="btn btn-sm btn-primary"><i class="fa fa-fw fa-plus me-1"></i> Add Brand</a>
            </div>


            <div class="block-content block-content-full">
                <table class="table table-striped table-bordered dt-responsive" id="quiztable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">ID</th>
                            <th class="d-none d-sm-table-cell">Brand</th>
                            <th class="d-none d-sm-table-cell notexport">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- -- Modal Add Brand -- --}}
    <div class="modal" id="modal-block-normal" tabindex="-1" role="dialog" aria-labelledby="modal-block-normal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="brandModal">add brand</h3>

                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <form action="javascript:void(0)" id="brandForm" name="brandForm" class="form-horizontal" method="POST"
                        enctype="multipart/form-data">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <input type="hidden" name="brand_id" id="brand_id">
                                    <div class="mb-4">
                                        <label class="form-label" for="example-text-input-alt">Brand Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="brand_name" name="brand_name"
                                            class='form-control form-control-lg py-2' id='example-text-input-alt'
                                            placeholder='Brand Name Here'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="submit" id="brandSubmit" class="btn btn-alt-success">Submit</button>
                            <button type="submit" id="resProduct" class="btn btn-alt-primary">
                                Reset
                            </button>
                            <a type="submit" href="{{ route('admin.brand.index') }}" class="btn btn-alt-danger">
                                Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>
    @include('backend.theme.deleteSweelAlert')
    <script type="text/javascript">
        $(document).ready(function() {
            var columns = [{
                    data: 'DT_RowIndex',
                    name: 'brand_id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'brand_name',
                    name: 'brand_name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];
            var buttons = [{
                    className: 'btn btn-sm btn-primary buttons-copy buttons-html5',
                    extend: 'copy',
                    text: '<i class="fa fa-print"></i> Copy',
                    exportOptions: {
                        columns: [0, 1, 2] // Column index which needs to export
                    }
                },
                {
                    className: 'btn btn-sm btn-primary buttons-excel buttons-html5',
                    extend: 'excel',
                    text: '<i class="fa fa-print"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2] // Column index which needs to export
                    }
                },
                {
                    className: 'btn btn-sm btn-primary buttons-csv buttons-html5',
                    extend: 'csv',
                    text: '<i class="fa fa-print"></i> CSV',
                    exportOptions: {
                        columns: [0, 1, 2] // Column index which needs to export
                    }
                },
                {
                    className: 'btn btn-sm btn-primary buttons-pdf buttons-html5',
                    extend: 'pdf',
                    text: '<i class="fa fa-print"></i> Pdf',
                    exportOptions: {
                        columns: [0, 1, 2] // Column index which needs to export
                    }
                },
                {
                    className: 'btn btn-sm btn-primary buttons-print buttons-html5',
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Print',
                    customize: function(win) {
                        $(win.document.body)
                            .css('font-size', '15pt')
                            .prepend(
                                '<img src="http://127.0.0.1:8000/storage/userImage/default.png" style="position:absolute; top:0; left:0;" />'
                            );
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                    exportOptions: {
                        columns: [0, 1, 2] // Column index which needs to export
                    }
                }
            ];
            var table = $('#quiztable').DataTable({
                lengthMenu: [
                    [5, 10, 25, 50, 100],
                    [5, 10, 25, 50, 100],
                ],
                pageLength: 5,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.brand.index') }}",
                dom: 'Blfrtip',
                columns: columns,
                buttons: buttons
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        //View Brand Modal
        function addBrandModal() {
            $('#brandForm').trigger("reset"); //formID
            $('#brandModal').html("Add Category"); //<h4> title
            $('#modal-block-normal').modal('show'); //modal open
            $('#id').val('');
        }

        //Submit Brand Modal
        $('#brandForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            console.log(formData, "formData");
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.brand.store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#modal-block-normal").modal('hide');
                    var oTable = $('#quiztable').dataTable();
                    oTable.fnDraw(false);
                    $("#brandSubmit").html('Submit');
                    $("#brandSubmit").attr("disabled", false);
                },
                error: function(err) {
                    console.log("err :", err);
                }
            });
        });


        //Edit Brand Modal
        $(document).ready(function() {
            $(document).on("click", "a.editBrand", function(e) {
                var id = $(this).attr('id');
                console.log(id, "id");
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.brand.edit') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#brandModal').html("Edit product");
                        $("#modal-block-normal").modal('show');
                        $('#brand_id').val(res.brand_id);

                        // Get Old val in brand
                        $('#brand_name').val(res.brand_name);

                    },
                    error: function(err) {
                        console.log("err :", err);
                    }
                });
            });
        });

        //Delete Brand Modal
        $(document).ready(function() {
            $(document).on("click", "a.deleteBrand", function(e) {
                var dId = $(this).attr('id');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.brand.delete') }}",
                    data: {
                        id: dId
                    },
                    dataType: 'json',
                    success: (data) => {
                        var oTable = $('#quiztable').dataTable();
                        oTable.fnDraw(false);
                    },
                    error: function(err) {
                        console.log("err :", err);
                    }
                });

            });
        });
    </script>
@endsection
