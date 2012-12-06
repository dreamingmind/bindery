<?php /* @var $this ViewCC */ ?> 
<?php
//debug($duplicate);
//debug($disallowed);
//debug($new);

// An element makes the Upload links and they output on the Layout
?>
<?php
echo $session->flash();
//debug($linkedContent);
//debug($recentCollections);
//debug($allCollections);
echo $this->Form->create('Image',array('conroller'=>'images',
    'action'=>'search'));
?>
<table style="width:50%;margin-top:50px;">
    <tr>
        <td><?php echo $this->Form->input('columns', array('value'=>$column)); ?></td>
        <td><?php echo $this->Form->input('sizes', array('value'=>$size)); ?></td>
        <td><?php echo $this->Form->input('uploadsets', array('value'=>$uploadsets)); ?></td>
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
            
            $val['options']['recent_titles']=$recentTitles;
            // Buld the various fieldsets
                $im_meta = $this->Html->div('', $this->element('imageForm_metaFields', array(
                    'record'=>$val,
                    )));
                $im_data = $this->Html->div('', $this->element('imageForm_dataFields', array(
                    'record'=>$val,
                    )));
                $im_exif = $this->Html->div('', $this->element('imageForm_exifFields', array(
                    'record'=>$val,
                    )));
                
                // accumulate the content records if there are any
                $con_set = '';
//                debug($val['Content']);
//                debug(count($val['Content']));
                if(isset($val['Content']) && count($val['Content'])>=1){
                    foreach($val['Content'] as $index=>$entry){
                        $con_set .= $this->Html->div('', $this->element('contentForm_metaFields', array(
                            'record'=>$val,
                            'linkNumber' => $index
                            )));
                        
                        // work out the memberships for this Content record
                        if(isset($entry['ContentCollection'])){
                            $memberships = null;
                            foreach($entry['ContentCollection'] as $collections){
                                $memberships .= (isset($collections['Collection']['heading']))
                                    ?$this->Html->tag('li',$collections['Collection']['heading'])
                                    :'';
                            }
                            $memberships = (!is_null($memberships))
                                ? $this->Html->tag('ul',$memberships)
                                : $memberships;
                        }
                        $con_set .= $this->Html->div('', $this->element('contentForm_dataFields', array(
                            'record'=>$val,
                            'legend'=>$entry['heading'],
                            'linkNumber' => $index,
                            'pre_fields' => (isset($memberships))?$memberships:''
                            )));
                    }
                }
                
                //build the tools-set for collection assignment
                $coll_assign = $this->Html->div('', $this->element('collectionMemberAssignment_pickFields', array(
                    'record'=>$val,
                    'linkedContent' => $linkedContent[$val['Image']['id']],
                    'recentCollections'=> $recentCollections,
                    'allCollections' => $allCollections
                    )));
            
            // Bundle the fieldsets in the form
            echo $this->Html->div("recordForm",
                $this->Html->div('hideButtons',
                    $this->Html->para('hideForm','x',array('name'=>$val['Image']['id']))
                )
                . $this->Form->create('Image',array('conroller'=>'images',
                    'action'=>'image_grid'))
                . $im_meta.$im_data.$im_exif.$con_set.$coll_assign
//                  . $this->Form->inputs($val['Image'])
//                  . $this->Form->inputs($val['Content'][0])
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
