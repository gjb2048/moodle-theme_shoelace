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

M.theme_shoelace = {
    blocks: null,
    content: null,
    Y: null
}

M.theme_shoelace.init = function(Y) {
    "use strict";
    this.Y = Y;
    //M.theme_shoelace.blocks = Y.one('#shoelace-blocks');
    M.theme_shoelace.blocks = Y.one('#block-region-side-pre');
    if (M.theme_shoelace.blocks) {
        M.theme_shoelace.content = Y.one('#region-main-shoelace');
        M.theme_shoelace.compress_blocks();
        M.theme_shoelace.blocks.on('mouseenter', M.theme_shoelace.blocks_enter);
        M.theme_shoelace.blocks.on('mouseleave', M.theme_shoelace.blocks_leave);
    }
};

M.theme_shoelace.compress_blocks = function() {
    M.theme_shoelace.blocks.replaceClass('span3', 'span1');
    M.theme_shoelace.blocks.addClass('shoelace-closed');
    if (M.theme_shoelace.content) {
        M.theme_shoelace.content.replaceClass('span8', 'span11');
    }
    var titles = M.theme_shoelace.blocks.all('.header h2');
    if (titles) {
        titles.each(function(node) {
            node.get('parentNode').replaceChild(M.theme_shoelace.fixTitleOrientation(node, node.get('text')), node);
        });
    }
};

M.theme_shoelace.blocks_enter = function(e) {
    "use strict";
    e.preventDefault();
    M.theme_shoelace.blocks.replaceClass('span1', 'span3');
    M.theme_shoelace.blocks.removeClass('shoelace-closed');
    if (M.theme_shoelace.content) {
        M.theme_shoelace.content.replaceClass('span11', 'span8');
    }
};

M.theme_shoelace.blocks_leave = function(e) {
    "use strict";
    e.preventDefault();
    M.theme_shoelace.compress_blocks();
};

// Modified from /blocks/dock.js
M.theme_shoelace.fixTitleOrientation = function(title, text) {
    var Y = this.Y;

    var title = Y.one(title);

    if (Y.UA.ie > 0 && Y.UA.ie < 8) {
        // IE 6/7 can't rotate text so force ver
        M.str.langconfig.thisdirectionvertical = 'ver';
    }

    var clockwise = false;
    switch (M.str.langconfig.thisdirectionvertical) {
        case 'ver':
            // Stacked is easy
            return title.setContent(text.split('').join('<br />'));
        case 'ttb':
            clockwise = true;
            break;
        case 'btt':
            clockwise = false;
            break;
    }

    if (Y.UA.ie == 8) {
        // IE8 can flip the text via CSS but not handle transform. IE9+ can handle the CSS3 transform attribute.
        title.setContent(text);
        title.setAttribute('style', 'writing-mode: tb-rl; filter: flipV flipH;display:inline;');
        title.addClass('filterrotate');
        return title;
    }

    // We need to fix a font-size - sorry theme designers.
    var fontsize = '11px';
    var transform = (clockwise) ? 'rotate(45deg)' : 'rotate(-45deg)';
    var test = Y.Node.create('<h2><span class="transform-test-node" style="font-size:'+fontsize+';">'+text+'</span></h2>');
    title.insert(test, 0);
    var width = test.one('span').get('offsetWidth') * 1.2;
    var height = test.one('span').get('offsetHeight');
    test.remove();

    title.setContent(text);
    title.addClass('css3transform');

    // Move the title into position
    title.setStyles({
        'margin' : '0',
        'padding' : '0',
        'position' : 'relative',
        'fontSize' : fontsize,
        'width' : width,
        'top' : width/2
    });

    // Positioning is different when in RTL mode.
    if (right_to_left()) {
        title.setStyle('left', width/2 - height);
    } else {
        title.setStyle('right', width/2 - height);
    }

    // Rotate the text
    title.setStyles({
        'transform' : transform,
        '-ms-transform' : transform,
        '-moz-transform' : transform,
        '-webkit-transform' : transform,
        '-o-transform' : transform
    });

    var container = Y.Node.create('<div></div>');
    container.append(title);
    container.setStyle('height', width + (width / 4));
    container.setStyle('position', 'relative');
    return container;
};

YUI().use('node', 'event', function(Y) {
    console.log(M);
    if (!M.cfg.isediting) {
        M.theme_shoelace.init(Y);
    }
});