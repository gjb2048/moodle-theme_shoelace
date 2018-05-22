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
 * @author     G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}
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
<br>Sponsorships may allow me to provide you with more or better features in less time.</p>
<h3>Report a bug:</h3>
<p><a href="https://github.com/gjb2048/moodle-theme_shoelace/issues">github.com/gjb2048/moodle-theme_shoelace/issues</a></p>
<h3>More information</h3>
<p><a href="shoelace/Readme.md">How to use this theme.</a></p>
</div></div>';

$string['configtitle'] = 'Shoelace';

$string['generalheading'] = 'General';
$string['generalheadingsub'] = 'General settings';
$string['generalheadingdesc'] = 'Configure the general settings for Shoelace here.';

$string['customcss'] = 'Custom CSS';
$string['customcssdesc'] = 'Whatever CSS rules you add to this textarea will be reflected in every page, making for easier customization of this theme.';

$string['one'] = 'One';
$string['two'] = 'Two';
$string['three'] = 'Three';
$string['four'] = 'Four';

$string['alwaysdisplay'] = 'Always show';
$string['displaybeforelogin'] = 'Show before login only';
$string['displayafterlogin'] = 'Show after login only';
$string['dontdisplay'] = 'Never show';

// Features.
$string['featureheading'] = 'Features';
$string['featureheadingsub'] = 'Feature settings';
$string['featureheadingdesc'] = 'Configure the feature settings for Shoelace here.';

$string['nummiddleblocks'] = 'Maximum number of blocks per row in the middle area';
$string['nummiddleblocksdesc'] = 'The maximum blocks per row in the middle area.';

// Layout.
$string['layoutheading'] = 'Layout';
$string['layoutsub'] = 'Layout settings';
$string['layoutdesc'] = 'Set the layouts for the theme.';
$string['layoutsetting'] = '{$a->layout} layout';
$string['layoutsettingdesc'] = 'Choose the layout of the \'{$a->layout}\' layout.';
$string['columns1layout'] = 'One column';
$string['columns2llayout'] = 'Two column left';
$string['columns2rlayout'] = 'Two column right';
$string['columns3layout'] = 'Three column';
$string['columns3middlelayout'] = 'Three columns with a middle';

// Look and feel.
$string['lookandfeelheading'] = 'Look and feel';
$string['lookandfeelsub'] = 'Look and feel settings';
$string['lookandfeeldesc'] = 'Set the colours for the theme.';

$string['themecolour'] = 'Theme colour';
$string['themecolourdesc'] = 'Set the colour for the theme.';

$string['themetextcolour'] = 'Theme text colour';
$string['themetextcolourdesc'] = 'Set the colour for the text when used with the theme colour.';

$string['backgroundcolour'] = 'Background colour';
$string['backgroundcolourdesc'] = 'Set the background colour around the page.';

$string['backgroundimage'] = 'Background image';
$string['backgroundimagedesc'] = 'Set the background image around the page.';

$string['backgroundimagestyle'] = 'Background image style';
$string['backgroundimagestyledesc'] = 'Select the style for the background image.  You may need to change the text and page colours to suit when \'Seamless\' is set.';
$string['stylefixed'] = 'Fixed';
$string['styletiled'] = 'Tiled';
$string['stylestretch'] = 'Stretch';

$string['backgroundtextcolour'] = 'Background text colour';
$string['backgroundtextcolourdesc'] = 'Set the colour for the background text around the page.';

$string['seamless'] = 'Seamless';
$string['seamlessdesc'] = 'Ignore all background settings and use page / text colours along with removing borders / shadows where needed.  Turn on for a clearer look.  If a \'backgroundimage\' is added then transparency will be used as appropriate.';

$string['pagecolour'] = 'Page colour';
$string['pagecolourdesc'] = 'Set the colour for the page.  This is used on modals and dropdowns, so when using a background image with \'Seamless\' set, set this to be compatible with the text colour.';

$string['textcolour'] = 'Text colour';
$string['textcolourdesc'] = 'Set the colour for the text on the page.';

$string['iconcoloursetting'] = 'Use icon colour setting';
$string['iconcoloursetting_desc'] = 'Use the icon colour setting for the icons.  The icon colour functionality is new.  If you experience problems with it, then turn it off and run \'grunt svg\' on the Node.js command prompt.  Please see \'Gruntfile.js\' for full details.';

$string['iconcolour'] = 'Icon colour';
$string['iconcolour_desc'] = 'The colour for the icons.';

