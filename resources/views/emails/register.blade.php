<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Email</title>
</head>
<body>
    <table>
       <tr><td>Dear {{$name}} !</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td>Your account has been successfully created.<br> your account information is as below: </td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td>Email: {{$email}}</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td>Password: ***** (as chosen by you)</td></tr>
       <tr><td>&nbsp;</td></tr>
       <tr><td>Thanks & Regards,</td></tr>
       <tr><td>E-com Husin</td></tr>
       <tr><td>&nbsp;</td></tr>
    </table>    
</body>
</html>