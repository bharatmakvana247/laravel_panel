<script src="{{ asset('assets/admin/js/oneui.app.min.js') }}"></script>

<!-- Page JS Plugins -->
{{-- <script src="{{ asset('assets/admin/js/plugins/chart.js/chart.min.js') }}"></script> --}}

<!-- Page JS Code -->
<script src="{{ asset('assets/admin/js/pages/be_pages_dashboard.min.js') }}"></script>

{{-- Notify js --}}
<x:notify-messages />
@notifyJs

{{-- Loader --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> --}}

{{-- jquery cdn --}}
{{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


{{-- Sweet Alert --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // $(document).ready(function() {
    //     One.loader('show');
    //     setTimeout(function() {
    //         One.loader('hide');
    //     }, 1500);
    // });
</script>
<!--Start cKEditor Page JS Plugins (CKEditor + SimpleMDE plugins) -->
<script src="{{ asset('assets/admin/js/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/simplemde/simplemde.min.js') }}"></script>
<script>
    One.helpersOnLoad(['js-ckeditor']);
</script>
<!--End cKEditor Page JS Plugins (CKEditor + SimpleMDE plugins) -->
@yield('scripts')
