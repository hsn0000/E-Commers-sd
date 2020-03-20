<!DOCTYPE html>
<html lang="{{Session::get('applocale')}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('frontend.forgot_password_email')}}</title>
</head>
<body>
    <table>
       <tr><td>{{__('frontend.dear')}} {{$name}} !</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td> Your Account has been successfully updated,</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td> Your account information is as below with new password.</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td> Email : {{ $email }}</a></td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td> New Password : {{ $password }}</a></td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td>{{__('frontend.thanks_regards')}},</td></tr>
       <tr><td>E-com Husin</td></tr>
       <tr><td>&nbsp;</td></tr>
    </table>    
</body>
</html>