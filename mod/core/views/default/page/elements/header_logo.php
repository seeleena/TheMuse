<?php
/**
 * Elgg header logo
 */

$site = elgg_get_site_entity();
$site_name = $site->name;
$site_url = elgg_get_site_url();
?>
<img src="http://diana.shripat.com/themuseinfo/img/profile.png" width="50px" style="vertical-align: middle; float: left; margin-right: 10px; margin-left: 10px;" />  
<h1>
    <a class="elgg-heading-site" href="<?php echo $site_url; ?>">
            <?php echo $site_name; ?>
    </a>
</h1>