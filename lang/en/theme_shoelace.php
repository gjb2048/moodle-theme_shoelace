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
 * Strings for component 'theme_shoelace', language 'en'
 *
 * @package    theme
 * @subpackage shoelace
 * @copyright  &copy; 2013-onwards G J Barnard in respect to modifications of the Clean theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Mary Evans, Bas Brands, Stuart Lamour and David Scotson.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['choosereadme'] = '
<div class="clearfix">
<div class="well">
<h2>Shoelace</h2>
<p><img class="img-polaroid" src="shoelace/pix/screenshot.png" /></p>
</div>
<div class="well">
<h3>About</h3>
<p>Shoelace is a modified Moodle bootstrap theme which inherits styles and renderers from its parent theme.</p>
<h3>Parents</h3>
<p>This theme is based upon the Bootstrap theme, which was created for Moodle 2.5, with the help of:<br>
Stuart Lamour, Mark Aberdour, Paul Hibbitts, Mary Evans.</p>
<h3>Theme Credits</h3>
<p>Author: G J Barnard<br>
Contact: <a href="http://moodle.org/user/profile.php?id=442195">Moodle profile</a><br>
Website: <a href="http://about.me/gjbarnard">about.me/gjbarnard</a>
</p>
<h3>Sponsorships</h3>
<p>This theme is provided to you for free, and if you want to express your gratitude for using this theme, please consider sponsoring by:
<h4>PayPal</h4>
<p>Please contact me via my <a href="http://moodle.org/user/profile.php?id=442195" target="_blank">\'Moodle profile\'</a> for details as I am an individual and therefore am unable to have \'buy me now\' buttons under their terms.</p>
<h4>Flattr</h4>
<a href="https://flattr.com/profile/gjb2048" target="_blank">
clicking here to sponsor.
</a>
<br>Sponsorships may allow me to provide you with more or better features in less time.</p>
<h3>Report a bug:</h3>
<p><a href="http://tracker.moodle.org">http://tracker.moodle.org</a></p>
<h3>More information</h3>
<p><a href="shoelace/Readme.md">How to use this theme.</a></p>
</div></div>';

$string['configtitle'] = 'Shoelace';

$string['credit'] = 'The Shoelace theme for Moodle is developed and maintained by ';

$string['generalsettings'] = 'General';
$string['generalheadingsub'] = 'General settings';
$string['generalheadingdesc'] = 'Configure the general settings for Shoelace here.';

$string['themecolour'] = 'Theme colour';
$string['themecolourdesc'] = 'Set the colour for the theme.';

$string['textcolour'] = 'Text colour';
$string['textcolourdesc'] = 'Set the colour for the text.';

$string['navbartextcolour'] = 'Navbar text colour';
$string['navbartextcolourdesc'] = 'Set the colour for the navbar text.';

$string['cdnfonts'] = 'Content delivery network fonts';
$string['cdnfonts_desc'] = 'Use content delivery network fonts';

$string['customcss'] = 'Custom CSS';
$string['customcssdesc'] = 'Whatever CSS rules you add to this textarea will be reflected in every page, making for easier customization of this theme.';

$string['footnote'] = 'Footnote';
$string['footnotedesc'] = 'Whatever you add to this textarea will be displayed in the footer throughout your Moodle site.';

$string['invert'] = 'Invert navbar';
$string['invertdesc'] = 'Inverts text and theme colour for the navbar at the top of the page.';

$string['logo'] = 'Logo';
$string['logodesc'] = 'Please upload your custom logo here if you want to add it to the header.<br>
If the height of your logo is more than 75px add the following CSS rule to the Custom CSS box below.<br>
a.logo {height: 100px;} or whatever height in pixels the logo is.';

$string['nummarketingblocks'] = 'Maximum number of blocks per row in the marketing area';
$string['nummarketingblocksdesc'] = 'The maximum blocks per row in the marketing area.';

$string['numfooterblocks'] = 'Maximum number of blocks per row in the footer';
$string['numfooterblocksdesc'] = 'The maximum blocks per row in the footer.';

$string['one'] = 'One';
$string['two'] = 'Two';
$string['three'] = 'Three';
$string['four'] = 'Four';

$string['alwaysdisplay'] = 'Always show';
$string['displaybeforelogin'] = 'Show before login only';
$string['displayafterlogin'] = 'Show after login only';
$string['dontdisplay'] = 'Never show';

