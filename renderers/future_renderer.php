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
 * Overrides a few defaults.
 *
 * @package     theme_kent
 * @copyright   2015 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_kent_core_renderer extends theme_kent_core_renderer_base
{
    /*
     * This renders the bootstrap top menu.
     *
     * This renderer is needed to enable the Bootstrap style navigation.
     */
    protected function render_custom_menu(custom_menu $menu) {
        global $CFG, $OUTPUT;

        $content = <<<HTML5
        <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{$CFG->wwwroot}"><i class="fa fa-home"></i></a>
            </div>
            <div id="main-menu-collapse" class="collapse navbar-collapse">
HTML5;

        // Other icons.
        if ($menu->has_children()) {
            $content .= '<ul class="nav navbar-nav">';
            foreach ($menu->get_children() as $item) {
                $content .= $this->render_custom_menu_item($item, 1);
            }
            $content .= '</ul>';
        }

        // Search box.
        $searchbox = $OUTPUT->search_box();
        $content .= <<<HTML5
        <div class="nav navbar-nav navbar-right">
            $searchbox
        </div>
HTML5;

        return $content.'</div></div></nav>';
    }

    /*
     * This renders the navbar.
     * Uses bootstrap compatible html.
     */
    public function navbar() {
        global $OUTPUT;

        $out  = '<div id="breadcrumbswrap" class="navbar row">';
        $out .= '<div class="col-md-8">';
        $out .= parent::navbar();
        $out .= '</div>';
        $out .= '<div class="col-md-4">';
        $out .= $OUTPUT->page_heading_button();
        $out .= '</div>';
        $out .= '</div>';

        return $out;
    }
}
