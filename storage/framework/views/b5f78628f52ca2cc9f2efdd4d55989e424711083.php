

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Patients</h1>
    <a href="<?php echo e(route('patients.create')); ?>" class="btn btn-primary mb-3">Add New Patient</a>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Phone</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($patient->name); ?></td>
                <td><?php echo e($patient->email); ?></td>
                <td><?php echo e($patient->phone); ?></td>
                <td>
                    <a href="<?php echo e(route('patients.show', $patient->id)); ?>" class="btn btn-info btn-sm">View</a>
                    <a href="<?php echo e(route('patients.edit', $patient->id)); ?>" class="btn btn-warning btn-sm">Edit</a>
                    <form action="<?php echo e(route('patients.destroy', $patient->id)); ?>" method="POST" style="display:inline-block">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this patient?')">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="4">No patients yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rehab-center\resources\views/patients/index.blade.php ENDPATH**/ ?>