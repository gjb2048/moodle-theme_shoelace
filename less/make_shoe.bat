call copy variables-shoelace.less "../../bootstrapbase/less/bootstrap/variables.less" /Y
call cd ../../bootstrapbase/less
call recess --compile --compress ../../shoelace/less/moodleallshoelace.less > ../../shoelace/style/moodle.css
call recess --compile --compress ../../shoelace/less/editorallshoelace.less > ../../shoelace/style/editor.css