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

M.theme_shoelace = M.theme_shoelace || {};

M.theme_shoelace.blocks;
M.theme_shoelace.content;

M.theme_shoelace.init = function(Y) {
    "use strict";
    M.theme_shoelace.blocks = Y.one('#shoelace-blocks');
    if (M.theme_shoelace.blocks) {
        M.theme_shoelace.blocks.replaceClass('span3', 'span1');
        M.theme_shoelace.blocks.addClass('shoelace-closed');
        M.theme_shoelace.content = Y.one('#region-main');
        if (M.theme_shoelace.content) {
            M.theme_shoelace.content.replaceClass('span9', 'span11');
        }
        M.theme_shoelace.blocks.on('mouseenter', M.theme_shoelace.blocks_enter);
        M.theme_shoelace.blocks.on('mouseleave', M.theme_shoelace.blocks_leave);
    }
};

M.theme_shoelace.blocks_enter = function(e) {
    "use strict";
    e.preventDefault();
    M.theme_shoelace.blocks.replaceClass('span1', 'span3');
    M.theme_shoelace.blocks.removeClass('shoelace-closed');
    if (M.theme_shoelace.content) {
        M.theme_shoelace.content.replaceClass('span11', 'span9');
    }
};

M.theme_shoelace.blocks_leave = function(e) {
    "use strict";
    e.preventDefault();
    M.theme_shoelace.blocks.replaceClass('span3', 'span1');
    M.theme_shoelace.blocks.addClass('shoelace-closed');
    if (M.theme_shoelace.content) {
        M.theme_shoelace.content.replaceClass('span9', 'span11');
    }
};

YUI().use('node', 'event', M.theme_shoelace.init);