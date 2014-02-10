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
        <p>New case has been assigned to you please response by entering Maybank DCMS. Detail of case below:</p>
        <?php if(is_array($case_object)) $case_object = $case_object[0]; ?>
        <table>
            <tr><td>CASE ID</td><td>:</td><td>#<?=$case_object->case_id?></td></tr>
            <tr><td>Product Name</td><td>:</td><td><?=$case_object->content_products_id->product_name?></td></tr>
            <tr><td>Assigned By</td><td>:</td><td><?=$case_object->created_by->email.' <'.$case_object->created_by->full_name.'>'?> </td></tr>
            <tr><td>Messages</td><td>:</td><td><?=$case_object->messages?></td></tr>
            <tr><td>Status</td><td>:</td><td><?=$case_object->status?></td></tr>
            <tr><td>Assigned At</td><td>:</td><td><?php $date = new DateTime($case_object->created_at, new DateTimeZone($case_object->created_by->timezone));
                echo $date->format("d F y H:i");
            ?></td></tr>
        </table>
        <p class="signature">Maybank DCMS</p>
        <p class="footer">Please do not reply to this message; it was sent from an unmonitored email address. This message is a service email related to your use of Maybank DCMS. </p>
        
        </div>
        
    </body>    
</html>

