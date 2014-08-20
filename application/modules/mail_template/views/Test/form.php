<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Email Tester</title>
        <style type="text/css">
            body{padding: 10px;}
            input, textarea{padding: 5px;font-family: "Trebuchet MS", Verdana; font-size:12px;}
            input{width:400px;}
            textarea{width:400px;height: 200px}
        </style>
    </head>
<body>
    <h1>TEST EMAIL!</h1>
    <form method="post" name="email_form" action="<?=base_url('mail_template/SendMail')?>">
        <select name="protocol">
            <option value="smtp">SMTP</option>
            <option value="sendmail">SENDMAIL</option>
        </select>
        <input style="width:250px" type="text" name="subject" placeholder="Subject" /> <br />
        <input type="text" name="email_to" placeholder="Email To" /> <br />
        <textarea placeholder="Content" name="content"></textarea><br />
        <input type="submit" value="Send Mail" />
    </form>
</body>
</html>