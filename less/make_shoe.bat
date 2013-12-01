call copy variables-shoelace.less "../../bootstrapbase/less/bootstrap/variables.less" /Y
call cd ../../bootstrapbase/less
call recess --compile --compress ../../shoelace/less/moodleallshoelace.less > ../../shoelace/style/moodle.css
call recess --compile --compress ../../shoelace/less/editorallshoelace.less > ../../shoelace/style/editor.css
call cd ../../shoelace/less

call copy variables-shoelace-en_ar.less "../../bootstrapbase/less/bootstrap/variables.less" /Y
call cd ../../bootstrapbase/less
call recess --compile --compress ../../shoelace/less/moodleallshoelace.less > ../../shoelace/style/moodle-en_ar.css
call recess --compile --compress ../../shoelace/less/editorallshoelace.less > ../../shoelace/style/editor-en_ar.css
call cd ../../shoelace/less
