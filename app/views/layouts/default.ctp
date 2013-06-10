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
    echo $html->css('tree_admin');
    echo $html->css('gal4');
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
</head>
<!-- BODY --><body>
    <!--CONTAINER DIV --><div id="container">
        <!-- HEADER DIV --><div id="header">
            <?php
            echo $html->image('dmbold.png',
                array('alt'=> __('Dreaming Mind Bindery', true),
                    'border' => '0',
                    'style'=>'padding: 16px 8px 8px 20px; border-bottom-width: 2px'));
            ?>
            <?php if (isset($productExhibits) || $this->params['action'] == 'gallery') {
                echo $galNav->productGalleryThumbnails($productExhibits);

                } ?>
            <!-- HEADER TOOLS --><div id="headerTools"><?php
            echo $html->accountTool_($userdata); // creates DIV id=accountTool
            echo $form->siteSearch(); // creates DIV id=siteSearch
            ?></div><!-- END HEADER TOOLS -->
        </div>
        <!-- NAVBAR DIV --><div id='navBar'>
            <?php
            //This hack takes care of the empty 'home' route
            $this->params['url']['url'] = ($this->params['url']['url'] == '/') ? 'pages' : $this->params['url']['url'];
            echo $menu->NavigationMenu($group, array_flip(explode('/', $this->params['url']['url'])));
            //echo $menu->NavigationMenu2($group, array_flip(explode('/', $this->params['url']['url'])));
            ?>
        </div>
        <!-- CONTENT DIV --><div id="content">
            <?php if (isset($productExhibits) || $this->params['action'] == 'gallery') { 
                echo $galNav->productPageLinks();
                
                } ?>
            <?php echo '<!-- Flash message -->' . $session->flash();
            echo '<!-- Flash auth message -->' . $session->flash('auth');?>
            <?php echo $content_for_layout;
            echo $this->Session->flash('email');
//            debug($group[0]);
//            debug($group);
//            debug(array_flip(explode('/', $this->params['url']['url'])));
//            debug($userdata);
//            debug($authed);
//            debug('authed user\'s level: ' . $authedLevel);
//            debug('authorize method: ' . $authorizeMethod);
//            debug($session->params);
//            debug($session);
//            debug($aro);
//            debug($group[0]);
//            debug($stage);
            ?>
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
    </div>
    <?php
    echo $js->writeBuffer(); // Write cached scripts
    ?>
</body>
</html>