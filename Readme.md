Introduction
============
Shoelace theme with a light feel through colour and font selection.

Required version of Moodle
==========================
This version works with Moodle version 2013111800 release 2.6 (Build: 20131118) and above within the 2.6 branch until the
next release.

Please ensure that your hardware and software complies with 'Requirements' in 'Installing Moodle' on
'docs.moodle.org/26/en/Installing_Moodle'.

Installation
============
 1. Ensure you have the version of Moodle as stated above in 'Required version of Moodle'.  This is essential as the
    theme relies on underlying core code that is out of my control.
 2. Login as an administrator and put Moodle in 'Maintenance Mode' so that there are no users using it bar you as the administrator.
 3. Copy the extracted 'shoelace' folder to the '/theme/' folder.
 4. Go to 'Site administration' -> 'Notifications' and follow standard the 'plugin' update notification.
 5. Select as the theme for the site.
 6. Put Moodle out of Maintenance Mode.

Upgrading
=========
 1. Ensure you have the version of Moodle as stated above in 'Required version of Moodle'.  This is essential as the
    theme relies on underlying core code that is out of my control.
 2. Login as an administrator and put Moodle in 'Maintenance Mode' so that there are no users using it bar you as the administrator.
 3. Make a backup of your old 'shoelace' folder in '/theme/' and then delete the folder.
 4. Copy the replacement extracted 'shoelace' folder to the '/theme/' folder.
 5. Go to 'Site administration' -> 'Notifications' and follow standard the 'plugin' update notification.
 6. If automatic 'Purge all caches' appears not to work by lack of display etc. then perform a manual 'Purge all caches'
   under 'Home -> Site administration -> Development -> Purge all caches'.
 7. Put Moodle out of Maintenance Mode.

Uninstallation
==============
 1. Put Moodle in 'Maintenance Mode' so that there are no users using it bar you as the administrator.
 2. Change the theme to another theme of your choice.
 3. In '/theme/' remove the folder 'shoelace'.
 4. Put Moodle out of Maintenance Mode.

Reporting Issues
================
Before reporting an issue, please ensure that you are running the latest version for your release of Moodle.  It is essential
that you are operating the required version of Moodle as stated at the top - this is because the theme relies on core
functionality that is out of its control.

I operate a policy that I will fix all genuine issues for free.  Improvements are at my discretion.  I am happy to make bespoke
customisations / improvements for a negotiated fee. 

When reporting an issue you can post in the theme's forum on Moodle.org (currently 'moodle.org/mod/forum/view.php?id=46')
or contact me direct (details at the bottom).

It is essential that you provide as much information as possible, the critical information being the contents of the format's 
version.php file.  Other version information such as specific Moodle version, theme name and version also helps.  A screen shot
can be really useful in visualising the issue along with any files you consider to be relevant.

Version Information
===================
2nd January 2014 - Version 2.6.1 - Stable.
  1.  Implemented MDL-43348.
  2.  Recompiled LESS as a result of MDL-41788 and MDL-43062.
  3.  Updated screen shot to reflect updates.

30th November 2013 Version 2.6.0.3
  1.  Added ability to choose between local and CDN sources for fonts.  This means that I had to change Quicksand for Cabin
      as quite frankly the former looked awful when coming from CDN.  This was because I had used it as a content font but
      the variety available on CDN was limited and switching it around as the header with Varela Round did not look good
      either.  Thanks to Julian Ridden for showing the way with this.

29th November 2013 Version 2.6.0.2
  1.  Added popup layout from bootstrapbase.
  2.  Removed excluded grade sheet.
  3.  Updated to use M2.6 font serving mechanism.

15th November 2013 Version 2.6.0.1
  1.  Initial BETA code for Moodle 2.6.

6th November 2013 Version 2.5.3 - Stable.
  1.  Fixed footer blocks showing up where they should not on single column pages.
  2.  Updated styles.

24th October 2013 Version 2.5.3 - BETA
  1.  Added footer blocks with a setting to set the maximum number of blocks per 'row' between 1 and 4.
  2.  Added the 'less' folder containing the files required to alter / recompile the css.  Instructions
      in the 'less/Readme_less.md' file.

16th August 2013 Version 2.5.2.2.
  1.  Implemented MDL-36011.
  2.  Adjusted table cell widths - https://moodle.org/mod/forum/discuss.php?d=234329.
  3.  Implemented $CFG->themedir safe font serving.
  4.  Improvements to grade book styling thanks to Julian Ridden.

