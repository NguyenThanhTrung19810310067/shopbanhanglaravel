@extends('admin_layout')
@section('admin_content')
    
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm thương hiệu sản phẩm
                </header>
                <div class="panel-body">
                    <?php
                    $messenge= session()->get('messenge','');
                    if($messenge){
                        echo $messenge;
                        session()->forget('messenge');
                    }
                    ?>
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/save-brand-product')}}" method="POST">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thương hiệu</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="brand_product_name" placeholder="Tên thương hiệu">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                            <textarea style="resize:none" rows="5" class="form-control" id="exampleInputPassword1" name="brand_product_desc" placeholder="Mô tả thương hiệu"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Hiển thị</label>
                            <select name="brand_product_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiện</option>
                            </select>
                        </div>
                        <button type="submit" name="add_brand_product" class="btn btn-info">Thêm thương hiệu</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
    
</div>
@endsection