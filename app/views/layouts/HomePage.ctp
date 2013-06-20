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
    <?php echo $html->charset(); ?>
    <!-- TITLE --><title>
        <?php
        __("Dreaming Mind Bindery - ");
        echo $title_for_layout;
        ?>
    </title>
    <?php
    echo $html->meta('icon');

    echo $this->Html->css($css);

    echo $this->Html->script($scripts);

    echo $scripts_for_layout;
    ?>
    <script type="text/javascript">
        function showhide(divid, state){document.getElementById(divid).style.display=state}
    </script>
</head>
<!-- BODY --><body>
<div id="NTfixedNav">
<div id="absNav">
  <?php echo $html->image('dmboldlogo_.png', array('alt'=>'Dreaming Mind Bindery logo')); ?>
  <div id="headerTools">
  	<div id="accountTool">
            <p>
            <?php echo $html->accountTool_($userdata); // creates DIV id=accountTool ?>
            </p>
  	</div>
      <?php echo $this->element('image_grid_nav');
 ?>
  </div>
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
    <?php echo $html->image('transparent.png', array('id'=>'NTtopTransparent')); ?>
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
                <?php echo $this->element('sql_dump'); ?>
        </div>
    <?php
    echo $js->writeBuffer(); // Write cached scripts
    ?>
</body>
</html>