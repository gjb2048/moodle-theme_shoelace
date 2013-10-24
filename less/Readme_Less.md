Introduction
============
This folder contains the files needed to create the 'moodle.css' and
'editor.css' files in the 'style' folder.  It is useful when you wish to do the
following:

1. Update the CSS based upon the latest changes in the: 'bootstrapbase/less'
   folder.
2. Alter the look of the theme beyond adding CSS in the settings.

Prerequisites
=============
1. You must have 'recess' installed as per the instructions on:
   http://docs.moodle.org/dev/LESS
2. Be at a level where you are comfortable with using the command prompt.
3. All instructions will be relative to the '/theme' folder.

Before making changes
---------------------
1. Ensure you have made a backup of the 'bootstrapbase/less/variables.less'
   file.
2. Ensure you have a backup of both the 'moodle.css' and 'editor.css' files in
   the 'shoelace/style' folder.
3. If you are going to change the values in 'shoelace/less/variables-shoelace.less'
   then a backup of that file too.

Regenerating the styles
=======================
1. If desired, change the values in 'shoelace/less/variables-shoelace.less'.
2. On Windows in a 'Node.js Command prompt' (I need to write a shell script for
   Linux and Mac) ensure you are in the 'shoelace/less' folder.
3. Type 'make_shoe' and observe the output which should be similar to this:

F:\moodledev\moodle25\theme\shoelace\less>make_shoe

F:\moodledev\moodle25\theme\shoelace\less>call copy variables-shoelace.less "../
../bootstrapbase/less/bootstrap/variables.less" /Y
        1 file(s) copied.

F:\moodledev\moodle25\theme\shoelace\less>call cd ../../bootstrapbase/less

F:\moodledev\moodle25\theme\bootstrapbase\less>call recess --compile --compress
../../shoelace/less/moodleallshoelace.less  1>../../shoelace/style/moodle.css

F:\moodledev\moodle25\theme\bootstrapbase\less>call recess --compile --compress
../../shoelace/less/editorallshoelace.less  1>../../shoelace/style/editor.css

F:\moodledev\moodle25\theme\bootstrapbase\less>

4. No errors should be produced.
5. In Moodle perform a 'Purge all caches' -> http://docs.moodle.org/en/Developer_tools
6. Refresh the page and you should see the changes in effect.