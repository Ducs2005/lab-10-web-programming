<?php $__env->startSection('admin_content'); ?>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="section__content section__content--p30">
        <div class="container">
            <div class="viewport-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb has-arrow">
                    <li class="breadcrumb-item">
                        <a href="">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="">Thống kê</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Theo ngày</li>
                    </ol>
                </nav>
            </div>
            <div class="row" style="margin-bottom: 40px;">
                <div class="col-md-12" style="display: flex">
                    <h2 class="title-1">Thống kê theo ngày </h2>
                </div>
            </div>
            <div class="row" style="margin-bottom: 30px">
                <div class="col-md-6">
                   <form class="form-inline" method="get" action="<?php echo e(URL::to('/found-order-day')); ?>">
                    <div class="form-group" style="margin-left: 10px;margin-right: 10px;">
                        <select name="day" id="" class="form-control">
                          <option value="">Chọn ngày</option>
                          <?php for($i = 1; $i <= 31; $i++): ?>
                          <option value="<?php echo e($i); ?>"><?php echo e(str_pad($i, 2, '0', STR_PAD_LEFT)); ?></option>
                          <?php endfor; ?>
                        </select>
                     </div>
                     <div class="form-group" style="margin-left: 10px;margin-right: 10px;">
                        <select name="month" id="" class="form-control">
                            <option value="">Chọn tháng</option>
                            <?php for($i = 1; $i <= 12; $i++): ?>
                            <option value="<?php echo e($i); ?>"><?php echo e(str_pad($i, 2, '0', STR_PAD_LEFT)); ?></option>
                            <?php endfor; ?>
                        </select>
                     </div>
                    <div class="form-group" style="margin-left: 10px;margin-right: 10px;">
                        <select name="year" id="" class="form-control">
                            <option value="">Chọn năm</option>
                            <?php for($i = 2018; $i <= 2030; $i++): ?>
                            <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                  <button type="submit" class="btn btn-info">Tìm kiếm</button>
                                </form>
                </form>
                </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                   <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Mã ID</th>
            <th>Tổng giá tiền</th>
            <th>Tình trạng</th>
                <th>Ngày tạo đơn</th>
            <th>Hiển thị</th>
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            <?php if(isset($all_order)): ?>
          <?php $__currentLoopData = $all_order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td><?php echo e($order->order_id); ?></td>
            <td><?php echo e($order->order_total); ?></td>
              <td><?php echo e($order->created_at); ?></td>
            <td>
              <?php
               if($order->order_status==1) {
                    echo 'Chưa xử lý';
                  }
                else if ($order->order_status==2){
                    echo 'Đã xử lý';
                  }
                else {
                    echo 'Hủy đơn hàng-tạm giữ';
                }
             
               ?>
                 
               </td>
           
            <td>
              <a href="<?php echo e(URL::to('/view-order/'.$order->order_id)); ?>" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Bạn có chắc là muốn xóa đơn hàng không?')" href="<?php echo e(URL::to('/delete-order/'.$order->order_id)); ?>" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           <?php endif; ?>
        </tbody>
      </table>
                 <div>
                 </div>
               </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\web-lab10\resources\views/admin/day_order.blade.php ENDPATH**/ ?>