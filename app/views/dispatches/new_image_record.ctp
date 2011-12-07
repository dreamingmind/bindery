<?php
//debug($this->viewVars);
//debug($this->params);
$count = $this->params['pass'][1];
$base = str_replace(array('.', '#', '*'), '_', $this->params['pass'][0]);
$found = false;
$img_file = $path.$this->params['pass'][0];
if(isset($this->data[0]['Dispatch'])){
    $found = true;
}
    $id = ($found) ? $this->data[0]['Dispatch']['id'] : '';
    $text = ($found) ? $this->data[0]['Dispatch']['text'] : '';
    $heading = ($found) ? $this->data[0]['Dispatch']['heading'] : '';
    $alt = ($found) ? $this->data[0]['Dispatch']['alt'] : '';
    $publish = ($found) ? $this->data[0]['Dispatch']['publish'] : '';
?>
<fieldset id ="<?php echo $base; ?>">
<div class="input text">
    <label for="id">Id</label>
    <textarea id="id" name="data[<?php echo $count; ?>][Dispatch][id]"><?php echo $id ?></textarea>
</div>
<div class="input textarea">
    <label for="heading">Heading</label>
    <textarea id="heading" rows="6" cols="30" name="data[<?php echo $count; ?>][Dispatch][heading]"><?php echo $heading ?></textarea>
</div>
<div class="input textarea">
    <label for="text">Text</label>
    <textarea id="news_text" rows="6" cols="30" name="data[<?php echo $count; ?>][Dispatch][text]"><?php echo $text ?></textarea>
</div>
<div class="input text">
    <label for="alt">Alt</label>
    <input id="alt" type="text" name="data[<?php echo $count; ?>][Dispatch][alt]" value="<?php echo $alt ?>" />
</div>
<div class="input textarea">
    <label for="publish">Publish</label>
    <select id="publish" name="data[<?php echo $count; ?>][Dispatch][publish]" value="<?php echo $publish ?>" selected=1>
        <option value="0">0</option>
        <option value="1">1</option>
    </select>
</div>
<div class="input hidden">
    <input type="text" class="name" name="data[<?php echo $count; ?>][Image][img_file][name]" value="<?php echo $this->params['pass'][0] ?>" />
    <input type="text" class="type" name="data[<?php echo $count; ?>][Image][img_file][type]" value="" />
    <input type="text" class="tmp_name" name="data[<?php echo $count; ?>][Image][img_file][tmp_name]" value="<?php echo $img_file ?>" />
    <input type="text" class="error" name="data[<?php echo $count; ?>][Image][img_file][error]" value="0" />
    <input type="text" class="size" name="data[<?php echo $count; ?>][Image][img_file][size]" value="" />
    <input type="text" class="id" name="data[<?php echo $count; ?>][Image][id]" value="<?php echo $id ?>" />
    <input type="text" class="batch" name="data[<?php echo $count; ?>][Image][batch]" value=1 />
    <input type="text" class="image_created" name="data[<?php echo $count; ?>][Image][image_created]" value="" />
    <input type="text" class="height" name="data[<?php echo $count; ?>][Image][height]" value="" />
    <input type="text" class="width" name="data[<?php echo $count; ?>][Image][width]" value="" />
    <input type="text" class="html_size" name="data[<?php echo $count; ?>][Image][html_size]" value="" />
</div>
</fieldset>
<?php
//                $('.pic_timestamp',$('#'+base)).val(exifData[base].EXIF.DateTimeOriginal);
//                $('.height',$('#'+base)).val(exifData[base].COMPUTED.Height);
//                $('.width',$('#'+base)).val(exifData[base].COMPUTED.Width);
//                $('.html_size',$('#'+base)).val(exifData[base].COMPUTED.html);

//    [Dispatch] => Array
//        (
//            [img_file] => Array
//                (
//                    [name] => DSC00001.JPG
//                    [type] => image/jpeg
//                    [tmp_name] => /private/var/tmp/phpmzrMnm
//                    [error] => 0
//                    [size] => 702928
//                )

//debug($this->params); die;
//if(isset($this->data[0]['Dispatch'])){
//echo $form->input("news_text",array('type'=>'textarea', 'value'=>$this->data[0]['Dispatch']['news_text']));
//echo $form->input('alt',array('value'=>$this->data[0]['Dispatch']['alt']));
//echo $form->input('publish',array('options'=>array(0,1), 'value'=>$this->data[0]['Dispatch']['publish']));
//} else {
//echo $form->input("news_text[{$this->params['pass'][0]}]",array('type'=>'textarea'));
//echo $form->input("alt[{$this->params['pass'][0]}]");
//echo $form->input("publish[{$this->params['pass'][0]}]",array('options'=>array(0,1)));
//}
?>
