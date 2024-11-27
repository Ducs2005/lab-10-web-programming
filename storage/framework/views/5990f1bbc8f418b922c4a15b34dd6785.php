                    <div class="left-sidebar">
                        <h2>Category</h2>
                        <div class="panel-group category-products" id="accordian">
                            <!--category-productsr-->
                         <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="<?php echo e(URL::to('/danh-muc-san-pham/'.$cate->slug_category_product)); ?>"><?php echo e($cate->category_name); ?></a></h4>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div><!--/category-products-->
                    
                     
                       <!--brands_products-->
                            <h2>Thương hiệu sản phẩm</h2>
                            <div class="brands_products">
                                <ul class="nav nav-pills nav-stacked">
                                    <?php $__currentLoopData = $brand; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(URL::to('/thuong-hieu-san-pham/'.$brand->brand_slug)); ?>"> <span class="pull-right">(50)</span><?php echo e($brand->brand_name); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                       <!--/brands_products-->
                   
                        
                        
                        
             
                    
                    </div><?php /**PATH C:\xampp\htdocs\web-lab10\resources\views/elements/sidebar.blade.php ENDPATH**/ ?>