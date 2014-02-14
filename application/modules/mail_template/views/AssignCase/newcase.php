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
        <?php if(is_array($case_object)):
        $case_object = $case_object[0]; ?>
        <div class="navbar-inner">
            <img src="<?=base_url()?>media/img/logo-may-2.png">
        </div>
        <div class="content">
        <p>Dear <?=$case_object->assign_to->full_name?>,</p>
        <p>New case has been assigned to you please response by entering Maybank DCMS. Detail of case below:</p>
        
        <table>
            <tr><td>CASE ID</td><td>:</td><td><a href="<?=base_url('dashboard/socialmedia').'#case/'.$case_object->type.'/'.$case_object->post_id?>">#<?=$case_object->case_id?></a></td></tr>
            <tr><td>Product Name</td><td>:</td><td><?=$case_object->content_products_id->product_name?></td></tr>
            <tr><td>Assigned By</td><td>:</td><td><?=$case_object->created_by->email.' <'.$case_object->created_by->full_name.'>'?> </td></tr>
            <tr><td>Messages</td><td>:</td><td><?=$case_object->messages?></td></tr>
            <tr><td>Status</td><td>:</td><td><?=$case_object->status?></td></tr>
            <tr><td>Assigned At</td><td>:</td><td><?php $date = new DateTime($case_object->created_at, new DateTimeZone($case_object->created_by->timezone));
                echo $date->format("d F y H:i");
            ?></td></tr>
        </table>
        <?php
        endif?>
        <p class="footer"><span style="font-weight:bold; text-transform:uppercase; font-size:1.1em;"> MALAYAN BANKING BERHAD</span><br>
            (This is a computer generated email, no signature is required)<p>
        <p style="font-size:10px; color:#333;"> This message is intended only for the use of the person to whom it is expressly addressed and may contain information that is confidential and legally privileged. If you are not the intended recipient, you are hereby notified that any use, reliance on, reference to, review, disclosure or copying of the message and the information it contains for any purpose is prohibited. If you have received this message in error, please notify the sender by reply e-mail of the mis-delivery and delete all its contents. Opinions, conclusions and other information in this message that do not relate to the official business of Malayan Banking Berhad shall be understood as neither given nor endorsed by it. </p>
        </div>
        
    </body>    
</html>

