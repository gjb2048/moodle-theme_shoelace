<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Shoelace theme with the underlying Bootstrap theme.
 *
 * @package    theme
 * @subpackage shoelace
 * @copyright  &copy; 2013-onwards G J Barnard in respect to modifications of the Clean theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Mary Evans, Bas Brands, Stuart Lamour and David Scotson.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

// Get the HTML for the settings bits.
$html = theme_shoelace_get_html_for_settings($OUTPUT, $PAGE);

$pre = 'side-pre';
$post = 'side-post';
if (right_to_left()) {
    $regionbsid = 'region-bs-main-and-post';
    // In RTL the sides are reversed, so swap the 'shoelaceblocks' method parameter....
    $temp = $pre;
    $pre = $post;
    $post = $temp;
} else {
    $regionbsid = 'region-bs-main-and-pre';
}

$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$contentclass = 'span8';
$blockclass = 'span4';
if (!($hassidepre AND $hassidepost)) {
    // Two columns.
    $contentclass = 'span9';
    $blockclass = 'span3';
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <meta name="description" content="<?php p(strip_tags(format_text($SITE->summary, FORMAT_HTML))) ?>" />
    <?php
        echo $OUTPUT->standard_head_html();
        if (!empty($PAGE->theme->settings->cdnfonts) && ($PAGE->theme->settings->cdnfonts == 2)) {
            require_once(dirname(__FILE__).'/tiles/cdn_fonts.php');
        }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>

<?php
echo $OUTPUT->standard_top_of_body_html();
require_once(dirname(__FILE__).'/tiles/header.php');
?>

<div id="page" class="container-fluid">

    <header id="page-header" class="clearfix">
        <?php echo $html->heading; ?>
    </header>

    <?php
    if (!empty($PAGE->theme->settings->nummarketingblocks)) {
        echo $OUTPUT->shoelaceblocks('marketing', 'row-fluid', 'aside', $PAGE->theme->settings->nummarketingblocks);
    }
    ?>
    <div id="page-content" class="row-fluid">
        <div id="<?php echo $regionbsid ?>" class="span9">
            <div class="row-fluid">
                <div id="region-main" class="<?php echo $contentclass; ?> pull-right">
                    <section id="region-main-shoelace" class="row-fluid">
                        <?php
                        echo $OUTPUT->main_content();
                        ?>
                    </section>
                    <div id="region-main-shoelace-shadow"></div>
                </div>
                <?php echo $OUTPUT->shoelaceblocks($pre, $blockclass.' desktop-first-column'); ?>
            </div>
        </div>
        <?php echo $OUTPUT->shoelaceblocks($post, 'span3'); ?>
    </div>

    <?php require_once(dirname(__FILE__).'/tiles/footer.php'); ?>

</div>
</body>
</html>
