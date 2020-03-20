<!DOCTYPE html>
<html lang="en">

<body>
    <table width="700px">
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><img src="{{asset('images/frontend_images/home/logo.png')}}" alt=""></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>{{__('frontend.hello')}} {{$name}},</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>{{__('frontend.thank_you_for_shopping')}} :- </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>{{__('frontend.order_no')}} : {{$order_id}}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="95%" cellpadding="5" cellspacing="5" style="background-color:#f7f4f4">
                    <tr style="background-color: #cccccc">
                        <td>{{__('frontend.product_name')}}</td>
                        <td>{{__('frontend.product_code')}}</td>
                        <td>{{__('frontend.size')}}</td>
                        <td>{{__('frontend.color')}}</td>
                        <td>{{__('frontend.quantity')}}</td>
                        <td>{{__('frontend.unit_price')}}</td>
                    </tr>
                    @foreach($productDetails['orders'] as $product)
                    <tr>
                        <td>{{ $product['product_name'] }}</td>
                        <td>{{ $product['product_code']  }}</td>
                        <td>{{ $product['product_size']  }}</td>
                        <td>{{ $product['product_color']  }}</td>
                        <td>{{ $product['product_qty']  }}</td>
                        <td>{{'Rp'.' '.is_number($product['product_price'],2)}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td collspan="5" style="float:right;"> {{__('frontend.shipping_charges')}} :</td>
                        <td> {{'Rp'.' '.is_number($productDetails['shipping_charges'],2)}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td collspan="5" style="float:right;"> {{__('frontend.coupon_discount')}} :</td>
                        <td>{{'Rp'.' '.is_number($productDetails['coupon_amount'],2)}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td collspan="5" style="float:right;"> {{__('frontend.grand_total')}} :</td>
                        <td>{{'Rp'.' '.is_number($productDetails['grant_total'],2)}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td width="50%">
                            <table>
                                <tr>
                                    <td><strong> {{__('frontend.bill_to')}} :- </strong></td>
                                </tr>
                                <tr>
                                    <td> {{$userDetails['name']}}</td>
                                </tr>
                                <tr>
                                    <td> {{$userDetails['address']}}</td>
                                </tr>
                                <tr>
                                    <td> {{$userDetails['city']}}</td>
                                </tr>
                                <tr>
                                    <td> {{$userDetails['state']}}</td>
                                </tr>
                                <tr>
                                    <td> {{$userDetails['country']}}</td>
                                </tr>
                                <tr>
                                    <td> {{$userDetails['pincode']}}</td>
                                </tr>
                                <tr>
                                    <td> {{$userDetails['mobile']}}</td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%">
                            <table>
                                <tr>
                                    <td> <strong> {{__('frontend.ship_to')}} :- </strong></td>
                                </tr>
                                <tr>
                                    <td> {{$productDetails['name']}}</td>
                                </tr>
                                <tr>
                                    <td> {{$productDetails['address']}}</td>
                                </tr>
                                <tr>
                                    <td> {{$productDetails['city']}}</td>
                                </tr>
                                <tr>
                                    <td> {{$productDetails['state']}}</td>
                                </tr>
                                <tr>
                                    <td> {{$productDetails['country']}}</td>
                                </tr>
                                <tr>
                                    <td> {{$productDetails['pincode']}}</td>
                                </tr>
                                <tr>
                                    <td> {{$productDetails['mobile']}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>{{__('frontend.for_any_enquiries')}}<a href="mailto:info@ecom-website.com">info@ecom-husin.com</a>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>{{__('frontend.regards')}}, <br> Team E-com Husin</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>

</html>