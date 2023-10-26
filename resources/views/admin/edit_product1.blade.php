@extends('admin_layout')
@section('admin_content')
    
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật sản phẩm
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
                        @foreach ($edit_product as $key=>$pro)
                        <form role="form" action="{{URL::to('/update-product/'.$pro->product_id)}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="product_name" value="{{$pro->product_name}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá sản phẩm</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="product_price" value="{{$pro->product_price}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                            <input type="file" class="form-control" id="exampleInputEmail1" name="product_image">
                            <img src="{{URL::to('public/product/'.$pro->product_image)}}" height="100" width="100">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                            <textarea style="resize:none" rows="5" class="form-control" id="exampleInputPassword1" name="product_desc">{{$pro->product_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                            <textarea style="resize:none" rows="5" class="form-control" id="exampleInputPassword1" name="product_content">{{$pro->product_content}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục sản phẩm</label>
                            <select name="product_cate" class="form-control input-sm m-bot15">
                                @foreach ($cate_product as $key=>$cate)
                                    @if ($cate->category_id==$pro->category_id)
                                    <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @else
                                    <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Thương hiệu</label>
                            <select name="product_brand" class="form-control input-sm m-bot15">
                                @foreach ($brand_product as $key=>$brand)
                                    @if ($cate->category_id==$pro->category_id)
                                    <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @else
                                    <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Hiển thị</label>
                            <select name="product_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiện</option>
                            </select>
                        </div>
                        <button type="submit" name="add_product" class="btn btn-info">Cập nhật sản phẩm</button>
                    </form>
                    @endforeach
                    </div>

                </div>
            </section>

    </div>
    
</div>
@endsection