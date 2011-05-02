<?php
$base = str_replace(array('.', '#', '*'), '_', $this->params['pass'][0]);
$found = false;
$img_file = $path.$this->params['pass'][0];
if(isset($this->data[0]['Dispatch'])){
    $found = true;
}
    $id = ($found) ? $this->data[0]['Dispatch']['id'] : '';
    $news_text = ($found) ? $this->data[0]['Dispatch']['news_text'] : '';
    $alt = ($found) ? $this->data[0]['Dispatch']['alt'] : '';
    $publish = ($found) ? $this->data[0]['Dispatch']['publish'] : '';
?>
<fieldset id ="<?php echo $base; ?>">
<div class="input textarea">
    <label for="news_text">News Text</label>
    <textarea id="news_text" rows="6" cols="30" name="data[news_text][]"><?php echo $news_text ?></textarea>
</div>
<div class="input text">
    <label for="alt">Alt</label>
    <input id="alt" type="text" name="data[alt][]" value="<?php echo $alt ?>">
</div>
<div class="input textarea">
    <label for="publish">Publish</label>
    <select id="publish" name="data[publish][]" value="<?php echo $publish ?>" selected=1>
        <option value="0">0</option>
        <option value="1">1</option>
    </select>
</div>
<div class="input hidden">
    <input type="text" class="name" name="data[img_file][name][]" value="<?php echo $this->params['pass'][0] ?>">
    <input type="text" class="type" name="data[img_file][type][]" value="">
    <input type="text" class="tmp_name" name="data[img_file][tmp_name][]" value="<?php echo $img_file ?>">
    <input type="text" class="error" name="data[img_file][error][]" value="0">
    <input type="text" class="size" name="data[img_file][size][]" value="">
    <input type="text" class="id" name="data[img_file][id][]" value="<?php echo $id ?>">
    <input type="text" class="batch" name="data[img_file][batch][]" value=1>
    <input type="text" class="image_created" name="data[img_file][image_created][]" value="">
    <input type="text" class="height" name="data[img_file][height][]" value="">
    <input type="text" class="width" name="data[img_file][width][]" value="">
    <input type="text" class="html_size" name="data[img_file][html_size][]" value="">
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
