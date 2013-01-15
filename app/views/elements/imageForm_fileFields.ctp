<?php
/* @var $this ViewCC */
/** This element has not be re-written into the 
 * NEW modular fieldset helper system
 * $data array
 * [x]Image.img_file.name
 * [x]Image.img_file.type
 * [x]Image.img_file.tmp_file
 * [x]Image.img_file.size
 * [x]Image.img_file.error
 * [x]Image.batch
 */

// copy this code to set-up the proper $file array
//$count = $replace; //optional
//$file = array(     //required
//    'name'=> $replace,
//    'type'=> $replace,
//    'tmp_file'=> $replace,
//    'size'=> $replace
//    );
/**
 * This will output a fieldset with file-upload inputs for all the Image record
 * 
 * Providing $count will index the fields so multiple records can be processed
 * Set $file array with the indexes:
 *      name, type, tmp_file and size
 * 
 * I don't know of a reason this would be used except to aid in processing the
 * Upload folder images, so providing $file is assumed, ['error']=0 and ['batch']=1 is set
 * to allow the Upload Behavior to process manually set records
 */
if (isset($count)){
    $index = "[$count]";
}
?> 
	<fieldset id="<?php echo "{$count}file"; ?>">
	<?php
		echo $this->Form->hidden('Name',array(
                    'name'=>"data{$index}[Image][img_file][name]",
                    'id' => "{$count}ImageImgFileName",
                    'class' => "ImageImgFileName",
                    'value'=>$file['name']));
                    
		echo $this->Form->hidden('Type',array(
                    'name'=>"data{$index}[Image][img_file][type]",
                    'id' => "{$count}ImageImgFileType",
                    'class' => "ImageImgFileType",
                    'value'=>$file['type']));
                    
		echo $this->Form->hidden('TmpFile',array(
                    'name'=>"data{$index}[Image][img_file][tmp_file]",
                    'id' => "{$count}ImageImgFileTmpFile",
                    'class' => "ImageImgFileTmpFile",
                    'value'=>$file['tmp_file']));
                    
		echo $this->Form->hidden('Size',array(
                    'name'=>"data{$index}[Image][img_file][size]",
                    'id' => "{$count}ImageImgFileSize",
                    'class' => "ImageImgFileSize",
                    'value'=>$file['size']));
                    
		echo $this->Form->hidden('Error',array(
                    'name'=>"data{$index}[Image][img_file][error]",
                    'id' => "{$count}ImageImgFileError",
                    'class' => "ImageImgFileError",
                    'value'=>0));

                echo $this->Form->hidden('batch',array(
                    'name'=>"data{$index}[Image][batch]",
                    'id' => "{$count}ImageImgBatch",
                    'class' => "ImageImgBatch",
                    'value'=>1));                        
	?>
	</fieldset>