// Slideshow.
$string['slideshowheading'] = 'Slide show';
$string['slideshowheadingsub'] = 'Dynamic slide show for the front page';
$string['slideshowdesc'] = 'This creates a dynamic slide show of up to sixteen slides for you to promote important elements of your site.  The show is responsive where image height is set according to screen size.  The recommended height is 300px.  The width is set at 100% and therefore the actual height will be smaller if the width is greater than the screen size.  At smaller screen sizes the height is reduced dynamically without the need to provide separate images.  For reference screen width < 767px = height 165px, width between 768px and 979px = height 225px and width > 980px = height 300px.  If no image is selected for a slide, then the default_slide image in the pix folder is used.';

$string['toggleslideshow'] = 'Toggle slide show display';
$string['toggleslideshowdesc'] = 'Choose if you wish to hide or show the slide show.';

$string['numberofslides'] = 'Number of slides';
$string['numberofslides_desc'] = 'Number of slides on the slider.';

$string['hideonphone'] = 'Hide slide show on mobiles';
$string['hideonphonedesc'] = 'Choose if you wish to disable slide show on mobiles.';

$string['hideontablet'] = 'Hide slide show on tablets';
$string['hideontabletdesc'] = 'Choose if you wish to disable the slide show on tablets.';

$string['readmore'] = 'Read more';

$string['slideinterval'] = 'Slide interval';
$string['slideintervaldesc'] = 'Slide transition interval in milliseconds.';

$string['slidecaptiontextcolor'] = 'Slide caption text colour';
$string['slidecaptiontextcolordesc'] = 'What colour the slide caption text should be.';
$string['slidecaptionbackgroundcolor'] = 'Slide caption background colour';
$string['slidecaptionbackgroundcolordesc'] = 'What colour the slide caption background should be.';

$string['slidecaptioncentred'] = 'Slide caption centred';
$string['slidecaptioncentreddesc'] = 'If the slide caption should be centred.';

$string['slidecaptionoptions'] = 'Slide caption options';
$string['slidecaptionoptionsdesc'] = 'Where the captions should appear in relation to the image.';
$string['slidecaptionbeside'] = 'Beside';
$string['slidecaptionontop'] = 'On top';
$string['slidecaptionunderneath'] = 'Underneath';

$string['slidebuttoncolor'] = 'Slide button colour';
$string['slidebuttoncolordesc'] = 'What colour the slide navigation button should be.';
$string['slidebuttonhovercolor'] = 'Slide button hover colour';
$string['slidebuttonhovercolordesc'] = 'What colour the slide navigation button hover should be.';

$string['slideno'] = 'Slide {$a->slide}';
$string['slidenodesc'] = 'Enter the settings for slide {$a->slide}.';
$string['slidetitle'] = 'Slide title';
$string['slidetitledesc'] = 'Enter a descriptive title for your slide';
$string['slideimage'] = 'Slide image';
$string['slideimagedesc'] = 'Image works best if it is transparent.';
$string['slidecaption'] = 'Slide caption';
$string['slidecaptiondesc'] = 'Enter the caption text to use for the slide';
$string['slideurl'] = 'Slide link';
$string['slideurldesc'] = 'Enter the target destination of the slide\'s image link';
$string['slideurltarget'] = 'Link target';
$string['slideurltargetdesc'] = 'Choose how the link should be opened';
$string['slideurltargetself'] = 'Current page';
$string['slideurltargetnew'] = 'New page';
$string['slideurltargetparent'] = 'Parent frame';

// Style guide.
$string['styleguide'] = 'Style guide';
$string['styleguidesub'] = 'Bootstrap V2.3.2 Style guide';
$string['styleguidedesc'] = 'Original documentation code \'{$a->origcodelicenseurl}\' licensed.  Additional code \'{$a->thiscodelicenseurl}\' licensed, which is a \'{$a->compatible}\' license.  Content \'{$a->contentlicenseurl}\' licensed.  The documentation has been formatted for Moodle output with addition of FontAwesome icons where appropriate.  Additional CSS can be found in the file \'shoelace_admin_setting_styleguide.php\' under the comment \'// Beyond docs.css.\'.  The \'{$a->globalsettings}\' section has been removed.';

// Other strings.
$string['pluginname'] = 'Shoelace';

$string['region-side-post'] = 'Right';
$string['region-side-pre'] = 'Left';
$string['region-footer'] = 'Footer';
$string['region-marketing'] = 'Marketing';

// Navbar.
$string['gotobottom'] = 'Go to the bottom of the page';

// Anti-gravity.
$string['antigravity'] = 'Back to top';

// Mustache.
$string['norendertemplatemethod'] = 'Cannot render template, renderer method (\'{$a->callablemethod}\') not found.';
