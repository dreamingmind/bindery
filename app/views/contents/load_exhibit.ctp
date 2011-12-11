<table>
<?php
foreach($exhibit as $key=>$val) {
    echo '<tr><td>';
    print_r($exhibit[$key]);
    echo '</td><td>';
    print_r($content[$key]);
    echo '</td></tr>';
}
//debug($exhibit);
//debug($content);
?>
</table>
