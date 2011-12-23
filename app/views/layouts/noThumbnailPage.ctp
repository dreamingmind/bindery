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
        __("Don's Cake Page: ");
        echo $title_for_layout;
        ?>
    </title>
    <?php
    echo $html->meta('icon');
    echo $html->css('basic');
    echo $html->css('new4.css');
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
            <?php if(isset($_GET['a'])) { ?><a href="/dispatch/unpublished">3 Unpub'd</a> | <a href="/dispatch/upload">Upload New</a> | <?php } ?>
            <?php echo $html->accountTool_($userdata); // creates DIV id=accountTool ?>
            </p>
  	</div>
  </div>
  <div id="menuNav">
<?php 
    if (!isset($searchController)) {
        $searchController=null;
    }
    if (!isset ($hidden)) {
        $hidden=null;
    }
  echo $form->siteSearch($searchController, $hidden); // creates DIV id=siteSearch 
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
<div id="search-form">

<form method="post" name="search" id="form-search-submit" action="/search.htm">

<label for="search-text" class="hide-fromsighted">Search USPS.com or Track Packages</label>
<input type="text" 
       rel="Search USPS.com or Track Packages" 
       id="search-text" autocomplete="off" 
       name="searchText" 
       class="default hasDefault" 
       value="Search USPS.com or Track Packages" 
/>
<input type="image" 
       id="search-btn" 
       src="/ContentTemplates/assets/images/global/blank.gif" 
       alt="Process Search" 
/>

</form>

</div>
</body>
</html>