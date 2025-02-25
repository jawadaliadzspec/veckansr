<?php $__env->startSection('panel'); ?>
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body px-4">
                    <form method="post" action="<?php echo e(route('admin.coupon.update', $coupon->id)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Title'); ?> </label>
                                    <input type="text" class="form-control" name="title" placeholder="<?php echo app('translator')->get('Title'); ?>"
                                         value="<?php echo e($coupon->title); ?>" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Category'); ?> </label>





                                    <select class="form-control" name="category_id">
                                        <option value=""><?php echo app('translator')->get('Select Parent Category'); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>" <?php echo e($category->id == $coupon->category_id ? 'selected' : ''); ?>>
                                                <?php echo e($category->name); ?>

                                            </option>
                                            <?php if($category->children->count() > 0): ?>
                                                <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($child->id); ?>" <?php echo e($child->id == $coupon->category_id ? 'selected' : ''); ?>>
                                                        -- <?php echo e($child->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Store'); ?></label>
                                    <select class="form-control" name="store_id" required>
                                        <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->id); ?>" <?php echo e($item->id== $coupon->store_id ? "selected" : ''); ?>> <?php echo e(__($item->name)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Path'); ?> </label>
                                    <input type="text" class="form-control" placeholder="<?php echo app('translator')->get('Path'); ?>"
                                           name="path" value="<?php echo e($coupon->path); ?>" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Code'); ?> </label>
                                    <input type="text" class="form-control" placeholder="<?php echo app('translator')->get('Code'); ?>"
                                        name="code" value="<?php echo e($coupon->code); ?>" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Link'); ?> </label>
                                    <input type="text" class="form-control" placeholder="<?php echo app('translator')->get('Link'); ?>"
                                        name="link" value="<?php echo e($coupon->link); ?>" />
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="type" class="font-weight-bold"><?php echo app('translator')->get('Status'); ?></label>
                                    <select name="status" class="form-select">
                                        <option value="1" <?php echo e($coupon->status ==1 ?"selected": ""); ?>><?php echo app('translator')->get('Active'); ?></option>
                                        <option value="0" <?php echo e($coupon->status ==0 ?"selected": ""); ?>><?php echo app('translator')->get('Inactive'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Start Date'); ?> </label>
                                    <input type="date" class="form-control" placeholder="<?php echo app('translator')->get('Start Date'); ?>"
                                        name="start_date" value="<?php echo e($coupon->start_date ? \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d') : ''); ?>" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('End Date'); ?> </label>
                                    <input type="date" class="form-control" placeholder="<?php echo app('translator')->get('End Date'); ?>"
                                        name="expire_date" value="<?php echo e($coupon->expire_date ? \Carbon\Carbon::parse($coupon->expire_date)->format('Y-m-d') : ''); ?>" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Description'); ?> </label>
                                    <textarea name="description" class="form-control" id="description"><?php echo $coupon->description; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-4">
                                    <label class="fw-bold" for="is_featured"><?php echo app('translator')->get('Is Featured'); ?></label>
                                    <label class="switch m-0" for="is_featured">
                                        <input type="checkbox" class="toggle-switch" name="is_featured" id="is_featured" <?php echo e($coupon->is_featured ?
                                            'checked' : null); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-4">
                                    <label class="fw-bold" for="is_exclusive"><?php echo app('translator')->get('Is Exclusive'); ?></label>
                                    <label class="switch m-0" for="is_exclusive">
                                        <input type="checkbox" class="toggle-switch" name="is_exclusive"  id="is_exclusive" <?php echo e($coupon->is_exclusive ?
                                            'checked' : null); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-4">
                                    <label class="fw-bold" for="is_deal"><?php echo app('translator')->get('Is Deal'); ?></label>
                                    <label class="switch m-0" for="is_deal">
                                        <input type="checkbox" class="toggle-switch" name="is_deal"  id="is_deal" <?php echo e($coupon->is_deal ?
                                            'checked' : null); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-end">
                                <button type="submit" class="btn btn--primary btn-global"><?php echo app('translator')->get('Update'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/veckansr/application/resources/views/admin/coupon/edit.blade.php ENDPATH**/ ?>