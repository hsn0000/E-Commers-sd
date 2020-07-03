<!DOCTYPE html>
<html lang="{{Session::get('applocale')}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('frontend.confirmation_email')}}</title>
</head> 
<body>
    <table>
       <tr><td>{{__('frontend.dear')}} {{$name}} !</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td>{{__('frontend.please_click_on_below')}} :</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td><a href="{{url('confirm/'.$code)}}">{{__('frontend.confirm_account')}}</a></td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td>{{__('frontend.thanks_regards')}},</td></tr>
       <tr><td>E-com Husin</td></tr>
       <tr><td>&nbsp;</td></tr>
    </table>    
</body>
</html>