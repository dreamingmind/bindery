<?php
// is this even used? it doesn't seem so.
if (empty($menuList)):
    $menuList = array(
        array(
            'name' => 'main',
            'selected' => 'home'
        )
    );
endif;

$menus = $this->requestAction(
    array(
        'controller' => 'menus',
        'action' => 'menus'
    ),
    array(
        'pass' => array(
           $menuList
        )
    )
);

if (! empty($menus)):
foreach ($menus as $menu):
$tabs = '';
foreach ($menu['tabs'] as $tab):
$url = array(
'controller' => $tab['controller'],
'action' => $tab['action']
);

if (! empty($tab['params'])):
$url[] = $tab['params'];
endif;

$tabs .= $this->Html->tag(
'li',
$this->Html->link(
$tab['text'],
$url,
array('class' => $tab['aClass'])
),
array(
'class' => $tab['liClass']
)
);
endforeach;

echo '<div class="' . $menu['divClass'] . '"><div class="container_12"><div class="grid_12">' . $this->Html->tag('ul', $tabs, array('class' => $menu['ulClass'])) . '</div></div></div>';
endforeach;
endif;
?>