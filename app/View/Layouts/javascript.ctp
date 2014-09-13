<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $title_for_layout; ?></title>
    <?php echo $this->Html->script($scripts); ?>
    <?php echo $scripts_for_layout; ?>
    <style type="text/css">
        a.test { font-weight: bold; }
    </style>

</head>

<body>

    <?php echo $content_for_layout; ?>

    <?php echo $this->Js->writeBuffer(); // Write cached scripts ?>
</body>
</html>
