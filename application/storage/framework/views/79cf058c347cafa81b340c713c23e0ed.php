<?php $__env->startSection('content'); ?>
    <section class="login-section py-115">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="log-in-box wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                        <div class="login wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                            <h2 class="welcome-text"><?php echo app('translator')->get('Login Your Account'); ?></h2>
                            <form method="POST" action="<?php echo e(route('user.login')); ?>" class="verify-gcaptcha">
                                <?php echo csrf_field(); ?>
                                <div class="form-group pwow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                                    <input type="text" autocomplete="off" class="form--control mb-3" id="username" name="username" required placeholder="">
                                    <label class="form--label"><?php echo app('translator')->get('Username or Email'); ?></label>
                                </div>
                                <div class="form-group wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                                    <input type="password" id="your-password" name="password"  autocomplete="off" placeholder=" " class="form--control mb-3 wow animate__animated animate__fadeInUp" data-wow-delay="0.4s" required>
                                    <label class="form--label"><?php echo app('translator')->get('Password'); ?></label>
                                </div>
                                <?php if (isset($component)) { $__componentOriginalff0a9fdc5428085522b49c68070c11d6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff0a9fdc5428085522b49c68070c11d6 = $attributes; } ?>
<?php $component = App\View\Components\Captcha::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('captcha'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Captcha::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff0a9fdc5428085522b49c68070c11d6)): ?>
<?php $attributes = $__attributesOriginalff0a9fdc5428085522b49c68070c11d6; ?>
<?php unset($__attributesOriginalff0a9fdc5428085522b49c68070c11d6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff0a9fdc5428085522b49c68070c11d6)): ?>
<?php $component = $__componentOriginalff0a9fdc5428085522b49c68070c11d6; ?>
<?php unset($__componentOriginalff0a9fdc5428085522b49c68070c11d6); ?>
<?php endif; ?>
                                <div class="login-meta mb-3 wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                                    <div class="form--check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                        <label for="remember" class="form-check-label"><?php echo app('translator')->get('Remember me'); ?></label>
                                    </div>
                                    <a class="text--base" href="<?php echo e(route('user.password.request')); ?>"><?php echo app('translator')->get('Forgot Your Password'); ?>?</a>
                                    
                                </div>
                                <button class="btn btn--base wow animate__animated animate__fadeInUp" data-wow-delay="0.5s"><?php echo app('translator')->get('Login'); ?></button>
                            </form>
                            <p class="pt-3 wow animate__animated animate__fadeInUp" data-wow-delay="0.6s"><?php echo app('translator')->get('Don\'t have any account?'); ?>  
                                <a href="<?php echo e(route('user.register')); ?>" target="blank" class="text--base"> <?php echo app('translator')->get('Create Account'); ?></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($activeTemplate.'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/veckansr/application/resources/views/presets/default/user/auth/login.blade.php ENDPATH**/ ?>