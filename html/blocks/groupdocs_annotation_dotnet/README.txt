Moodle Basics

Moodle framework, is using Blocks as standard plugin element which can be Created, Deleted and Updated. That is where our GroupDocs documents will be displayed. In order to insert a new block on page, simply login as Administrator, and under Settings find Turn editing on. Then under Add a block when your plugin is installed, choose GroupDocs. Every block has Configuration or Edit icon. If you go there, here we can edit GroupDocs, but in order to see it in the middle where the main content is, after filling Document, scroll down to the bottom and choose in Default region or Region  location - Center.
Installation Instructions
Theme installation

In order to see GroupDocs properly, we need to locate block (moodle plugin element) in centre or where a page content is. To do that we need to edit theme what website is running or choose own one. (Ref: http://moodle.org/mod/forum/discuss.php?d=152959)

1. Modify [yourtheme]/layout/frontpage.php (or general.php or report.php) put <?php echo $OUTPUT->blocks_for_region('main') ?> under <?php echo $OUTPUT->main_content() ?>

2. Modify [yourtheme]/config.php , lets say in:

'frontpage' => array(
        'file' => 'frontpage.php',
        'regions' => array('side-pre','side-post'),
        'defaultregion' => 'side-pre',
        'options' => array('langmenu'=>true),
    ),

exchange side-post to main.

3. In lang/en/theme_name.php add $string['region-main'] = 'Center'; to the end.

That's it, this way we edited website theme, to make block in the middle

( Note: in Moodle 1.9 version you don't have to change theme, but insert some code in to 3 files is necessary, to make Center blocks available )
Plugin installation

1. Place groupdocs_annotation folder in root/blocks directory

2. Go to site/admin/index.php and on page Plugins check there should be plugin in the list, so press 'Upgrade Moodle database now'.

Note: GroupDocs Block can be moved to center on some navigation page, by pressing 'Move' button (coming from basic theme)

(Ref: http://docs.moodle.org/23/en/plugins/index section Installation )
Uninstalling Plugin

    Go to Settings > Site Administration > Plugins > Plugins overview and click the Uninstall link opposite the plugin you wish to remove
    Use a file manager to remove/delete the actual plugin directory as instructed, otherwise Moodle will reinstall it next time you access the site administration
