<table>
    <thead>
        <tr>
            <td>Short URL</td>
            <td>Campaign Name</td>
            <td>Products</td>
            <td>Created By</td>
            <td>Total Click</td>
            <td>Date Created</td>
            <td>QR Code Path</td>
        </tr>
    </thead>
    <tbody>
        <?php
        if($shorturls){
        foreach($shorturls as $url){ ?>
        <tr>
            <td>http://admin.maybk.co/<?php echo $url->short_code ?></td>
            <td><?php echo $url->campaign_name ?></td>
            <td>
                <?php
                    if($products){
                        $i=0;
                        foreach($products as $product){
                            if($i != 0)
                                echo ',';
                            echo $product->product_name;        
                            $i++;
                        }
                    }
                ?>
            </td>
            <td><?php echo $url->full_name ?></td>
            <td><?php echo $url->inc ?></td>
            <td><?php echo date('d/m/Y H:i:s',strtotime($url->created_at)) ?></td>
            <td>http://admin.maybk.co/media/dynamic/qrcode/<?php echo $url->qrcode_image ?></td>
        </tr>
        <?php }
        }
        ?>
    </tbody>
</table>