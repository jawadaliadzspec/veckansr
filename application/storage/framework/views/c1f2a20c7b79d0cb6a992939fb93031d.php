
<?php $__env->startSection('content'); ?>
    <?php
        $contact = getContent('contact_us.content', true);
    ?>
    <!-- ==================== Contact Form Start Here ==================== -->
    <section class="contact-bottom section-bg py-115">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-content">
                        <div class="title-wrap">
                            <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                                <?php echo e(__($contact->data_values->title)); ?>

                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gy-3 justify-content-center">
                <div class="col-lg-5 wow animate__animated animate__fadeInUp">
                    <div class="col-lg-12">
                        <div class="contact-info">
                            <div class="contact-info__addres-wrap">
                                <div class="single_wrapper">
                                    <h4><?php echo app('translator')->get('Call Us'); ?></h4>
                                    <div class="single-info">
                                        <div class="cont-icon">
                                            <i class="far fa-envelope"></i>
                                        </div>
                                        <div class="cont-text">
                                            <h6><a
                                                    href="tel:<?php echo e(__($contact->data_values->contact_number)); ?>"><?php echo e(__($contact->data_values->contact_number)); ?></a>
                                            </h6>
                                            <h6><a
                                                    href="tel:<?php echo e(__($contact->data_values->contact_number_two)); ?>"><?php echo e(__($contact->data_values->contact_number_two)); ?></a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 wow animate__animated animate__fadeInUp">
                        <div class="contact-info">
                            <div class="contact-info__addres-wrap">
                                <div class="single_wrapper">
                                    <h4><?php echo app('translator')->get('Office'); ?></h4>
                                    <div class="single-info">
                                        <div class="cont-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="cont-text">
                                            <h6><a
                                                    href="javascript:void(0)"><?php echo e(__($contact->data_values->contact_details)); ?></a>
                                            </h6>
                                            <h6><a
                                                    href="javascript:void(0)"><?php echo e(__($contact->data_values->contact_details_two)); ?></a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="contact-info  border-none">
                            <div class="contact-info__addres-wrap">
                                <div class="single_wrapper">
                                    <h4><?php echo app('translator')->get('Email'); ?></h4>
                                    <div class="single-info">
                                        <div class="cont-icon">
                                            <i class="far fa-envelope"></i>
                                        </div>
                                        <div class="cont-text">
                                            <h6><a
                                                    href="mailto:<?php echo e(__($contact->data_values->email_address)); ?>"><?php echo e(__($contact->data_values->email_address)); ?></a>
                                            </h6>
                                            <h6><a
                                                    href="mailto:<?php echo e(__($contact->data_values->email_address_two)); ?>"><?php echo e(__($contact->data_values->email_address_two)); ?></a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="contactus-form wow animate__animated animate__fadeInUp">
                        <form method="post" action="" class="verify-gcaptcha">
                            <?php echo csrf_field(); ?>
                            <div class="row gy-md-4 gy-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input name="name" type="text" class="form--control" placeholder=""
                                            value="<?php echo e(old('name')); ?>" required>
                                        <label class="form--label"><?php echo app('translator')->get('Name'); ?></label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input name="email" type="email" class="form--control" placeholder=""
                                            value="<?php if(auth()->user()): ?> <?php echo e(auth()->user()->email); ?><?php else: ?><?php echo e(old('email')); ?> <?php endif; ?>"
                                            <?php if(auth()->user()): ?> readonly <?php endif; ?> required>
                                        <label class="form--label"><?php echo app('translator')->get('Email'); ?></label>

                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input name="subject" type="text" class="form--control" placeholder=""
                                            value="<?php echo e(old('subject')); ?>" required>
                                        <label class="form--label"><?php echo app('translator')->get('Subject'); ?></label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <textarea class="form--control" placeholder="" name="message"><?php echo e(old('message')); ?></textarea>
                                        <label class="form--label"><?php echo app('translator')->get('Message'); ?></label>
                                    </div>

                                </div>
                                <?php if (isset($component)) { $__componentOriginalff0a9fdc5428085522b49c68070c11d6 = $component; } ?>
<?php $component = App\View\Components\Captcha::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('captcha'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Captcha::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff0a9fdc5428085522b49c68070c11d6)): ?>
<?php $component = $__componentOriginalff0a9fdc5428085522b49c68070c11d6; ?>
<?php unset($__componentOriginalff0a9fdc5428085522b49c68070c11d6); ?>
<?php endif; ?>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn--base">
                                        <?php echo app('translator')->get('Send Your Message'); ?><i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Contact Form End Here ==================== -->

    <!-- ==================== Map Start Here ==================== -->
    <div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="contact-map wow animate__animated animate__fadeInUp">
                        <iframe
                            src="https://maps.google.com/maps?q=<?php echo e($contact->data_values->latitude); ?>,<?php echo e($contact->data_values->longitude); ?>&hl=es;z=14&amp;output=embed"
                            width="600" height="450" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==================== Map Start Here ==================== -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\adzspec\veckansr\application\resources\views/presets/default/contact.blade.php ENDPATH**/ ?>