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
 * Returns variables for LESS.
 *
 * We will inject some LESS variables from the settings that the user has defined
 * for the theme. No need to write some custom LESS for this.
 *
 * @param theme_config $theme The theme config object.
 * @return array of LESS variables without the @.
 */
function theme_kent_less_variables($theme) {
    return array();
}

/**
 * Future theme requires jQuery everywhere.
 */
function theme_kent_page_init(moodle_page $page) {
    global $CFG;

    $page->requires->jquery();
    $page->requires->js('/theme/kent/javascript/chosen.jquery.min.js');
    $page->requires->js_call_amd('theme_kent/notifications', 'init', array());
    $page->requires->js_call_amd('theme_kent/theme', 'init', array());

    $page->requires->css('/theme/kent/style/font-awesome.min.css?rev=' . $CFG->themerev);
    $page->requires->css('/theme/kent/style/kent-header-light.css?rev=' . $CFG->themerev);
    $page->requires->css('/theme/kent/style/chosen.css?rev=' . $CFG->themerev);

    if (\core_useragent::is_ie() && !\core_useragent::check_ie_version('9.0')) {
        $page->requires->css('/theme/kent/style/kent-header-font-ie8.css?rev=' . $CFG->themerev);
    }

    if (isset($CFG->local_tutorials_enabled) && $CFG->local_tutorials_enabled) {
        \local_tutorials\Page::on_load();
    }
}

function theme_kent_grid($hassidepre, $hassidepost) {
    if ($hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-6 col-sm-push-3 col-lg-8 col-lg-push-2');
        $regions['pre'] = 'col-sm-3 col-sm-pull-6 col-lg-2 col-lg-pull-8';
        $regions['post'] = 'col-sm-3 col-lg-2';
    } else if ($hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-sm-9 col-sm-push-3 col-lg-10 col-lg-push-2');
        $regions['pre'] = 'col-sm-3 col-sm-pull-9 col-lg-2 col-lg-pull-10';
        $regions['post'] = 'emtpy';
    } else if (!$hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-9 col-lg-10');
        $regions['pre'] = 'empty';
        $regions['post'] = 'col-sm-3 col-lg-2';
    } else if (!$hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-md-12');
        $regions['pre'] = 'empty';
        $regions['post'] = 'empty';
    }
    if ('rtl' === get_string('thisdirection', 'langconfig')) {
        if ($hassidepre && $hassidepost) {
            $regions['pre'] = 'col-sm-3  col-sm-push-3 col-lg-2 col-lg-push-2';
            $regions['post'] = 'col-sm-3 col-sm-pull-9 col-lg-2 col-lg-pull-10';
        } else if ($hassidepre && !$hassidepost) {
            $regions = array('content' => 'col-sm-9 col-lg-10');
            $regions['pre'] = 'col-sm-3 col-lg-2';
            $regions['post'] = 'empty';
        } else if (!$hassidepre && $hassidepost) {
            $regions = array('content' => 'col-sm-9 col-sm-push-3 col-lg-10 col-lg-push-2');
            $regions['pre'] = 'empty';
            $regions['post'] = 'col-sm-3 col-sm-pull-9 col-lg-2 col-lg-pull-10';
        }
    }
    return $regions;
}

function theme_kent_build_custom_menu() {
    global $CFG;

    $list = '';
    $custommenu = new custom_menu($CFG->custommenuitems, current_language());
    foreach ($custommenu->get_children() as $menunode) {
        if ($menunode->has_children()) {
            $list .= '<li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">';
            $list .= $menunode->get_text();
            $list .= '<span class="caret"></span></a>';
            $list .= '<ul class="dropdown-menu">';
            foreach ($menunode->get_children() as $childnode) {
                $link = html_writer::link(
                    $childnode->get_url(),
                    $childnode->get_text(),
                    array('title' => $childnode->get_title())
                );
                $list .= '<li role="presentation">' . $link . '</li>';
            }
            $list .= '</ul>';
            $list .= '</li>';

        } else {
            $link = html_writer::link(
                $menunode->get_url(),
                $menunode->get_text(),
                array('title' => $menunode->get_title())
            );
            $list .= '<li role="presentation">' . $link . '</li>';
        }
    }

    return $list;
}
