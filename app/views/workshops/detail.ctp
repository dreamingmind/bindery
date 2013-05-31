<?php
//debug($recentTitles);
//debug($article);die;
//echo $this->Html->changeCollection($this->viewVars, $article[0]['Content']['slug'], $article[0]['Collection']['id']);
//echo $html->tag('h1',
//        'From the collection: '.$article[0]['Collection']['heading'].
//        $this->Form->button('Related Articles',array(
//            'class'=>'related',
//            'slug'=>$article[0]['Content']['slug'],
//            'collection'=>'collection'.$article[0]['Collection']['id']))) . $html->div('related',''); 
//echo $html->tag('h2',$article[0]['Content']['heading']);
//debug($userdata);
        // This is the admins edit form for the Content record
        // passedArgs and params are saved from the current page
        // so the full page context can be re-established 
        // if the data gets saved properly.
if(isset($this->viewVars['usergroupid']) && $this->viewVars['usergroupid']<3){
    // I create a content_id attribute for the form so the 
    // ajax call knows what record to get for the form values
    echo $this->Form->create('Content', array(
//                'default'=>false,
        'class'=>'edit',
        'action'=>'edit_dispatch'//.DS.$entry['Content']['id'],
//                'content_id'=>$entry['Content']['id']
        ));
    echo $form->input('passedArgs',array(
        'type'=>'hidden',
        'name'=>'data[passedArgs]',
        'value'=>  serialize($this->passedArgs)));
    echo $form->input('params',array(
        'type'=>'hidden',
        'name'=>'data[params]',
        'value'=>  serialize($this->params)));
}
    $featureHtml = '';
    $workshopTitle = $this->Html->tag('h2',$feature['Workshop']['heading'],array('id'=>'featureHeading'));
    $workshopPicture = $this->Html->image(
            "images/thumb/x160y120/{$feature['ContentCollection'][0]['Content']['Image']['img_file']}",array('id'=>'featurePicture'));
    $workshopContent = TextHelper::truncate(Markdown($feature['ContentCollection'][0]['Content']['content']),550);
    $sessioncount = count($feature['Session']);
//  sprintf slugging
    $dateslug = '<p class="day"><time datetime="%s">%s</time><span class="%s">%s</span> - %s<span class="%s">%s</span>';
//    preset $starttimestamp & $endtimestamp for each loop
//    will use sprintf($dateslug,
//                      $starttimestamp,
//                      $date('M d Y, g:i',$starttimestamp),
//                      $date('a',$starttimestamp),
//                      $date('A',$starttimestamp),
//                      $date('g:i',$endtimestamp),
//                      $date('a',$endtimestamp),
//                      $date('A',$endtimestamp))
//  Variable setup
    $sesnumber = 1;
    $accum = $costaccum = array();
//  Button loop
    foreach($feature['Session'] as $wksession){
            $s = ($sessioncount>1)?'Session ' . $sesnumber . ' - ':'';
            $cost = 'Register: '
            . $s
            . $this->Number->currency($wksession['cost'],'USD',$options=array('before'=>'$','places'=>0));
//    debug($cost);die;
        $accum[]= $this->Form->button($cost,array('class'=>'register'));
//      Date loop
        $durations[$sesnumber]=0;
        foreach ($wksession['Date'] as $date){
            $starttimestamp = strtotime($date['date'].' '.$date['start_time']);
            $endtimestamp = strtotime($date['date'].' '.$date['end_time']);
            $accum[] = sprintf($dateslug,
                      $starttimestamp,
                      date('M d Y, g:i',$starttimestamp),
                      date('a',$starttimestamp),
                      date('A',$starttimestamp),
                      date('g:i',$endtimestamp),
                      date('a',$endtimestamp),
                      date('A',$endtimestamp));
            $durations[$sesnumber] += $endtimestamp-$starttimestamp;
        }
        $costaccum[]= 'Session ' . $sesnumber . ' is '
                . ($durations[$sesnumber++]/3600) . ' hours, '
                . $this->Number->currency($wksession['cost'],'USD',$options=array('before'=>'$','places'=>0));
    }
//    $accum = array(
//        '<button class="register">Register: Session 1 - $120</button>',
//        '<p class="day"><time datetime="2013-6-7 9:00:00">June 6 2013, 9:00</time><span class="am">AM</span> - 2:00<span class="pm">PM</span>',
//        '<p class="day"><time datetime="2013-6-8 9:00:00">June 6 2013, 9:00</time><span class="am">AM</span> - 2:00<span class="pm">PM</span>',
//        '<button class="register">Register: Session 2 - $120</button>',
//        '<p class="day"><time datetime="2013-9-20 7:00:00">September 20 2013, 7:00</time><span class="am">AM</span> - 3:00<span class="pm">PM</span>',
//    );
if($upcoming){
    $sessions = implode('', $accum);
}else{
    $sessions = $this->element('workshop_date_request', array(
        'heading'=>$feature['Workshop']['heading'],
        'id'=>$feature['Workshop']['id']));
}
    $sessionDiv = $this->Html->div('',$sessions,array('id'=>'featuredSession'));
    $costLine = $this->Html->tag('h3',  implode(' // ', $costaccum),array('class'=>'featureCost'));

    $featureHtml = $workshopPicture . $workshopTitle . $workshopContent . $costLine . $sessionDiv;
    echo $this->Html->css('search_links');
    echo $this->Html->div('',
        $this->Html->div('',$featureHtml,array(
            'id'=>'feature-overlay'
        )),
        array(
            'id'=>'feature-pic',
            'style'=>"background: url('/bindery/img/images/thumb/x640y480/{$feature['ContentCollection'][0]['Content']['Image']['img_file']}') no-repeat scroll 0px 0px transparent;"
        )
     );

foreach($article as $entry){
    $cls = str_replace(array('.','-'), '', $entry['Content']['Image']['img_file']);
    echo $html->div('entry',

'        <menu class="local_zoom" id="'.$cls.'" >
            <a class="local_scale_tool">-</a> 
            <a class="local_scale_tool">+</a>
        </menu>
'
        // the div content
        . $html->image(
            'images'.DS.'thumb'.DS.'x320y240'.DS.$entry['Content']['Image']['img_file'],
            array('alt'=>$entry['Content']['Image']['alt'].' '.$entry['Content']['Image']['alt'],
                'class'=>'scalable '.$cls)
        )
        ."\n"
        . $html->div($cls . ' entryText x320y240 markdown',Markdown($entry['Content']['content']),
        array(''/* the div attributes */)));
    
        if(isset($this->viewVars['usergroupid']) && $this->viewVars['usergroupid']<3){
            // I create a content_id attribute for the form so the 
            // ajax call knows what record to get for the form values
            //This is the div where the ajaxed form elements get inserted
            // This button gets a click function to toggle the form in/out of the page
            echo $form->button('Edit',array(
                'class'=>'edit',
                'type'=>'button',
                'slug'=>$article[0]['Content']['slug'],
                'content_id'=>$entry['Content']['id']
            ));
            echo '<div class="formContent'.$entry['Content']['id'].'"></div>';
        }
}
echo '</form>';
?>