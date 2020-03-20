<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('frontend.registration_email')}}</title>
</head>
<body>
    <table>
       <tr><td>{{__('frontend.dear')}} {{$name}} !</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td>{{__('frontend.your_account_created')}}.<br> {{__('frontend.your_account_information')}} : </td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td>{{__('frontend.email')}} : {{$email}}</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td>{{__('frontend.password')}} : ***** ({{__('frontend.as_chosen_you')}})</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td>{{__('frontend.thanks_regards')}},</td></tr>
       <tr><td>E-com Husin</td></tr>
       <tr><td>&nbsp;</td></tr>
    </table>    
</body>
</html>