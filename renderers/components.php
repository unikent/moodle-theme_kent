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
 * Data structure representing an icon.
 */
class fa_icon implements \renderable, \templatable
{
    /**
     * @var array An array of attributes to use on the icon
     */
    public $attributes = array();

    /**
     * Constructor
     *
     * @param string $class fa-airplane?
     * @param string $alt The alt text to use for the icon
     * @param array $attributes html attributes
     */
    public function __construct($class, $alt = '', array $attributes = null) {
        $this->attributes = (array)$attributes;
        $this->attributes['alt'] = $alt;
        $this->attributes['class'] = $class;

        if (!isset($this->attributes['title'])) {
            $this->attributes['title'] = $this->attributes['alt'];
        } else if (empty($this->attributes['title'])) {
            // Remove the title attribute if empty, we probably want to use the parent node's title
            // and some browsers might overwrite it with an empty title.
            unset($this->attributes['title']);
        }
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output Used to do a final render of any components that need to be rendered for export.
     * @return array
     */
    public function export_for_template(\renderer_base $output) {
        $templatecontext = array();
        foreach ($this->attributes as $name => $value) {
            $templatecontext[] = array('name' => $name, 'value' => $value);
        }

        return array('attributes' => $templatecontext);
    }
}