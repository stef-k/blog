<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Message</title>
</head>
<body>
<p>
    Hello admin,
    <br>
    you have a new mail with the following details:
</p>
<p><strong>From: </strong> {!! $email !!}</p>
<p><strong>Subject: </strong> {!! $subject  !!}</p>
<p><strong>Name: </strong> {!! $name !!} </p>
<p><strong>Message: </strong> {!! $the_message !!}</p>
<br>
<br>
This message has been sent from: {!! env('APP_URL') !!}
</body>
</html>
