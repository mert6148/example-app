<?php $__env->startSection('title', 'Laravel Editor'); ?>

<?php $__env->startSection('content'); ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Code Output -->
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-lg font-semibold mb-3">Output</h2>

            <div class="invalid-feedback" id="en">
                <pre class="code-block bg-gray-900 text-green-400 p-4 rounded" id="export">
                    <!-- JS ile doldurulacak -->
                </pre>
            </div>
        </div>

        <!-- Editor -->
        <div class="bg-white rounded shadow p-4">
            <h2 class="text-lg font-semibold mb-3">Editor</h2>

            <div class="editor-link border rounded p-3 min-h-[300px]"
                 contenteditable="true"
                 virtualkeyboardpolicy="false">
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php if(session('success')): ?>
    <div class="<?php echo e(session('success')); ?>">
        <nav class="navbar navbar-light bg-light justify-content-between">
            <a class="navbar-brand">Başarılı</a>
            <span class="navbar-text">
                <?php echo e(session('success')); ?>

            </span>
        </nav>
    </div>

    <div class="<?php echo e(section('scripts')); ?>">
        <script>
            setTimeout(function() {
                document.querySelector('.<?php echo e(session('success')); ?>').style.display = 'none';
            }, 3000);
        </script>

    </div>
<?php endif; ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\example-app\resources\views\pages\editor.blade.php ENDPATH**/ ?>