<?php debug($this->validationErrors); ?>
<h2>Disallowed files</h2>
<table>
    <?php
    if(is_array($dis_table)){
        echo $html->tableCells($dis_table, array('class' => 'dis'), array('class' => 'dis'), true);
    } else {
        echo $html->para('','No disallowed files detected.');
    }
    ?>
</table>

    <h2>Duplicate files</h2>
<table>
    <?php
    if(is_array($dup_table)){
        echo $html->tableCells($dup_table, array('class' => 'dup'), array('class' => 'dup'), true);
    } else {
        echo $html->para('','No duplicate files detected.');
    }
    ?>
</table>

    <h2>New files</h2>
<?php 
    echo $form->create('Dispatch',array('type'=>'file', 'action' => 'new_image_record'));
    echo $form->button('Submit \'m all');
?>
<table>
    <?php
    if(is_array($new_table)){
        echo $html->tableCells($new_table);
//        }
    } else {
        echo $html->para('','No new files detected.');
    }
    ?>
</table>
<?php echo $form->end('Submit \'m all'); ?>

        <?php
        $js->buffer($exifAssignments);
        $js->buffer(file_get_contents('js/upload.js'));
//            debug($file);
//            debug($dup);
//            debug($new);
//            debug($sourceFolder);
            //echo "<table>";
//            echo $html->nestedList(array($file->info(),'last change: '.date('r',$file->lastChange()),'size: '.$file->size()));
            //echo "</table>";
//            debug($sourceFolder);
//debug($saved);
//debug($failed_save);
//debug($missing_pic);
//debug($source);
?>
