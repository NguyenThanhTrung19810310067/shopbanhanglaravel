@extends('welcome')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                <li class="active">Thanh toán giỏ hàng</li>
              </ol>
        </div><!--/breadcrums-->

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
        <h4 style="margin:40px 0; font-size:20px">Chọn hình thức thanh toán</h4>
        <form action="{{URL::to('order-place')}}" method="POST">
            {{csrf_field()}}
        <div class="payment-options">
            <span>
                <label><input name="payment_option" value="1" type="checkbox"> Thẻ ATM</label>
            </span>
            <span>
                <label><input name="payment_option" value="2" type="checkbox"> Tiền mặt</label>
            </span>
            <span>
                <label><input name="payment_option" value="3" type="checkbox"> VNPay</label>
            </span>
            <input type="submit" value="Đặt hàng" name="redirect" class="btn btn-infor btn-sm">
        </div>
        </form>
    </div>
</section> <!--/#cart_items-->
@endsection