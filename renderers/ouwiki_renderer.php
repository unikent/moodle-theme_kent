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

require_once($CFG->dirroot . '/mod/ouwiki/renderer.php');

/**
 * Overrides a few defaults.
 *
 * @package     theme_kent
 * @copyright   2016 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_kent_mod_ouwiki_renderer extends mod_ouwiki_renderer
{
    /**
     * Returns html for the content of the links, and a participation string.
     *
     * @return array
     */
    public function ouwiki_get_links_content() {
        $out = parent::ouwiki_get_links_content();
        $out[0] = str_replace('osep-smallbutton', 'btn btn-default', $out[0]);
        return $out;
    }
}
