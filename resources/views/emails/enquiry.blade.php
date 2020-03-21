<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('frontend.enquiry_email')}}</title>
</head>
<body>
    <table>
       <tr><td><b>{{__('frontend.dear')}}</b> Admin !</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td><b>User enquiry details is as below</b> : </td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td><b>Name</b> : {{$name}}</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td><b>{{__('frontend.email')}}</b> : {{$email}}</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td><b>Subject</b> : {{$subject}}</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td><b>Message</b> : {{$comment}}</td></tr>
    </table>    
</body>
</html>

