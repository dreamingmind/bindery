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
    echo $html->css('speech-bubbles');
    if ( $this->params['action'] == 'manage_tree'){
        echo $html->css('tree_admin');
    }
    echo $html->css('blog.css');
    if (
        $this->params['action']=='forgot' 
        || $this->params['action']=='login'
        || $this->params['action']=='validate_user'
        || $this->params['action']=='opt_in')
    {
        echo $html->css('login');
    }
//    $js->buffer("var size_swaps = $size_swaps;");
    echo $this->Html->script('jquery-1.4.2');
    echo $this->Html->script('visibilities');
    echo $this->Html->script('responsive_layout');
    echo $this->Html->script('adjust_markdown');
    echo $this->Html->script('edit_dispatch');
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
        <?php echo $html->image('bench-marks-814-150-transparent.png', array('alt'=>"Don Drake's Bench Marks blog banner")); ?>
        <div id="headerTools">
            <div id="accountTool">
                <p>
                    <?php  echo $html->accountTool_($userdata); // creates DIV id=accountTool ?>
                </p>
            </div>
        <menu class='zoom'>
            <?php echo (isset($userdata['group_id']) && $userdata['group_id']==1)?'<a class="sequence_tool">Order</a> ':''; ?>
            <a class="scale_tool">-</a> 
            <a class="scale_tool">+</a>
        </menu>
        </div>
        <div id="menuNav">
            <?php 
                $searchController = (!isset($searchController)) ? null : $searchController;
                $hidden = (!isset ($hidden)) ? null : $hidden;

                echo $form->siteSearch($searchController, $hidden); // creates DIV id=siteSearch 
            ?>
            <div id="navBar">
                <?
//                debug($toc);die;
            echo $html->tag('ul',
                    $html->tag('li',$html->link('The Bindery','/'))
                    .$html->tag('li',$html->link('Workshops','/workshops'))
                    .$html->tag('li','Recent updates:')
                    ,array('class'=>'open'));
//            $toc_id = $toc['id'];
//            unset($toc['id']);
//            echo '<ul class="open">';
//            foreach($toc as $collection => $list){
//                $id = $this->Text->truncate(sha1($collection),8,array('ending'=>''));
//                echo "<li class='collection menu' id='$id'>";
//                echo $html->link($collection,'#');
//                echo "<ul class='title_list close $id'>";
//                foreach($list as $href=>$text){
//                    echo $html->tag('li',
//                            $html->link($this->Text->truncate($text,25,array('ending'=>'...')),
//                                    '/blog/'.$toc_id[$collection].'/'.$href,array('title'=>$text)));
//                }
//                echo '</ul></li>';
//            }
                echo '</ul>';
            foreach($recentPosts as $news){
                echo $html->blogMenuBlock($news, $result_imagePath);
            }
                        
                ?>
            </div>  <!-- end of navBar, Main Navigation Menu -->
        </div> <!-- end of menuNav -->
    </div> <!-- end of absNav -->
</div> <!-- end of fixedNav -->

        <!-- CONTENT DIV --><div id="scrolling">
    <?php // echo $html->image('transparent.png', array('id'=>'topTransparent')); ?>
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
