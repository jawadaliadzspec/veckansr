<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('Name'); ?></th>
                                <th><?php echo app('translator')->get('Image'); ?></th>
                                <th><?php echo app('translator')->get('Status'); ?></th>
                                <th><?php echo app('translator')->get('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(__($item->name)); ?></td>
                                <td><img src="<?php echo e(getImage(getFilePath('store') . '/' . $item->image)); ?>" alt="<?php echo app('translator')->get('store-image'); ?>" style="width: 50px"></td>
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
                                            <button title="<?php echo app('translator')->get('Edit'); ?>"
                                                class="btn btn-sm btn--success editBtn" data-id="<?php echo e($item->id); ?>" data-status="<?php echo e($item->status); ?>" data-name="<?php echo e($item->name); ?>" data-description="<?php echo e($item->description); ?>">
                                                <i class="la la-edit"></i>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <button title="<?php echo app('translator')->get('Change Status'); ?>"
                                        data-id="<?php echo e($item->id); ?>"
                                        class="btn btn-sm btn--primary changeStatusBtn">
                                        <i class="las la-check"></i>
                                        </button>
                                        <button title="<?php echo app('translator')->get('Delete'); ?>"
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
                  
                </div>
            </div>
            <?php if($stores->hasPages()): ?>
            <div class="card-footer py-4">
                <?php echo e(paginateLinks($stores)); ?>

            </div>
        <?php endif; ?>
        </div><!-- card end -->
    </div>
</div>


<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="createModalLabel"> <?php echo app('translator')->get('Add New Store'); ?></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="las la-times"></i></button>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo e(route('admin.store.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row form-group">
                        <label><?php echo app('translator')->get('Name'); ?></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="<?php echo e(old('name')); ?>" name="name" required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label><?php echo app('translator')->get('Image'); ?></label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control"  name="image" required>
                        </div>
                        <p class="fs-12"><?php echo app('translator')->get('Recomended size:: 160x70 px.'); ?></p>
                    </div>
                    <div class="row form-group">
                        <label><?php echo app('translator')->get('Description'); ?></label>
                        <div class="col-sm-12">
                            <textarea class="form-control"  name="description" > </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                        value="add"><?php echo app('translator')->get('Submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel"><?php echo app('translator')->get('Update Store'); ?></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="las la-times"></i></button>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo e(route('admin.store.update')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="row form-group">
                        <label><?php echo app('translator')->get('Name'); ?></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="<?php echo e(old('name')); ?>" name="name" required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label><?php echo app('translator')->get('Image'); ?></label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control"  name="image" >
                        </div>
                        <p class="fs-12"><?php echo app('translator')->get('Recomended size:: 160x70 px.'); ?></p>
                    </div>
                    <div class="row form-group">
                        <label><?php echo app('translator')->get('Description'); ?></label>
                        <div class="col-sm-12">
                            <textarea class="form-control"  name="description" > </textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label><?php echo app('translator')->get('status'); ?></label>
                        <div class="col-sm-12">
                            <select name="status" class="form-control">
                                <option value="0" <?php echo e(@$item->status == 0 ? 'selected' : ''); ?>><?php echo app('translator')->get('Inactive'); ?></option>
                                <option value="1" <?php echo e(@$item->status == 1 ? 'selected' : ''); ?>><?php echo app('translator')->get('Active'); ?></option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                        value="add"><?php echo app('translator')->get('Submit'); ?></button>
                </div>
            </form>
        </div>
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
            <form class="form-horizontal" method="post" action="<?php echo e(route('admin.store.delete')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id">
                <div class="modal-body">
                   <span><?php echo app('translator')->get('Are You Sure Delete This Store'); ?></span>
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
            <form action="<?php echo e(route('admin.store.status.change')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Are you sure to'); ?> <span class="fw-bold"><?php echo app('translator')->get('see'); ?></span> <span
                            class="fw-bold withdraw-amount text-success"></span> <?php echo app('translator')->get('status change'); ?> <span
                            class="fw-bold withdraw-user"></span>?
                    </p>
                    <div class="form-group">
                        <label for="status" class="font-weight-bold"><?php echo app('translator')->get('Status'); ?></label>
                        <select name="status" class="form-select" id="status">
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
<a class="btn btn-sm btn--primary" data-bs-toggle="modal" data-bs-target="#createModal"><i
        class="las la-plus"></i><?php echo app('translator')->get('Add New'); ?></a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script>
    (function ($) {
        "use strict";
        $('.editBtn').on('click', function () {
            var modal = $('#editModal');

            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('input[name=name]').val($(this).data('name'));
            modal.find('textarea[name=description]').val($(this).data('description'));
            
            var statusValue = $(this).data('status');
            modal.find('select[name=status]').val(statusValue);
           
            modal.modal('show');
        });

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
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/veckansr/application/resources/views/admin/store/index.blade.php ENDPATH**/ ?>