$string['logo'] = 'Logo';
$string['logodesc'] = 'Please upload your custom logo here if you want to add it to the header.<br>Set the height of the logo with the \'logoheight\' setting.';

$string['logoheight'] = 'Logo height';
$string['logoheightdesc'] = 'Logo height between {$a->lower} and {$a->upper} pixels.';

// Font settings.
$string['fontsettings'] = 'Font';
$string['fontheadingsub'] = 'Font settings';
$string['fontheadingdesc'] = 'Select and enter the fonts that you want to use in your Moodle environment.';
$string['fontbasesize'] = 'Font base size';
$string['fontbasesizedesc'] = 'Some fonts appear too small at the default size of 14px, use this setting to set the base font size between {$a->lower} and {$a->upper} pixels.  The base line height will be automatically six pixels greater than this.';
$string['fontselect'] = 'Font type selector';
$string['fontselectdesc'] = 'Choose from the list of available font defining mechanisms:<ul><li>\'Theme fonts\' are where the font is already installed with the theme.</li><li>\'CDN theme fonts\' are where the fonts specified by the theme are delivered over CDN (Content delivery network).  If you use CDN fonts then investigate their respective privacy policies - look in templates/#cdnfonts.mustache.</li><li>\'Custom fonts\' are where you specify the name and upload the font files for the font.  Notes: <ul><li>Not specifying a font name will cause the theme font to be used.</li><li>If both the heading and body fonts are the same then specify the name twice but only upload the font file (of each type you have) to either the heading or body section.</li></ul></li></ul>Please save to show the options for your choice.';
$string['fonttypetheme'] = 'Theme fonts';
$string['fonttypethemecdn'] = 'CDN theme fonts';
$string['fonttypecustom'] = 'Custom fonts';
$string['fontnameheading'] = 'Heading font';
$string['fontnameheadingdesc'] = 'Enter the exact name of the font to use for headings.';
$string['fontnamebody'] = 'Text font';
$string['fontnamebodydesc'] = 'Enter the exact name of the font to use for all other text.';

// Font files.
$string['fontfiles'] = 'Font files';
$string['fontfilesdesc'] = 'Upload your font files here.';
$string['fontfilettfheading'] = 'Heading TTF font file';
$string['fontfileotfheading'] = 'Heading OTF font file';
$string['fontfilewoffheading'] = 'Heading WOFF font file';
$string['fontfilewofftwoheading'] = 'Heading WOFF2 font file';
$string['fontfileeotheading'] = 'Heading EOT font file';
$string['fontfilesvgheading'] = 'Heading SVG font file';
$string['fontfilettfbody'] = 'Body TTF font file';
$string['fontfileotfbody'] = 'Body OTF font file';
$string['fontfilewoffbody'] = 'Body WOFF font file';
$string['fontfilewofftwobody'] = 'Body WOFF2 font file';
$string['fontfileeotbody'] = 'Body EOT font file';
$string['fontfilesvgbody'] = 'Body SVG font file';

// Frontpage.
$string['frontpageheading'] = 'Frontpage';
$string['frontpagesub'] = 'Frontpage settings';
$string['frontpagedesc'] = 'Set the frontpage settings.';

$string['frontpagelayout'] = 'Frontpage layout';
$string['frontpagelayoutdesc'] = 'Layout of the frontpage.';

$string['nummarketingblocks'] = 'Maximum number of blocks per row in the frontpage marketing (middle) area';
$string['nummarketingblocksdesc'] = 'The maximum blocks per row in the frontpage marketing (middle) area.';

$string['slideshowmarketingpos'] = 'Slide show and marketing blocks position';
$string['slideshowmarketingposdesc'] = 'Set the position of the slide show and marketing blocks.';
$string['slideshowabovemarketingpos'] = 'Slide show above the marketing blocks';
$string['slideshowbelowmarketingpos'] = 'Slide show below the marketing blocks';

// Navbar.
$string['navbarheading'] = 'Navbar';
$string['navbarsub'] = 'Navbar settings';
$string['navbardesc'] = 'Set the navbar settings.';

$string['invert'] = 'Invert navbar';
$string['invertdesc'] = 'Inverts text and theme colour for the navbar at the top of the page.';

$string['navbarscroll'] = 'Show / hide the navbar on scroll';
$string['navbarscrolldesc'] = 'Scroll down to hide the navbar, scroll up more than {$a->upamount} pixels in a single gesture or get near the top to show the navbar.';