29th July 2013 Version 2.5.2.1 - Maintenance release.
  1.  Implemented MDL-39812, MDL-39299, MDL-39748, MDL-40082, MDL-40071, MDL-40189, MDL-40589 and MDL-40544.
  2.  Added new font 'Varela Round' for headings so that they are separated from the main text.
  3.  Block headings are no longer all upper case as this looks silly.
  4.  Blocks use the warning background and border scheme so that they do not dominate the page.
  5.  Tidied up form buttons on screen sizes less than 480px.

29th June 2013 Version 2.5.2.
  1.  Updated to changes implemented by MDL-39824 and proposed by MDL-40065 but in a way that they are local to Shoelace and
      therefore should not require an update to core M2.5.
  2.  Updated styles to current fixes.
  3.  Added 'icon.png' to show when updating.
  4.  Implemented MDL-40137 to fix method names in 'lib.php'.
  5.  Fixes for RTL.
  6.  Changes to course CSS using Mary Evan's Afterburner code as documented on: https://moodle.org/mod/forum/discuss.php?d=230919.
  7.  Use chevron icons for the breadcrumb divider.  Correct direction used in both LTR and RTL.
  8.  Use 'pills' instead of 'tabs' for 'tabtree's -> http://twitter.github.io/bootstrap/components.html#navs.

6th June 2013 Version 2.5.1.2
  1.  Adjusted layout such that both pre and post blocks appear on the left for left to right languages and on the right
      for right to left languages.
  2.  Added paper effect.
  3.  Tidied up some small font / background issues.

31st May 2013 Version 2.5.1.1
  1.  Tweaked css for course search box on the course category page.
  2.  Updated layouts from core.
  3.  Adjusted custom css setting so that when it changes its effects are applied immediately.
  4.  Fixed inverse setting.
  5.  Fixed no purge when setting footnote.
  6.  Reversed this version information list to make the latest updates easier to find.

15th May 2013 Version 2.5.1 - Stable
  1.  First stable version for Moodle 2.5 stable.
  2.  Updated 'general.php' file from 'bootstrapbase'.

13th May 2013 - Version 2.5.0.5 - Beta.
  1.  Removed language menu as appears to now rendering from Bootstrap Base.
  2.  Made configuration of maintenance template like other standard themes.
  3.  Updated moodle.css in line with updates in Bootstrap Base.
  4.  Made font easier to change.

8th May 2013 - Version 2.5.0.4 - Beta.
  1.  Added and adapted image from flexible sections course format.
  2.  Added and adapted missing move here image from core.
  3.  Added display of language menu when required.
  4.  Added automatic 'Purge all caches' when upgrading.  If this appears not to work by lack of display etc. then perform a
      manual 'Purge all caches' under 'Home -> Site administration -> Development -> Purge all caches'.

4th May 2013 - Version 2.5.0.3 - Beta.
  1.  Added bootstrapbase dependency in 'config.php'.
  2.  Changed colour of form headings from black to blue.
  3.  Added 'Upgrading' instructions and made some improvements to this readme.
  4.  Changed as many core images to blue as possible.
  5.  Fixed font path issue when Moodle is in a sub-folder.
  6.  Please perform a 'Purge all caches' under 'Home -> Site administration -> Development -> Purge all caches' when upgrading.

29th April 2013 - Version 2.5.0.2 - Beta
  1.  Updated to using 'Bootstrapbase' as a parent theme, thus requiring Moodle version 2013042600.00 release 2.5beta+ (Build: 20130426).
  2.  Updated 'general.php' layout file from new 'Clean' theme that was renamed from 'Simple'.  Appears to have fixed logo not showing issue
  3.  Changed 'config.php' to no longer exclude settings and navigation sheets.  Excluding them means that the naviagation block does not
      render correctly.
  4.  Adapted the css such that there is now a clean white background whilst retaining the sandy colour for the header and other elements such
      as tables.
  5.  Mary Evans now on board as a maintainer and co-developer :).
  6.  Please perform a 'Purge all caches' under 'Home -> Site administration -> Development -> Purge all caches' when upgrading.

24th April 2013 - Version 2.5.0.1 - Beta
  1.  Initial version for Moodle 2.5beta.

Thanks
======
My thanks go to all the creators and participants of the Bootstrap theme:
Bas Brands, David Scotson, Stuart Lamour, Mark Aberdour, Paul Hibbitts and Mary Evans.

And again to Mary Evans for the 'Clean' theme.

Me
==
G J Barnard MSc. BSc(Hons)(Sndw). MBCS. CEng. CITP. PGCE.
Moodle profile: http://moodle.org/user/profile.php?id=442195.
Web profile   : http://about.me/gjbarnard
