<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.layouts
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- HEAD --><head>
    <?php echo $this->Html->charset(); ?>
    <!-- TITLE --><title>
        <?php echo __("Don's Cake Page: ");
        echo $title_for_layout;
        ?>
    </title>
    <?php
    echo $this->Html->meta('icon');

    echo $this->Html->css($css);

    echo $this->Html->script($scripts);

    echo $scripts_for_layout;
    ?>
    <script type="text/javascript">
        function showhide(divid, state){document.getElementById(divid).style.display=state}
    </script>
</head>
<!-- BODY --><body>
    <?php // debug($this->request->params);die; ?>
<div id="fixedNav">
    <div id="absNav">
        <?php echo $this->Html->image('dmboldlogo_.png', array('alt'=>'Dreaming Mind Bindery logo')); ?>
        <div id="headerTools">
            <div id="accountTool">
                <p>
                    <?php if(isset($_GET['a'])) { ?><a href="/dispatch/unpublished">3 Unpub'd</a> | <a href="/dispatch/upload">Upload New</a> | <?php } ?>
                    <?php echo $this->Html->accountTool_($userdata); // creates DIV id=accountTool ?>
                </p>
            </div>
            <div id="jumpBox">
                <?php echo $this->Form->create('Content', array(
                    'action'=>'jump')
                    );?>
                <?php if($this->request->action == 'newsfeed'){ ?>
                <label class="inputBox" for="j"><span id="jumpMessage" style="color:red; font-weight:bold"></span>Showing #<?php echo $pageData['start']; ?> of <span id="highJump"><?php echo $pageData['count']; ?></span> </label>
                    <input type="text" name="data[j]" id="jumpInput" class="jump_input inputBox" 
                           onfocus="if(this.value=='Jump to #'){ this.value=''; }" 
                           onblur="if(this.value==''){ this.value='Jump to #'; }" value="Jump to #" />
                <?php } else { ?>
                    <label class="inputBox" for="j"><span id="jumpMessage" style="color:red; font-weight:bold"></span>Showing #<?php echo $neighbors[$this->Paginator->params['named']['id']]['count'] ?> of <span id="highJump"><?php echo $this->Paginator->counter(array('format'=>'%count%')) ?></span> </label>
                    <input type="text" name="data[j]" id="jumpInput" class="jump_input inputBox" 
                           onfocus="if(this.value=='Jump to #'){ this.value=''; }" 
                           onblur="if(this.value==''){ this.value='Jump to #'; }" value="Jump to #" />
                <?php }
//		echo $this->Form->input('controller',array(
//                    'type'=>'hidden',
//                    'name'=>'data[controller]',
//                    'value'=>$this->request->params['controller']));
		echo $this->Form->input('action',array(
                    'type'=>'hidden',
                    'name'=>'data[action]',
                    'value'=>$this->request->params['action']));
		echo $this->Form->input('pname',array(
                    'type'=>'hidden',
                    'name'=>'data[pname]',
                    'value'=>$this->request->params['pname']));
		echo $this->Form->input('url',array(
                    'type'=>'hidden',
                    'name'=>'data[url]',
                    'value'=> '/'.$this->request->params['url']['url'])); //need the slash for a proper path in the redirect
                echo $this->Form->end();?>

            </div>
        </div>
            <?php 
                if($this->request->action == 'newsfeed'){
                    echo $this->Html->newsfeedFilmStrip($collectionPage, $pageData);
//                    $this->Js->buffer('$(document).ready(function cp(){collectionPage = ' . json_encode($collectionJson) . '})');
                    $this->Js->buffer("\rfunction initCollectionPage(){\rreturn " . json_encode($collectionJson)."\r}");
                    $script = file_get_contents(JS.DS.'newsthumb.js');
                    $this->Js->buffer($script);
                } else {
                    //this will default to the gallery filmstrip
                    echo $this->Html->FilmStrip($filmStrip, $this->Paginator, $neighbors); //$filmStrip, $this->Paginator, $neighbors
                }
            ?>
        <div id="menuNav">
            <?php 
            if (!isset($searchController)) {$searchController=null;}
            echo $this->Form->siteSearch($searchController); // creates DIV id=siteSearch 
            ?>
            <div id="navBar">
                <?php
                    //This hack takes care of the empty 'home' route
                    $this->request->params['url']['url'] = ($this->request->params['url']['url'] == '/') ? 'pages' : $this->request->params['url']['url'];
                    echo $this->Menu->NavigationMenu($group, array_flip(explode('/', $this->request->params['url']['url'])));
                    //echo $this->Menu->NavigationMenu2($group, array_flip(explode('/', $this->request->params['url']['url'])));
                ?>
            </div>  <!-- end of navBar, Main Navigation Menu -->
        </div> <!-- end of menuNav -->
    </div> <!-- end of absNav -->
</div> <!-- end of fixedNav -->

        <!-- CONTENT DIV --><div id="scrolling">
    <?php echo $this->Html->image('transparent.png', array('id'=>'topTransparent')); ?>
            <?php //if (isset($productExhibits) || $this->request->params['action'] == 'gallery') { 
                //echo $this->GalNav->productPageLinks();
                
                //} ?>
            <?php echo '<!-- Flash message -->' . $this->Session->flash();
            echo '<!-- Flash auth message -->' . $this->Session->flash('auth');
            echo $this->Session->flash('email');?>
            <div id="detail">
            <?php echo $content_for_layout;?>
</div>
            <!-- FOOTER DIV --><div id="footer">
                <?php
                echo $this->Html->link(
                    $this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework'), 'border' => '0')),
                    'http://www.cakephp.org/',
                    array('target' => '_blank', 'escape' => false)
                );
                ?>
            </div>
                <?php //debug($this->request->params); ?>
                <?php // debug($neighbors); debug($pageData); debug($paginator); ?>
                <?php echo $this->element('sql_dump'); ?>
        </div>
    <?php
    echo $this->Js->writeBuffer(); // Write cached scripts
//    debug($collectionPage);
    ?>
</body>
</html>
