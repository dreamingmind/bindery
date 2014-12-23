<?php /* @var $this ViewCC */ ?>
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
<!-- View/Layouts/noThumbnailPage.ctp -->
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
	echo $this->fetch('scripts');
//    echo $this->Html->wrapScriptBlock($imagePath);

//    echo $this->Html->script('supplement_defaults');
//    if($this->request->params['controller']=='catalogs'){
//        echo $this->Html->script('catalog');
//    }
//    echo $this->Html->script('app');
//    if ($this->request->params['action'] == 'art'){
//        echo $this->Html->script('art');
//        echo $this->Html->script('blog_image_zoom');
//        echo $this->Html->script('adjust_markdown');
//        echo $this->Html->script('edit_dispatch');
//    }
//    if($this->request->params['action']=='change_collection'){
//        echo $this->Html->script('change_collection');
//    }
//    if($this->request->params['action']=='change_collection'){
//        echo $this->Html->script('change_collection');
//    }
//    if($this->request->params['action']=='select'){
//        echo $this->Html->script('materials');
//    }
//    if($this->request->params['controller']=='workshops'){
//        echo $this->Html->script('workshop');
//        if ($this->request->params['action'] == 'detail'){
//            echo $this->Html->script('blog_image_zoom');
//            echo $this->Html->script('adjust_markdown');
//            echo $this->Html->script('edit_dispatch');
//    }
//}
    echo $scripts_for_layout;
    ?>
    <script type="text/javascript">
        function showhide(divid, state){document.getElementById(divid).style.display=state}
    </script>
</head>
<!-- BODY --><body>
<?php echo $this->element('TIME/time_hook'); ?>
<div id="pgMask"></div>
<div id="NTfixedNav">
<div id="absNav">
  <?php echo $this->Html->image('dmboldlogo_.png', array('alt'=>'Dreaming Mind Bindery logo')); ?>
  <div id="headerTools">
  	<div id="accountTool">
            <?php echo $this->Html->accountTool_($userdata); // creates DIV id=accountTool ?>
			<?php echo $this->element('Cart/cart_badge'); ?>
  	</div>
      <?php echo $this->element('image_grid_nav');
 ?>
  </div>
  <div id="menuNav">
<?php
            if (!isset($searchController)) {$searchController=null;}
            echo $this->Form->siteSearch($searchController); // creates DIV id=siteSearch
?>
	<div id="navBar">
            <?php
            //This hack takes care of the empty 'home' route
            $this->request->url = ($this->request->url == '/') ? 'pages' : $this->request->url;
            echo $this->Menu->NavigationMenu($group, array_flip(explode('/', $this->request->url)));
            //echo $this->Menu->NavigationMenu2($group, array_flip(explode('/', $this->request->url)));
            ?>
 	</div>  <!-- end of navBar, Main Navigation Menu -->
 </div> <!-- end of menuNav -->
</div> <!-- end of absNav -->
</div> <!-- end of fixedNav -->
<?php $idAttr = isset($contentDivIdAttr) ? $contentDivIdAttr : 'scrolling'; ?>
        <!-- CONTENT DIV --><div id="<?php echo $idAttr; ?>">
    <?php echo $this->Html->image('transparent.png', array('id'=>'NTtopTransparent')); ?>
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
                <?php echo $this->element('sql_dump'); ?>
        </div>
    <?php
    echo $this->Js->writeBuffer(); // Write cached scripts
    ?>
</body>
<?php

	// The repository for all the js vars that get 
	// accumulated during the visit. 
	// jsGlobalVars fetch block ends up here
	echo $this->element('jsGlobals');
	
?>
</html>