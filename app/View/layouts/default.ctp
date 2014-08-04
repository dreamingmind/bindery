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
    echo $this->Html->css('basic');
    echo $this->Html->css('tree_admin');
    echo $this->Html->css('gal4');
    if (
            $this->request->params['action']=='forgot' 
            || $this->request->params['action']=='login'
            || $this->request->params['action']=='validate_user'
            || $this->request->params['action']=='opt_in')
       {
        echo $this->Html->css('login');
    }
    echo $this->Html->script('jquery-1.4.2');
    echo $scripts_for_layout;
    ?>
</head>
<!-- BODY --><body>
    <!--CONTAINER DIV --><div id="container">
        <!-- HEADER DIV --><div id="header">
            <?php
            echo $this->Html->image('dmbold.png',
                array('alt'=> __('Dreaming Mind Bindery'),
                    'border' => '0',
                    'style'=>'padding: 16px 8px 8px 20px; border-bottom-width: 2px'));
            ?>
            <?php if (isset($productExhibits) || $this->request->params['action'] == 'gallery') {
                echo $this->GalNav->productGalleryThumbnails($productExhibits);

                } ?>
            <!-- HEADER TOOLS --><div id="headerTools"><?php
            echo $this->Html->accountTool_($userdata); // creates DIV id=accountTool
            echo $this->Form->siteSearch(); // creates DIV id=siteSearch
            ?></div><!-- END HEADER TOOLS -->
        </div>
        <!-- NAVBAR DIV --><div id='navBar'>
            <?php
            //This hack takes care of the empty 'home' route
//            $this->request->params['url']['url'] = ($this->request->params['url']['url'] == '/') ? 'pages' : $this->request->params['url']['url'];
            $this->request->url = ($this->request->url == '/') ? 'pages' : $this->request->url;
            echo $this->Menu->NavigationMenu($group, array_flip(explode('/', $this->request->url)));
            //echo $this->Menu->NavigationMenu2($group, array_flip(explode('/', $this->request->params['url']['url'])));
            ?>
        </div>
        <!-- CONTENT DIV --><div id="content">
            <?php if (isset($productExhibits) || $this->request->params['action'] == 'gallery') { 
                echo $this->GalNav->productPageLinks();
                
                } ?>
            <?php echo '<!-- Flash message -->' . $this->Session->flash();
            echo '<!-- Flash auth message -->' . $this->Session->flash('auth');?>
            <?php echo $content_for_layout;
            echo $this->Session->flash('email');
//            debug($group[0]);
//            debug($group);
//            debug(array_flip(explode('/', $this->request->params['url']['url'])));
//            debug($userdata);
//            debug($authed);
//            debug('authed user\'s level: ' . $authedLevel);
//            debug('authorize method: ' . $authorizeMethod);
//            debug($this->Session->params);
//            debug($session);
//            debug($aro);
//            debug($group[0]);
//            debug($stage);
            ?>
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
    </div>
    <?php
    echo $this->Js->writeBuffer(); // Write cached scripts
    ?>
</body>
</html>