<html>
    <head>
        <style>
            body{font-family: 'Trebuchet MS', Tahoma;padding: 0;margin: 0}
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
        <table>
            <tr><td>Message</td><td>:</td><td><?=$post['messages']?></td></tr>
            <tr><td>Posted at</td><td>:</td><td><?=$post['posted_at']?></td></tr>
            <tr><td>Social Media</td><td>:</td><td><?=$post['socmeds']?></td></tr>
            <tr><td>Result</td><td>:</td><td><?=$post['result']?></td></tr>    
            <tr><td>Error Message</td><td>:</td><td><?=$post['error_message']?></td></tr>    
        </table>
        <p class="signature">Maybank DCMS</p>
        <p class="footer">Please do not reply to this message; it was sent from an unmonitored email address. This message is a service email related to your use of Maybank DCMS. </p>
        
        </div>
        
    </body>    
</html>