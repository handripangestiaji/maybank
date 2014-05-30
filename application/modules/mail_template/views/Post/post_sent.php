<html>
    <head>
        <style>
           body{padding: 0;margin: 0}
            .content{padding: 10px;}
            .navbar-inner {
                padding: 10px 5px;
               background: #fdd341;
                background: -moz-linear-gradient(top,  rgba(255,195,31,1) 0%, rgba(253,211,65,1) 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,195,31,1)), color-stop(100%,rgba(253,211,65,1))); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top,  rgba(255,195,31,1) 0%,rgba(253,211,65,1) 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top,  rgba(255,195,31,1) 0%,rgba(253,211,65,1) 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top,  rgba(255,195,31,1) 0%,rgba(253,211,65,1) 100%); /* IE10+ */
                background: linear-gradient(to bottom,  rgba(255,195,31,1) 0%,rgba(253,211,65,1) 100%); /* W3C */
            }
            body, p { font-family:"Trebuchet MS", Arial, Helvetica, sans-serif; font-size:12px; color:#000; line-height:1.3em;}
            .bold {font-weight:bold; font-size:1.2em;}
        .signature{font-size:15px; }
        .footer{color: #888;font-size:10px}
        </style>
    </head>
    <body>
        <div class="navbar-inner">
            <img src="<?=base_url()?>media/img/logo-may-2.png">
        </div>
        <div class="content">
        <p>Your message has been posted. Detail of post below:</p>
        <?php $post['posted_at'] = new DateTime($post['posted_at']." UTC");
            $timezone = new DateTimeZone($post['user_timezone']);
            $post['posted_at']->setTimezone($timezone);
        
        ?>
        <table>
            <tr><td>Creator Email</td><td>:</td><td><?=$post['email']?></td></tr>
            <tr><td>Message</td><td>:</td><td><?=$post['messages']?></td></tr>
            <tr><td>Posted at</td><td>:</td><td><?=$post['posted_at']->format('l, M j, Y h:i A')?></td></tr>
            <tr><td>Social Media</td><td>:</td><td><?=$post['socmeds']?></td></tr>
            <tr><td>Result</td><td>:</td><td><?=$post['result']?></td></tr>    
            <tr><td>Error Message</td><td>:</td><td><?=$post['error_message']?></td></tr>    
        </table>
        <p class="footer"><span style="font-weight:bold; text-transform:uppercase; font-size:1.1em;"> MALAYAN BANKING BERHAD</span><br>
            (This is a computer generated email, no signature is required)<p>
        <p style="font-size:10px; color:#333;"> This message is intended only for the use of the person to whom it is expressly addressed and may contain information that is confidential and legally privileged. If you are not the intended recipient, you are hereby notified that any use, reliance on, reference to, review, disclosure or copying of the message and the information it contains for any purpose is prohibited. If you have received this message in error, please notify the sender by reply e-mail of the mis-delivery and delete all its contents. Opinions, conclusions and other information in this message that do not relate to the official business of Malayan Banking Berhad shall be understood as neither given nor endorsed by it. </p>
        
        </div>
        
    </body>    
</html>