@extends('welcome')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                <li class="active">Thanh toán</li>
              </ol>
        </div><!--/breadcrums-->

        <div class="register-req">
            <p>Làm ơn đăng nhập hoặc đăng ký để thanh toán đơn hàng !</p>
        </div><!--/register-req-->

        <div class="shopper-informations">
            <div class="row">
                <div class="col-sm-14 clearfix">
                    <div class="bill-to">
                        <p>Điền thông tin</p>
                        <div class="form-one">
                            <form action="{{URL::to('save-checkout-customer')}}" method="POST">
                                {{csrf_field()}}
                                <input type="text" name="shipping_email" placeholder="Email">
                                <input type="text" name="shipping_name" placeholder="Họ và tên">
                                <input type="text" name="shipping_address" placeholder="Địa chỉ">
                                <input type="text" name="shipping_phone" placeholder="Số điện thoại">
                                <textarea name="shipping_note" placeholder="Ghi chú đơn hàng" rows="16"></textarea>
                                <input type="submit" value="Thanh toán" name="send_order" class="btn btn-primary btn-sm">
                            </form>
                        </div>
                        
                    </div>
                </div>
                
            </div>					
            </div>
        </div>
        <div class="review-payment">
            <h2>Xem lại giỏ hàng</h2>
        </div>
        <div class="table-responsive cart_info">
            <?php
                $content= Cart::content();
            ?>
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Sản phẩm</td>
                        <td class="description"></td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($content as $val)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{URL::to('public/product/'.$val->options->image)}}" width="80" alt="" />
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$val->name}}</a></h4>
                            <p>ID: {{$val->id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($val->price).' VND'}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                                    {{ csrf_field() }}
                                {{-- <a class="cart_quantity_up" href=""> + </a> --}}
                                <input class="cart_quantity_input" type="number" name="cart_quantity" value="{{$val->qty}}">
                                <input type="hidden" value="{{$val->rowId}}" name="rowId_cart" class="form-control">
                                <input type="submit" value="Cập nhật" name="update_qty" class="btn btn-default btn-sm">
                                {{-- <a class="cart_quantity_down" href=""> - </a> --}}
                                </form>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                            <?php
                                $total= $val->price*$val->qty;
                                echo number_format($total).' VND';
                            ?></p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('delete-to-cart/'.$val->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
        {{-- <div class="payment-options">
                <span>
                    <label><input type="checkbox"> Direct Bank Transfer</label>
                </span>
                <span>
                    <label><input type="checkbox"> Check Payment</label>
                </span>
                <span>
                    <label><input type="checkbox"> Paypal</label>
                </span>
            </div> --}}
    </div>
</section> <!--/#cart_items-->
@endsection