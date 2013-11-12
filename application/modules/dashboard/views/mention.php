


<?php
foreach ($mention_twitter as $item):
    echo print_r($item);
    foreach ($mention_twitter[0] as $items):
              echo print_r($items);
              echo '<br><br><br><br>';
    endforeach;
endforeach;
?>