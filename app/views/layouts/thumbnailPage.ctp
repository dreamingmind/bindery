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
    <?php echo $html->charset(); ?>
    <!-- TITLE --><title>
        <?php
        __("Don's Cake Page: ");
        echo $title_for_layout;
        ?>
    </title>
    <?php
    echo $html->meta('icon');
    echo $html->css('basic');
    echo $html->css('new4.css');
    echo $html->css('advanced-search');
    if ( $this->params['action'] == 'manage_tree'){
        echo $html->css('tree_admin');
    }
    if (
        $this->params['action']=='forgot' 
        || $this->params['action']=='login'
        || $this->params['action']=='validate_user'
        || $this->params['action']=='opt_in')
    {
        echo $html->css('login');
    }
    echo $this->Html->script('jquery-1.4.2');
    echo $this->Html->script('manage_thumbnails');
    echo $this->Html->script('jumpbox');
    echo $this->Html->script('adjust_markdown');
    if($this->params['action']=='gallery'){
        echo $this->Html->script('edit_exhibit');
    } elseif($this->params['action']=='newsfeed') {
        echo $this->Html->script('edit_dispatch');
    }
    echo $this->Html->script('app');
    if ($this->params['action'] == 'art'){
        echo $html->css('art');
        echo $this->Html->script('art');
        echo $this->Html->script('blog_image_zoom');
        echo $this->Html->script('adjust_markdown');
        echo $this->Html->script('edit_dispatch');
    }
    echo $scripts_for_layout;
    ?>
    <script type="text/javascript">
        function showhide(divid, state){document.getElementById(divid).style.display=state}
    </script>
</head>
<!-- BODY --><body>
    <?php // debug($this->params);die; ?>
<div id="fixedNav">
    <div id="absNav">
        <?php echo $html->image('dmboldlogo_.png', array('alt'=>'Dreaming Mind Bindery logo')); ?>
        <div id="headerTools">
            <div id="accountTool">
                <p>
                    <?php if(isset($_GET['a'])) { ?><a href="/dispatch/unpublished">3 Unpub'd</a> | <a href="/dispatch/upload">Upload New</a> | <?php } ?>
                    <?php echo $html->accountTool_($userdata); // creates DIV id=accountTool ?>
                </p>
            </div>
            <div id="jumpBox">
                <?php echo $form->create('Content', array(
                    'action'=>'jump')
                    );?>
                <?php if($this->action == 'newsfeed'){ ?>
                <label class="inputBox" for="j"><span id="jumpMessage" style="color:red; font-weight:bold"></span>Showing #<?php echo $pageData['start']; ?> of <span id="highJump"><?php echo $pageData['count']; ?></span> </label>
                    <input type="text" name="data[j]" id="jumpInput" class="jump_input inputBox" 
                           onfocus="if(this.value=='Jump to #'){ this.value=''; }" 
                           onblur="if(this.value==''){ this.value='Jump to #'; }" value="Jump to #" />
                <?php } else { ?>
                    <label class="inputBox" for="j"><span id="jumpMessage" style="color:red; font-weight:bold"></span>Showing #<?php echo $neighbors[$paginator->params['named']['id']]['count'] ?> of <span id="highJump"><?php echo $this->Paginator->counter(array('format'=>'%count%')) ?></span> </label>
                    <input type="text" name="data[j]" id="jumpInput" class="jump_input inputBox" 
                           onfocus="if(this.value=='Jump to #'){ this.value=''; }" 
                           onblur="if(this.value==''){ this.value='Jump to #'; }" value="Jump to #" />
                <?php }
//		echo $form->input('controller',array(
//                    'type'=>'hidden',
//                    'name'=>'data[controller]',
//                    'value'=>$this->params['controller']));
		echo $form->input('action',array(
                    'type'=>'hidden',
                    'name'=>'data[action]',
                    'value'=>$this->params['action']));
		echo $form->input('pname',array(
                    'type'=>'hidden',
                    'name'=>'data[pname]',
                    'value'=>$this->params['pname']));
		echo $form->input('url',array(
                    'type'=>'hidden',
                    'name'=>'data[url]',
                    'value'=> '/'.$this->params['url']['url'])); //need the slash for a proper path in the redirect
                echo $form->end();?>

            </div>
        </div>
            <?php 
                if($this->action == 'newsfeed'){
                    echo $html->newsfeedFilmStrip($collectionPage, $pageData);
//                    $js->buffer('$(document).ready(function cp(){collectionPage = ' . json_encode($collectionJson) . '})');
                    $js->buffer("\rfunction initCollectionPage(){\rreturn " . json_encode($collectionJson)."\r}");
                    $script = file_get_contents(JS.DS.'newsthumb.js');
                    $js->buffer($script);
                } else {
                    //this will default to the gallery filmstrip
                    echo $html->FilmStrip($filmStrip, $this->Paginator, $neighbors); //$filmStrip, $this->Paginator, $neighbors
                }
            ?>
        <div id="menuNav">
            <?php 
            if (!isset($searchController)) {$searchController=null;}
            echo $form->siteSearch($searchController); // creates DIV id=siteSearch 
            ?>
            <div id="navBar">
                <?php
                    //This hack takes care of the empty 'home' route
                    $this->params['url']['url'] = ($this->params['url']['url'] == '/') ? 'pages' : $this->params['url']['url'];
                    echo $menu->NavigationMenu($group, array_flip(explode('/', $this->params['url']['url'])));
                    //echo $menu->NavigationMenu2($group, array_flip(explode('/', $this->params['url']['url'])));
                ?>
            </div>  <!-- end of navBar, Main Navigation Menu -->
        </div> <!-- end of menuNav -->
    </div> <!-- end of absNav -->
</div> <!-- end of fixedNav -->

        <!-- CONTENT DIV --><div id="scrolling">
    <?php echo $html->image('transparent.png', array('id'=>'topTransparent')); ?>
            <?php //if (isset($productExhibits) || $this->params['action'] == 'gallery') { 
                //echo $galNav->productPageLinks();
                
                //} ?>
            <?php echo '<!-- Flash message -->' . $session->flash();
            echo '<!-- Flash auth message -->' . $session->flash('auth');
            echo $this->Session->flash('email');?>
            <div id="detail">
            <?php echo $content_for_layout;?>
</div>
            <!-- FOOTER DIV --><div id="footer">
                <?php
                echo $html->link(
                    $html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework', true), 'border' => '0')),
                    'http://www.cakephp.org/',
                    array('target' => '_blank', 'escape' => false)
                );
                ?>
            </div>
                <?php //debug($this->params); ?>
                <?php // debug($neighbors); debug($pageData); debug($paginator); ?>
                <?php echo $this->element('sql_dump'); ?>
        </div>
    <?php
    echo $js->writeBuffer(); // Write cached scripts
//    debug($collectionPage);
    ?>
</body>
</html>
