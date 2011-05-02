<!-- <h1><?php echo $this->params['pname'] ?> gallery</h1> -->
<div id="detail">
<?php echo $this->Html->image('exhibits/thumb/x640y480/' . $record['Exhibit']['img_file'],
        array('alt'=>$record['Exhibit']['alt'])); ?>

<style type='text/css' media='screen'><!--
    #proseblock {
        position: absolute;
        z-index: 5;
        top: <?php echo ($record['Exhibit']['top_val']-65); ?>px;
        left: <?php echo ($record['Exhibit']['left_val']-155); ?>px;
        width: <?php echo $record['Exhibit']['width_val']; ?>px;
        height: <?php echo $record['Exhibit']['height_val']; ?>px;
    }/n--></style>
<div id='proseblock'>
<span class='<?php echo $record['Exhibit']['headstyle'] ?>'><?php echo $record['Exhibit']['heading'] ?></span>
<br />
<br />
<span class='<?php echo $record['Exhibit']['pgraphstyle'] ?>'><?php echo $record['Exhibit']['prose_t'] ?><br><br></span>
</div>
</div> <!-- end of detail -->
