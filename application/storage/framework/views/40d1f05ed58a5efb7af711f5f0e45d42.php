<?php $__env->startSection('content'); ?>
<?php
    $policyPages = getContent('policy_pages.element',false,null,true);
?>
<section class="signup-section py-115">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12">
                
                <div class="log-in-box">
                    <h3 class="welcome-text  wow animate__animated animate__fadeInUp mb-4" data-wow-delay="0.3s"><?php echo app('translator')->get('Register'); ?></h3>
                    <form action="<?php echo e(route('user.register')); ?>" method="POST" class="verify-gcaptcha">
                        <?php echo csrf_field(); ?> 
                            <div class="row mb-4 wow animate__animated animate__fadeInUp" data-wow-delay="0.4s">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form--control checkUser" name="username" value="<?php echo e(old('username')); ?>" placeholder="" required>
                                        <label class="form--label"><?php echo app('translator')->get('Username'); ?></label>
                                        <small class="text-danger usernameExist"></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form--control checkUser" name="email" value="<?php echo e(old('email')); ?>" placeholder="" required>
                                        <label class="form--label"><?php echo app('translator')->get('E-Mail Address'); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4 wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="country" class="form--control">
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option data-mobile_code="<?php echo e($country->dial_code); ?>" value="<?php echo e($country->country); ?>" data-code="<?php echo e($key); ?>"><?php echo e(__($country->country)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <label class="form--label"><?php echo app('translator')->get('Country'); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group ">
                                            <span class="input-group-text mobile-code"> </span>
                                            <input type="hidden" name="mobile_code">
                                            <input type="hidden" name="country_code">
                                            <input type="number" name="mobile" value="<?php echo e(old('mobile')); ?>" class="form-control form--control checkUser" placeholder="<?php echo app('translator')->get('Mobile'); ?>" required>
                                        </div>
                                        <small class="text-danger mobileExist"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4 wow animate__animated animate__fadeInUp" data-wow-delay="0.6s">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" class="form--control" name="password" placeholder="" required>
                                        <label class="form--label"><?php echo app('translator')->get('Password'); ?></label>
                                    </div>
                                </div>
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" class="form--control" name="password_confirmation" placeholder="" required>
                                        <label class="form--label"><?php echo app('translator')->get('Confirm Password'); ?></label>
                                    </div>
                                </div>
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

                        <?php if($general->agree): ?>
                        <div class="form--check mb-3">
                            <input class="form-check-input" type="checkbox" id="agree" <?php if(old('agree')): echo 'checked'; endif; ?> name="agree" required>
                            <label class="form-check-label" for="agree"><?php echo app('translator')->get('I agree with'); ?> <?php $__currentLoopData = $policyPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <a class="text--base" href="<?php echo e(route('policy.pages',[slug($policy->data_values->title),$policy->id])); ?>"><?php echo e(__($policy->data_values->title)); ?></a> <?php if(!$loop->last): ?>, <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></label>
                        </div>
                        <?php endif; ?>
                        <div class="form-group mb-3">
                            <button type="submit" id="recaptcha" class="btn btn--base"> <?php echo app('translator')->get('Register'); ?></button>
                        </div>
                        <p class="mb-0"><?php echo app('translator')->get('Already have an account?'); ?> <a class="text--base" target="_blank" href="<?php echo e(route('user.login')); ?>"><?php echo app('translator')->get('Login'); ?></a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="existModalLongTitle"><?php echo app('translator')->get('You are with us'); ?></h5>
        <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i class="las la-times"></i>
        </span>
      </div>
      <div class="modal-body">
        <h6 class="text-center"><?php echo app('translator')->get('You already have an account please Login '); ?></h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
        <a href="<?php echo e(route('user.login')); ?>" class="btn btn--base btn-sm"><?php echo app('translator')->get('Login'); ?></a>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
<style>
    .country-code .input-group-text{
        background: #fff !important;
    }
    .country-code select{
        border: none;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script>
      "use strict";
        (function ($) {
            <?php if($mobileCode): ?>
            $(`option[data-code=<?php echo e($mobileCode); ?>]`).attr('selected','');
            <?php endif; ?>

            $('select[name=country]').change(function(){
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));

            $('.checkUser').on('focusout',function(e){
                var url = '<?php echo e(route('user.checkUser')); ?>';
                var value = $(this).val();
                var token = '<?php echo e(csrf_token()); ?>';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {mobile:mobile,_token:token}
                }
                if ($(this).attr('name') == 'email') {
                    var data = {email:value,_token:token}
                }
                if ($(this).attr('name') == 'username') {
                    var data = {username:value,_token:token}
                }
                $.post(url,data,function(response) {
                  if (response.data != false && response.type == 'email') {
                    $('#existModalCenter').modal('show');
                  }else if(response.data != false){
                    $(`.${response.type}Exist`).text(`${response.type} already exist`);
                  }else{
                    $(`.${response.type}Exist`).text('');
                  }
                });
            });
        })(jQuery);

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate.'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/veckansr/application/resources/views/presets/default/user/auth/register.blade.php ENDPATH**/ ?>