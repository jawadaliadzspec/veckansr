<!--========================== Header section Start ==========================-->
<?php
$languages = App\Models\Language::all();
$pages = App\Models\Page::where('tempname', $activeTemplate)->get();
$user = auth()->user();
?>
<div class="header-main-area">
    <div class="header" id="header">
        <div class="container position-relative">
            <div class="row">
                <div class="header-wrapper">
                    <!-- ham menu -->
                    <i class="fas fa-bars sidebar-menu-show-hide"></i>

                    <!-- logo -->
                    <div class="header-menu-wrapper align-items-center d-flex">
                        <div class="logo-wrapper">
                            <a href="<?php echo e(route('home')); ?>" class="logo-normal">
                                <img src="<?php echo e(getImage(getFilePath('logoIcon') . '/logo.png', '?' . time())); ?>"
                                    alt="<?php echo e(config('app.name')); ?>">
                            </a>
                        </div>
                    </div>
                    <!-- / logo -->

                    <div class="menu-wrapper">
                        <ul class="main-menu">
                            <?php if(auth()->guard()->check()): ?>
                            <li class="home">
                                <a class="<?php echo e(Request::routeIs('user.home') ? 'active' : 'demo-class'); ?>"
                                    href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                            </li>
                            <?php endif; ?>
                            <li class="home">
                                <a class="<?php echo e(Request::routeIs('home') ? 'active' : 'demo-class'); ?>"
                                    href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get('Home'); ?></a>
                            </li>
                            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($page->slug != '/'): ?>
                            <li>
                                <a class="<?php echo e(request()->url() === route('pages', [$page->slug]) ? 'active' : ''); ?>"
                                    href="<?php echo e(route('pages', [$page->slug])); ?>"><?php echo e(__($page->name)); ?>

                                </a>
                            </li>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                    </div>

                    <div class="menu-right-wrapper">
                        <ul>
                            <li class="language">
                                <div class="language-box">
                                    <select class="select langSel">
                                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($language->code); ?>" <?php if(Session::get('lang')===$language->
                                            code): ?> selected <?php endif; ?>>
                                            <?php echo e(__($language->name)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </li>
                            <?php if(auth()->guard()->check()): ?>
                            <li class="login-registration-list__item">
                                <a href="<?php echo e(route('user.logout')); ?>" class="login-registration-list__link">
                                    <?php echo app('translator')->get('Logout'); ?>
                                </a>
                            </li>
                            <?php else: ?>
                            <li class="login-registration-list__item">
                                <a href="<?php echo e(route('user.login')); ?>" class="login-registration-list__link">
                                    <?php echo app('translator')->get('Login'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--========================== Header section End ==========================-->

<!--========================== Sidebar mobile menu wrap Start ==========================-->
<div class="sidebar-menu-wrapper">
    <div class="offcanvas-header">
        <div class="logo">
            <div class="header-menu-wrapper align-items-center d-flex">
                <div class="logo-wrapper">
                    <a href="<?php echo e(route('home')); ?>" class="normal-logo" id="offcanvas-logo-normal"> <img
                            src="<?php echo e(getImage(getFilePath('logoIcon') . '/logo.png', '?' . time())); ?>"
                            alt="<?php echo e(config('app.name')); ?>"></a>
                </div>
            </div>
        </div>
        <button type="button" class="btn--close sidebar close-hide-show"><i class="fas fa-times"></i></button>
    </div>
    <div class="offcanvas-body">
        <?php if(auth()->guard()->check()): ?>
        <div class="user-info bg--img"
            style="background: url(<?php echo e(asset($activeTemplateTrue . 'images/bg/user2.jpg')); ?>)">
            <div class="user-thumb">
                <a href="javascript:void(0)">

                    <img src="<?php echo e(getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile'))); ?>"
                        alt="agent">
                </a>
            </div>
            <a href="javascript:void(0)">
                <h4><?php echo e(__($user->fullname)); ?></h4>
            </a>
        </div>
        <?php endif; ?>
        <ul class="side-Nav">

            <?php if(auth()->guard()->check()): ?>
            <li>
                <a class="<?php echo e(Request::routeIs('user.home') ? 'active' : 'aaa'); ?>"
                    href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
            </li>
            <?php endif; ?>
            <li>
                <a class="<?php echo e(Request::routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get('Home'); ?></a>
            </li>
            <li>

                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($page->slug != '/'): ?>
                <a class="<?php echo e(request()->url() === route('pages', [$page->slug]) ? 'active' : ''); ?>" aria-current="page"
                    href="<?php echo e(route('pages', [$page->slug])); ?>"><?php echo e(__($page->name)); ?>

                </a>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </li>

            <?php if(auth()->guard()->check()): ?>
            <li>
                <a href="<?php echo e(route('user.logout')); ?>"> <span>
                    </span><?php echo app('translator')->get('Logout'); ?></a>
            </li>
            <?php else: ?>
            <li>
                <a href="<?php echo e(route('user.login')); ?>"> <span>
                    </span><?php echo app('translator')->get('Login'); ?></a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div><?php /**PATH /var/www/html/veckansr/application/resources/views/presets/default/components/header.blade.php ENDPATH**/ ?>