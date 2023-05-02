<script src="<?php echo e(asset('assets/admin/js/oneui.app.min.js')); ?>"></script>

<!-- Page JS Plugins -->


<!-- Page JS Code -->



<?php if (isset($component)) { $__componentOriginalf6d1e1ab7a8df2de5d0bdc28df8775f180a35b0c = $component; } ?>
<?php $component = Mckenziearts\Notify\NotifyComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('notify-messages'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Mckenziearts\Notify\NotifyComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf6d1e1ab7a8df2de5d0bdc28df8775f180a35b0c)): ?>
<?php $component = $__componentOriginalf6d1e1ab7a8df2de5d0bdc28df8775f180a35b0c; ?>
<?php unset($__componentOriginalf6d1e1ab7a8df2de5d0bdc28df8775f180a35b0c); ?>
<?php endif; ?>
<?php echo notifyJs(); ?>






<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>



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
<script src="<?php echo e(asset('assets/admin/js/plugins/ckeditor/ckeditor.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/plugins/simplemde/simplemde.min.js')); ?>"></script>
<script>
    One.helpersOnLoad(['js-ckeditor']);
</script>
<!--End cKEditor Page JS Plugins (CKEditor + SimpleMDE plugins) -->


<script>
    $(document).keydown(function(event) {
        if (event.ctrlKey && event.which === 66) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success m-1",
                    cancelButton: "btn btn-danger m-1",
                    input: "form-control"
                },
                // buttonsStyling: false
                buttonsStyling: !1,
            })
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                icon: "warning",
                showCancelButton: !0,
                customClass: {
                    confirmButton: "btn btn-danger m-1",
                    cancelButton: "btn btn-secondary m-1"
                },
                confirmButtonText: "Yes, Screen Locked it!",
                html: !1,
                preConfirm: e => new Promise((e => {
                    setTimeout((() => {
                        e()
                    }), 50)
                }))
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire(
                        'Screen Locked!',
                        'Your file has been Screen Locked.',
                        'success'
                    ).then(function() {
                        location.href = '<?php echo e(route('admin.lock.update')); ?>';
                    });
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            });
        }
    });
</script>


<?php echo $__env->yieldContent('scripts'); ?>
<?php /**PATH D:\laravel_panel\resources\views/backend/theme/footerScript.blade.php ENDPATH**/ ?>