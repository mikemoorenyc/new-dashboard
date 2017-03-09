<?php
/**
 * Template Name: MAIN DASH VIEW
 */
?>
<?php
$dir = new DirectoryIterator(get_template_directory().'/dashview/components/templates');

foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        $name = $fileinfo->getFilename();
        $path_parts = pathinfo($name);
        ?>
        <script type="text/x-template" id="<?php echo $path_parts['filename'];?>">
        <?php
        include get_template_directory().'/dashview/components/templates/'.$path_parts['basename'];
        ?>
        </script>
        <?php
    }
}

 ?>
