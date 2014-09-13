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
        <?php
        echo "Don Drake's Bench Marks: $blog_title";
        ?>
    </title>
    <?php
    echo $this->Html->meta('icon');

    echo $this->Html->css($css);

//    $this->Js->buffer("var size_swaps = $size_swaps;");
    echo $this->Html->script($scripts);
//    echo $this->Html->script('blog_menu');
//    echo $this->Html->script('blog_image_zoom');
//    echo $this->Html->script('adjust_markdown');
//    echo $this->Html->script('edit_dispatch');
//    echo $this->Html->script('app');
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
        <?php echo $this->Html->image('bench-marks-814-150-transparent.png', array('alt'=>"Don Drake's Bench Marks blog banner")); ?>
        <div id="headerTools">
            <div id="accountTool">
                <p>
                    <?php  echo $this->Html->accountTool_($userdata); // creates DIV id=accountTool ?>
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
            if (!isset($searchController)) {$searchController=null;}
            echo $this->Form->siteSearch($searchController); // creates DIV id=siteSearch 
            ?>
            <div id="navBar">
            <?php
//            $tocLookup = array_shift($toc);
//                debug($toc);//die;
            $this->Html->output('<ul>');
                foreach($rootMenu as $menuLine){
                    $this->Html->output($this->Html->tag('li',$this->Html->link($menuLine['Navline']['name'],'/'.$menuLine['Navline']['route'])));
                }
//                $this->Html->output($this->Html->tag('li',$this->Html->link('The Bindery','/')));
//                $this->Html->output($this->Html->tag('li',$this->Html->link('Workshops','/workshops')));
                $this->Html->output('<li id="collections">'.$this->Html->link('Article Collections',array(''))
                );
                    foreach($toc as $index => $collection){
                        if(!is_string($index)){
                            $this->Html->output("\t<ul id='collection$index' class='open collection collections'>\r\t\t<li>"
                                    .$this->Html->link($collection['heading'],$index)
                                    );
                            $this->Html->output("\t\t\t<ul class='collection$index close'>");
                            foreach($collection['Titles'] as $slug => $heading){
                                $this->Html->output("\t\t\t\t".$this->Html->tag('li',
                                        $this->Html->link($heading, array(
                                            'action'=>'blog',
                                            $index,
                                            $slug,
                                            '#'
                                        )), array('class'=>'article')
                                ));
                            }
                            $this->Html->output("\t\t\t</ul>");
                            $this->Html->output("\t\t</li>");
                            $this->Html->output("\t</ul>");
                        }
                    }
                $this->Html->output($this->Html->tag('li','Recent updates:'));
            $this->Html->output('</ul>');
            foreach($recentPosts as $news){
                echo $this->Html->blogMenuBlock($news, $result_imagePath);
            }
                        
                ?>
            </div>  <!-- end of navBar, Main Navigation Menu -->
        </div> <!-- end of menuNav -->
    </div> <!-- end of absNav -->
</div> <!-- end of fixedNav -->

        <!-- CONTENT DIV --><div id="scrolling">
    <?php // echo $this->Html->image('transparent.png', array('id'=>'topTransparent')); ?>
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
