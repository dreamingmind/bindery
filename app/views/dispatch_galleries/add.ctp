<div class="dispatches form">
<?php echo $this->Form->create('DispatchGallery', array('type'=>'file')); ?>
    <fieldset>
        <legend><?php __('Add'); ?></legend>
    <?php
        echo $this->Form->input('DispatchGallery.modified');
        echo $this->Form->input('Dispatch.news_text');
        echo $this->Form->input('Gallery.name');
//        echo $this->Form->input('Gallery.id');
        echo $this->Form->input('Dispatch.Image.img_file', array(
            'type' => 'file'
        ));
//        echo $this->Form->input('date');
//        echo $this->Form->input('Image');
//        echo $this->Form->input('Gallery');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
