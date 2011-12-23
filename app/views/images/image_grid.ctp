<?php /* @var $this ViewCC */ ?> 
<table>
<?php
//debug(count($chunk));
$i = 0;
do {
    echo "<tr>";
    foreach($chunk[$i] as $val) {
        $recordData = 
            $this->Html->div('recordData'.$val['Image']['id']. ' recordData',
                $this->Html->tag('pre',  print_r($val,TRUE)),
                array('style'=>'display:none;'));
        echo "<td>";
        echo $this->Html->image("images/thumb/$size/".$val['Image']['img_file']);
        echo $val['Image']['id'];
        echo "$recordData</td>";
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
    if(isset($searchInput)){
        echo $this->Form->input('searchInput', array('value'=>$searchInput, 'type'=>'hidden'));
    }
echo $this->Form->end(__('Submit', true));
?>