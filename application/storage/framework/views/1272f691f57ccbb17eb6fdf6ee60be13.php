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
                                <th><?php echo app('translator')->get('parentCategory'); ?></th>
                                <th><?php echo app('translator')->get('Image'); ?></th>
                                <th><?php echo app('translator')->get('Status'); ?></th>
                                <th><?php echo app('translator')->get('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(__($item->name)); ?></td>
                                <td><?php echo e(__(optional($item->parent)->name ?? 'No Parent')); ?></td>
                                <td><img src="<?php echo e(getImage(getFilePath('category') . '/' . $item->image)); ?>" alt="<?php echo app('translator')->get('category-image'); ?>" style="width: 50px"></td>
                                <td>
                                    <?php if($item->status == 1): ?>

                                    <span class="badge badge--success"><?php echo app('translator')->get('Active'); ?></span>
                                    <?php else: ?>

                                    <span class="badge badge--danger"><?php echo app('translator')->get('Inactive'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="button--group">
                                        <button title="<?php echo app('translator')->get('Edit'); ?>"
                                            class="btn btn-sm btn--success editBtn" data-id="<?php echo e($item->id); ?>" data-status="<?php echo e($item->status); ?>" data-name="<?php echo e($item->name); ?>" data-description="<?php echo e($item->description); ?>" data-parent_id="<?php echo e($item->parent_id); ?>">
                                            <i class="la la-edit"></i>
                                        </button>
                                        <button title="<?php echo app('translator')->get('Edit'); ?>"
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
                    <?php if($categories->hasPages()): ?>
                        <div class="card-footer py-4">
                            <?php echo e(paginateLinks($categories)); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- card end -->
    </div>
</div>




<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="createModalLabel"> <?php echo app('translator')->get('Add New Category'); ?></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="las la-times"></i></button>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo e(route('admin.category.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row form-group">
                        <label><?php echo app('translator')->get('Name'); ?></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="<?php echo e(old('name')); ?>" name="name" required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label><?php echo app('translator')->get('parentCategory'); ?></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="parent_id">
                                <option value="" selected><?php echo app('translator')->get('Select Parent Category'); ?></option>
                                <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"> <?php echo e(__($item->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label><?php echo app('translator')->get('Image'); ?></label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control"  name="image" required>
                        </div>
                        <p class="fs-12"><?php echo app('translator')->get('Recomended size:: 64x64 px.'); ?></p>
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
                <h4 class="modal-title" id="editModalLabel"><?php echo app('translator')->get('Update Category'); ?></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="las la-times"></i></button>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo e(route('admin.category.update')); ?>" enctype="multipart/form-data">
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
                        <label><?php echo app('translator')->get('parentCategory'); ?></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="parent_id">
                                <option value=""><?php echo app('translator')->get('Select Parent Category'); ?></option>
                                <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"><?php echo e(__($item->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label><?php echo app('translator')->get('Image'); ?></label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control"  name="image" >
                        </div>
                        <p class="fs-12"><?php echo app('translator')->get('Recomended size:: 64x64 px.'); ?></p>
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
            <form class="form-horizontal" method="post" action="<?php echo e(route('admin.category.delete')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id">
                <div class="modal-body">
                   <span><?php echo app('translator')->get('Are You Sure Delete This Category'); ?></span>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                        value="add"><?php echo app('translator')->get('Delete'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

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
            modal.find('select[name=parent_id]').val($(this).data('parent_id'));
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


    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/veckansr/application/resources/views/admin/category/index.blade.php ENDPATH**/ ?>