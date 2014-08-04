<?php
if (isset($sequence_set)){
    ?>
<div id="sequence_panel">
    <?php
//    debug($most_recent);die;
    echo $this->Form->create('Content', array('default'=>false));
        foreach($sequence_set as $count=>$entry){
        echo '<fieldset>';
        echo $this->Form->input("ContentCollection.$count.id",array(
            'type'=>'hidden',
            'value'=>$entry['ContentCollection']['id'],
            'name'=>"data[$count][ContentCollection][id]"
        ));
        echo $this->Form->input("ContentCollection.$count.seq",array(
            'value'=>$entry['ContentCollection']['seq'],
            'name'=>"data[$count][ContentCollection][seq]"
            ));
        echo $this->Form->input("ContentCollection.$count.publish",array(
            'type'=>'text',
            'value'=>$entry['ContentCollection']['publish'],
            'name'=>"data[$count][ContentCollection][publish]"
            ));
        echo $this->Html->image(
            'images'.DS.'thumb'.DS.'x160y120'.DS.$entry['Content']['Image']['img_file'],
            array('alt'=>$entry['Content']['Image']['alt'].' '.$entry['Content']['Image']['alt'])
        );
        echo $this->Html->para(null,$this->Text->truncate($entry['Content']['content'],200,array('ending'=>'...')));
//        echo $entry['Content']['content'];
       echo '</fieldset>';
        }
    echo $this->Form->end(array('label'=>__('Submit'),'id'=>'sequence'));    
//    debug($seq);
    ?>
    <div id="result"></div>
</div>
    <script type="text/javascript">
//    $('#ContentSequenceForm').preventDefault();
    $('#sequence').bind('click', function(){
//        data = $('#ContentSequenceForm').serialize();
//        alert('<?php //echo $this->request->params['url']['url'] ?>');
        $.post('<?php echo $this->request->params['url']['url'] ?>',$('#ContentSequenceForm').serialize(),function(data){
            $('#detail').html(data);
        });
    })
//  /* attach a submit handler to the form */
//  $("#searchForm").submit(function(event) {
//
//    /* stop form from submitting normally */
//    event.preventDefault(); 
//        
//    /* get some values from elements on the page: */
//    var $form = $( this ),
//        term = $form.find( 'input[name="s"]' ).val(),
//        url = $form.attr( 'action' );
//
//    /* Send the data using post and put the results in a div */
//    $.post( url, { s: term },
//      function( data ) {
//          var content = $( data ).find( '#content' );
//          $( "#result" ).empty().append( content );
//      }
//    );
//  });

    </script>
   <?php
   } else {
       debug($this->request->data);
   }
