Introduction
============
Shoelace theme with a light feel through colour and font selection.

Required version of Moodle
==========================
This version works with Moodle version 2013050200.00 release 2.5beta+ (Build: 20130502) and above until the next release.

NOTE: This is a pre-release Moodle 2.5 Beta version that must NOT be used on production servers.  It is subject to change
at any time without notice.

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
 6. Perform a 'Purge all caches' under 'Home -> Site administration -> Development -> Purge all caches'.
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
24th April 2013 - Version 2.5.0.1 - Beta
  1.  Initial version for Moodle 2.5beta.

29th April 2013 - Version 2.5.0.2 - Beta
  1.  Updated to using 'Bootstrapbase' as a parent theme, thus requiring Moodle version 2013042600.00 release 2.5beta+ (Build: 20130426).
  2.  Updated 'general.php' layout file from new 'Clean' theme that was renamed from 'Simple'.  Appears to have fixed logo not showing issue
  3.  Changed 'config.php' to no longer exclude settings and navigation sheets.  Excluding them means that the naviagation block does not
      render correctly.
  4.  Adapted the css such that there is now a clean white background whilst retaining the sandy colour for the header and other elements such
      as tables.
  5.  Mary Evans now on board as a maintainer and co-developer :).
  6.  Please perform a 'Purge all caches' under 'Home -> Site administration -> Development -> Purge all caches' when upgrading.

4th May 2013 - Version 2.5.0.3 - Beta.
  1.  Added bootstrapbase dependency in 'config.php'.
  2.  Changed colour of form headings from black to blue.
  3.  Added 'Upgrading' instructions and made some improvements to this readme.
  4.  Changed as many core images to blue as possible.
  5.  Please perform a 'Purge all caches' under 'Home -> Site administration -> Development -> Purge all caches' when upgrading.

Thanks
======
My thanks go to all the creators and participants of the Bootstrap theme:
Bas Brands, David Scotson, Stuart Lamour, Mark Aberdour, Paul Hibbitts and Mary Evans.

And again to Mary Evans for the 'Clean' theme.

Me
==
G J Barnard MSc. BSc(Hons)(Sndw). MBCS. CEng. CITP. PGCE. - 4th May 2013.
Moodle profile: http://moodle.org/user/profile.php?id=442195.
Web profile   : http://about.me/gjbarnard