$string['navbarscrollupamount'] = 'Navbar scroll up amount';
$string['navbarscrollupamountdesc'] = 'Amount of up scrolling before the navbar will show when \'navbarscroll\' is \'Yes\', between {$a->lower} and {$a->upper} pixels.';

// Footer.
$string['footerheading'] = 'Footer';
$string['footersub'] = 'Footer settings';
$string['footerdesc'] = 'Set the footer settings.';

$string['numfooterblocks'] = 'Maximum number of blocks per row in the footer';
$string['numfooterblocksdesc'] = 'The maximum blocks per row in the footer.';

$string['footnote'] = 'Footnote';
$string['footnotedesc'] = 'Whatever you add to this textarea will be displayed in the footer throughout your Moodle site.';

// Slideshow.
$string['frontpageslideshowheading'] = 'Frontpage slide show';
$string['frontpageslideshowheadingsub'] = 'Dynamic slide show for the front page';
$string['frontpageslideshowdesc'] = 'This creates a dynamic slide show of up to sixteen slides for you to promote important elements of your site.  The show is responsive where image height is set according to screen size.  The recommended height is 300px.  The width is set at 100% and therefore the actual height will be smaller if the width is greater than the screen size.  At smaller screen sizes the height is reduced dynamically without the need to provide separate images.  For reference screen width < 767px = height 165px, width between 768px and 979px = height 225px and width > 980px = height 300px.  If no image is selected for a slide, then the default_slide image in the pix folder is used.';

$string['toggleslideshow'] = 'Toggle slide show display';
$string['toggleslideshowdesc'] = 'Choose if you wish to hide or show the slide show.';

$string['numberofslides'] = 'Number of slides';
$string['numberofslidesdesc'] = 'Number of slides on the slider.';

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
$string['region-middle'] = 'Middle';

// Navbar.
$string['gotobottom'] = 'Go to the bottom of the page';

// Anti-gravity.
$string['antigravity'] = 'Back to top';

// Mustache.
$string['norendertemplatemethod'] = 'Cannot render template, renderer method (\'{$a->callablemethod}\') not found.';

// Syntax highlighter.
$string['syntaxhighlight'] = 'Activate syntax highlighting';
$string['syntaxhighlight_desc'] = 'Activate syntax highlighting in courses.  When \'Yes\' you will be able to select the desired categories with the \'syntaxhighlightcat\' setting.';
$string['syntaxhighlightpage'] = 'Syntax highlighting help';
$string['syntaxhelpone'] = 'When editing anything (such as a label) with the text editor surround your code with a \'pre\' tag and add the class="brush: alias" where \'alias\' is one of the following:';
$string['syntaxhelptwo'] = 'Brush name';
$string['syntaxhelpthree'] = 'Brush alias';
$string['syntaxhelpfour'] = 'For example:';
$string['syntaxhelpfive'] = 'becomes:';
$string['syntaxhelpsix'] = 'If you cannot see this help on a course then ask the administrator to activate \'Syntax highlighting\' for the courses\' category.';
$string['syntaxhelpseven'] = 'More information on';
$string['syntaxhighlightcat'] = 'Syntax highlighting course categories';
$string['syntaxhighlightcatdesc'] = 'Syntax highlighting in courses within the selected categories.  A help button that brings up a popup will be added to the footer of courses within the selected categories for course editors when editing.';

// File shoelace_admin_setting_configinteger.php.
$string['asconfigintlower'] = '{$a->value} is less than the lower range limit of {$a->lower}';
$string['asconfigintupper'] = '{$a->value} is greater than the upper range limit of {$a->upper}';
$string['asconfigintnan'] = '{$a->value} is not a number';

// Privacy.
$string['privacy:nop'] = 'The Shoelace theme stores lots of settings that pertain to its configuration.  None of the settings are related to a specific user.  It is your responsibilty to ensure that no user data is entered in any of the free text fields.  Setting a setting will result in that action being logged within the core Moodle logging system against the user whom changed it, this is outside of the themes control, please see the core logging system for privacy compliance for this.  When uploading images, you should avoid uploading images with embedded location data (EXIF GPS) included or other such personal data.  It would be possible to extract any location / personal data from the images.  If you use CDN fonts then investigate their respective privacy policies - look in templates/#cdnfonts.mustache.  Please examine the code carefully to be sure that it complies with your interpretation of your privacy laws.  I am not a lawyer and my analysis is based on my interpretation.  If you have any doubt then remove the theme forthwith.';
