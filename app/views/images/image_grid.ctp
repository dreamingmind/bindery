<?php /* @var $this ViewCC */ ?> 
<?php
//debug($duplicate);
//debug($disallowed);
//debug($new);

// An element makes the Upload links and they output on the Layout
?>
<?php
echo $session->flash();
echo $this->Form->create('Image',array('conroller'=>'images',
    'action'=>'search'));
?>
<table style="width:50%;margin-top:50px;">
    <tr>
        <td><?php echo $this->Form->input('columns', array('value'=>$column)); ?></td>
        <td><?php echo $this->Form->input('sizes', array('value'=>$size)); ?></td>
        <td><?php echo $this->Form->end(__('Submit', true)); ?></td>
    </tr>
</table>
<table>
<?php
//debug(count($chunk));
if($chunk) {
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
}
?>
</table>
