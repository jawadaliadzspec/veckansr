<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.coupon.index') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.coupon.index')); ?>"><?php echo app('translator')->get('Active'); ?>
                    <?php if($allCoupon): ?>
                    <span class="badge rounded-pill bg--white text-muted"><?php echo e($allCoupon); ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.coupon.approved') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.coupon.approved')); ?>"><?php echo app('translator')->get('Approved'); ?>
                    <?php if($approvedCoupon): ?>
                    <span class="badge rounded-pill bg--white text-muted"><?php echo e($approvedCoupon); ?></span>
                    <?php endif; ?>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.coupon.pending') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.coupon.pending')); ?>"><?php echo app('translator')->get('Pending'); ?>
                    <?php if($pendingCoupon): ?>
                    <span class="badge rounded-pill bg--white text-muted"><?php echo e($pendingCoupon); ?></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>
    </div>
</div><?php /**PATH D:\adzspec\veckansr\application\resources\views/admin/components/tabs/coupon.blade.php ENDPATH**/ ?>