<?php
/* @var $this ViewCC */ 
?> 
<?php
debug($searchRecords);
//debug($orphans);
$foundRecords = $orphans;
$heading2 = 'Orphan';
if(isset($searchRecords[0]) && !is_null($searchRecords)){
    $foundRecords = $searchRecords;
    $heading2 = $session->read('Image.searchInput');
}
if(isset ($foundRecords)){
    echo $this->Form->create('Image');
?>
<h2><?php echo $heading2; ?> Images</h2>
<table>
<?php
    $fields = array('id','img_file','title','alt','category','width','height',);
    $contentFields = array('id','heading','content','alt','title','publish','image_id');
    
    foreach($foundRecords as $foundRecord){
?>
    <tr><td>
<?php
//        debug($foundRecord);
        echo $this->Html->image("images/thumb/x160y120/{$foundRecord['Image']['img_file']}");
?> 
    </td><td>
        <table>
<?php
        
        // assemble field display lines
        $display = NULL;
        foreach($fields as $field){
//            debug($field);
            $display .= (!is_null($foundRecord['Image'][$field]))?"<p><em>$field:</em> {$foundRecord['Image'][$field]}</p>":'';
        }
        
        // image record deletion choice -- checkbox
        $check = $this->Form->input('delete', array(
            'type'=>'checkbox',
            'name'=>"data[{$foundRecord['Image']['id']}][action]",
            'options'=>'delete'
        ));
            
        // hidden file name for image file deletion
        $name = $this->Form->input('name', array(
            'type'=>'hidden',
            'value'=>$foundRecord['Image']['img_file'],
            'name'=>"data[{$foundRecord['Image']['id']}][name]",
        ));
            
        // also-delete-files checkbox
        if(!is_null($foundRecord['Image']['img_file'])){
            $file_check = $this->Form->input('also_delete_file', array(
            'type'=>'checkbox',
            'checked'=>'checked',
            'name'=>"data[{$foundRecord['Image']['id']}][delete_file]"        )); 
        }
        
        // nest in the Content records linked to this image record
        if(isset($foundRecord['Content']) && !is_null($foundRecord['Content'])){
            
            $contentCheckCell = null;
            
            foreach($foundRecord['Content'] as $contentNumber => $contentData){
                
            $contentDisplay = null;
            $contentCheck = null;

                // default deletion checkbox for content
                $contentCheck = $this->Form->input('also_delete_this_content', array(
                    'type'=>'checkbox',
                    'name'=>"data[{$foundRecord['Image']['id']}][Content][{$contentData['id']['also']}]",
                    'checked'=>'checked'
                ));

                // checkbox to request targeted deletion of this content record
                $contentCheck .= $this->Form->input('delete_this_content', array(
                    'type'=>'checkbox',
                    'name'=>"data[{$foundRecord['Image']['id']}][Content][{$contentData['id']['delete']}]"
                ));

                // assemble display of field data for this content record
                foreach($contentFields as $contentField){
                    $contentDisplay .= (!is_null($contentData[$contentField]))?"<p><em>$contentField:</em> {$contentData[$contentField]}</p>":'';
                }
                
                // in here there will have to be a deeper nest to put in the ContentController records

                // Content record data field output
                $contentCheckCell .= "<tr><td colspan='2'>$contentCheck</td></tr><tr><td>$contentDisplay</td><td></td></tr>";
            }
        }
?> 
            <tr><td colspan="2"><?php echo $check . $file_check . $name; ?></td></tr>
            <tr><td><?php echo $display; ?></td><td><table>
                    <?php
                    if(isset($contentCheckCell)){
                        echo $contentCheckCell;
                    }
                    ?>
                    </table></td></tr>
        </table>
    </td></tr>
<?php
//        echo $this->Html->div('cleanup', $check.'<hr />'.$display);
    }
?> 
</table>
<?php
    echo $this->Form->end('Submit');
} // end of if isset foundRecords
?>
