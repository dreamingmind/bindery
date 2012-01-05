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
<?php
?>
<table>
<?php
//debug(count($chunk));
if($chunk) {
    $i = $record = 0;
    do {
        echo "<tr>";
        foreach($chunk[$i] as $val) {
//            debug($val);debug($i);die;
            echo "<td><div class='imageGridCell'>";
            echo $this->Html->image("images/thumb/$size/".$val['Image']['img_file']);
            echo $val['Image']['id'];
            echo $this->Html->div('showButtons',
                    $this->Html->para('showDetails','d',array('name'=>$val['Image']['id']))
                    . $this->Html->para('showForm','f',array('name'=>$val['Image']['id']))
                 );
            // div with detail output and hide button
            echo $this->Html->div("recordData",
                $this->Html->div('hideButtons',
                    $this->Html->para('hideDetails','x',array('name'=>$val['Image']['id']))
                )
                . $this->Html->tag('pre',  print_r($val,TRUE)),array('id'=>'recordData'.$val['Image']['id'])
            );
            
            echo $this->Html->div("recordForm",
                $this->Html->div('hideButtons',
                    $this->Html->para('hideForm','x',array('name'=>$val['Image']['id']))
                )
                . $this->Form->create('Image',array('conroller'=>'images',
                    'action'=>'image_grid'))
//                  . $this->Form->inputs($val['Image'])
//                  . $this->Form->inputs($val['Content'][0])
                . $this->Html->div('', $this->element('imageForm_metaFields', array(
                    'record'=>$val,
//                    'count'=>$record
                    )))
                . $this->Html->div('', $this->element('imageForm_dataFields', array(
                    'record'=>$val,
//                    'count'=>$record,
                    'doFile' => false)))
                . $this->Html->div('', $this->element('imageForm_exifFields', array(
                    'record'=>$val,
//                    'count'=>$record
                    )))
                . $this->Html->div('', $this->element('contentForm_metaFields', array(
                    'record'=>$val,
                  'linkNumber' => 0
                    )))
                . $this->Html->div('', $this->element('contentForm_dataFields', array(
                    'record'=>$val,
                  'linkNumber' => 0
                    )))
                . $this->Form->end('Submit',true)
                ,array('id'=>'recordForm'.$val['Image']['id'])
            );
            echo '</div></td>';
        }
        echo "</tr>";
        $i++;
    } while ($i < count($chunk));
}
?>
</table>
<?php 
$js->buffer(file_get_contents('js/imagegrid.js')); ?>
