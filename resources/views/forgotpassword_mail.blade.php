<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<p style="font-size: 16px; color: #000; margin: 35px 0px 0px 0px;line-height: 24px">Hello {{$name}},</p>
<p style="font-size: 16px; color: #000; margin: 0px 0px 0px 0px;line-height: 24px">You are receiving this email because we received a password reset request for your account.</p>
<center><a title="Reset password" style="background: #0000fe; padding:10px 20px; color: #fff;margin-top:20px;display: inline-block;  border-radius: 4px;  text-decoration: none;
   " href="{{$link}}">Reset Password</a></center>
<p style="font-size: 16px; color: #000; margin: 20px 0px 0px 0px;line-height: 24px">If you did not request a password reset, no further action is required.</p>
</body>
</html>