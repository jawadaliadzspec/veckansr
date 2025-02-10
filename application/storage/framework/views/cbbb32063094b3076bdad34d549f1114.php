
<?php $__env->startSection('panel'); ?>
<?php echo $__env->make('admin.components.tabs.coupon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('Title'); ?></th>
                                <th><?php echo app('translator')->get('Image'); ?></th>
                                <th><?php echo app('translator')->get('Category'); ?></th>
                                <th><?php echo app('translator')->get('Code'); ?></th>
                                <th><?php echo app('translator')->get('Featured'); ?></th>
                                <th><?php echo app('translator')->get('Exclusive'); ?></th>
                                <th><?php echo app('translator')->get('Status'); ?></th>
                                <th><?php echo app('translator')->get('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(__($item->title)); ?></td>
                                <td><img src="<?php echo e(getImage(getFilePath('store') . '/' . @$item->store->image)); ?>" alt="<?php echo app('translator')->get('store-image'); ?>" style="width: 80px"></td>
                                <td><?php echo e(__(@$item->category->name)); ?></td>
                                <td><?php echo e(__($item->code)); ?></td>
                                <td>
                                    <?php if($item->is_featured == 1): ?>
                                    
                                    <span class="base-color"><i class="fas fa-check-circle"></i></span>
                                    <?php else: ?> 
                                    
                                    <span><i class="fas fa-times"></i></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($item->is_exclusive == 1): ?>
                                    
                                    <span><i class="fas fa-check-circle"></i></span>
                                    <?php else: ?> 
                                    
                                    <span><i class="fas fa-times"></i></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($item->status == 1): ?>
                                    
                                    <span class="badge badge--success"><?php echo app('translator')->get('Active'); ?></span>
                                    <?php else: ?> 
                                    
                                    <span class="badge badge--danger"><?php echo app('translator')->get('Inactive'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="button--group">
                                        <?php if($item->user_id == 0): ?>
                                            <a href="<?php echo e(route("admin.coupon.edit",$item->id)); ?>" title="<?php echo app('translator')->get('Edit'); ?>"
                                                class="btn btn-sm btn--success">
                                                <i class="la la-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                        <button title="<?php echo app('translator')->get('Change Status'); ?>"
                                         data-id="<?php echo e($item->id); ?>"
                                            class="btn btn-sm btn--primary changeStatusBtn">
                                            <i class="las la-check"></i>
                                        </button>
                                        <button title="<?php echo app('translator')->get('Remove'); ?>"
                                            class="btn btn-sm btn--danger ms-1 deleteBtn" data-id="<?php echo e($item->id); ?>">
                                            <i class="la la-trash"></i>
                                        </button>
                                     
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table><!-- table end -->
                    <?php if($coupons->hasPages()): ?>
                        <div class="card-footer py-4">
                            <?php echo e(paginateLinks($coupons)); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- card end -->
    </div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel"><?php echo app('translator')->get('Delete Confirmation'); ?></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="las la-times"></i></button>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo e(route('admin.coupon.delete')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id">
                <div class="modal-body">
                   <span><?php echo app('translator')->get('Are You Sure Delete This Coupon'); ?></span>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                        value="add"><?php echo app('translator')->get('Delete'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="statusModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mb-2"><?php echo app('translator')->get('Status Change Confirmation'); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="<?php echo e(route('admin.coupon.status.change')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Are you sure to'); ?> <span class="fw-bold"><?php echo app('translator')->get('see'); ?></span> <span
                            class="fw-bold withdraw-amount text-success"></span> <?php echo app('translator')->get('status change'); ?> <span
                            class="fw-bold withdraw-user"></span>?
                    </p>
                    <div class="form-group">
                        <label for="status" class="font-weight-bold"><?php echo app('translator')->get('Status'); ?></label>
                        <select name="status" class="form-control" id="status">
                            <option value="1"><?php echo app('translator')->get('Approved'); ?></option>
                            <option value="0"><?php echo app('translator')->get('Pending'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitButton" class="btn btn--primary btn-global"><?php echo app('translator')->get('Submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div

<?php $__env->stopSection(); ?>


<?php $__env->startPush('breadcrumb-plugins'); ?>
<a href="<?php echo e(route('admin.coupon.create')); ?>" class="btn btn-sm btn--primary"><i
        class="las la-plus"></i><?php echo app('translator')->get('Add New'); ?></a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script>
    (function ($) {
        "use strict";
        // Delete
        $('.deleteBtn').on('click', function () {
            var modal = $('#deleteModal');
            modal.find('input[name=id]').val($(this).data('id'));

            modal.modal('show');

        });

          // change status
          $('.changeStatusBtn').on('click', function () {
            var modal = $('#statusModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });

        
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\adzspec\veckansr\application\resources\views/admin/coupon/index.blade.php ENDPATH**/ ?>