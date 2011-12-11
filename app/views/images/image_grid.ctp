<table>
<?php
//debug(count($chunk));
$i = 0;
do {
    echo "<tr>";
    foreach($chunk[$i] as $val) {
        echo "<td>";
        echo $this->Html->image("images/thumb/$size/".$val['Image']['img_file']);
        echo "{$val['Image']['id']}</td>";
    }
    echo "</tr>";
    $i++;
} while ($i < count($chunk));
?>
</table>
<?php
echo $this->Form->create('Image');
    echo $this->Form->input('columns', array('value'=>$column));
    echo $this->Form->input('sizes', array('value'=>$size));
echo $this->Form->end(__('Submit', true));
?>