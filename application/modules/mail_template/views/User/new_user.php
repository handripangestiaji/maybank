<html>
<head>
<style type="text/css">
body, p { font-family:"Trebuchet MS", Arial, Helvetica, sans-serif; font-size:12px; color:#000; line-height:1.3em;}
.bold {font-weight:bold; font-size:1.2em;}
</style>
</head>

<body style="margin:0; padding:0; background:#FFF;">
<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="<?php echo base_url();?>media/img/header.png" width="600" height="49" border="0"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" height="250" cellspacing="0" cellpadding="10">
      <tr>
        <td valign="top"><p>Dear <span class="bold"><?php echo $user->row()->full_name;?></span>,<br>
      <p>Welcome to Maybank DCMS account.</p>
      <p>Your username is : <span class="bold"><?php echo $user->row()->user_id;?></span></p>
      <p>Your password is : <span class="bold"><?php echo $pass;?></span></p>
    <p>Please login to your account here: <a href="http://admin.maybk.co">http://admin.maybk.co</a></p>
    <br><br>
    <p><span style="font-weight:bold; text-transform:uppercase; font-size:1.1em;"> MALAYAN BANKING BERHAD</span><br>
(This is a computer generated email, no signature is required)<p>

    </td>
    </table>
      </td>
      </tr>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10" style="border-top:solid 1px #333; background:#eeeeee;">
      <tr>
        <td style="font-size:10px; color:#333;">This message is intended only for the use of the person to whom it is expressly addressed and may contain information that is confidential and legally privileged. If you are not the intended recipient, you are hereby notified that any use, reliance on, reference to, review, disclosure or copying of the message and the information it contains for any purpose is prohibited. If you have received this message in error, please notify the sender by reply e-mail of the mis-delivery and delete all its contents. Opinions, conclusions and other information in this message that do not relate to the official business of Malayan Banking Berhad shall be understood as neither given nor endorsed by it. </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
