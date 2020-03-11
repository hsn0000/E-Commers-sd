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
            <td>Hello {{$name}},</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Thank you for shopping with us. You order details are as below :- </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Order No: {{$order_id}}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="95%" cellpadding="5" cellspacing="5" style="background-color:#f7f4f4">
                    <tr style="background-color: #cccccc">
                        <td>Product Name</td>
                        <td>Product Code</td>
                        <td>Size</td>
                        <td>Color</td>
                        <td>Quantity</td>
                        <td>Unit Price</td>
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
                        <td collspan="5" style="float:right;"> Shipping Charges :</td>
                        <td> {{'Rp'.' '.is_number($productDetails['shipping_charges'],2)}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td collspan="5" style="float:right;"> Coupon Discount :</td>
                        <td>{{'Rp'.' '.is_number($productDetails['coupon_amount'],2)}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td collspan="5" style="float:right;"> Grand Total :</td>
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
                                    <td><strong> Bill To :- </strong></td>
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
                                    <td> <strong> Ship To :- </strong></td>
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
            <td>for any enquiries, you can contact us at <a href="mailto:info@ecom-website.com">info@ecom-husin.com</a>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Regards, <br> Team E-com Husin</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>

</html>