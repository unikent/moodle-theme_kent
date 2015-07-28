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
class theme_kent_core_renderer extends core_renderer
{
    use theme_kent_bootstrap_notifications;

    private $_tabdepth;
    private $_in_usermenu;

    /*
     * This renders the navbar.
     * Uses bootstrap compatible html.
     */
    public function navbar() {
        $items = $this->page->navbar->get_items();
        if (empty($items)) {
            return '';
        }
        $breadcrumbs = array();
        foreach ($items as $item) {
            $item->hideicon = true;
            $breadcrumbs[] = $this->render($item);
        }
        $list_items = '<li>'.join("</li><li>", $breadcrumbs).'</li>';
        $title = '<span class="accesshide">'.get_string('pagepath').'</span>';
        return $title . "<ul class=\"breadcrumb\">$list_items</ul>";
    }

    /**
     * Construct a user menu, returning HTML that can be echoed out by a
     * layout file.
     *
     * @param stdClass $user A user object, usually $USER.
     * @param bool $withlinks true if a dropdown should be built.
     * @return string HTML fragment.
     */
    public function user_menu($user = null, $withlinks = null) {
        $this->_in_usermenu = true;
        $result = parent::user_menu($user, $withlinks);
        $this->_in_usermenu = false;

        return $result;
    }

    /**
     * Internal implementation of user image rendering.
     *
     * @param user_picture $userpicture
     * @return string
     */
    protected function render_user_picture(user_picture $userpicture) {
        if ($this->_in_usermenu) {
            $userpicture->size = 50;
        }

        return parent::render_user_picture($userpicture);
    }

    /**
     * Renders tabtree
     *
     * @param tabtree $tabtree
     * @return string
     */
    protected function render_tabtree(tabtree $tabtree) {
        if (empty($tabtree->subtree)) {
            return '';
        }

        if (!isset($this->_tabdepth)) {
            $this->_tabdepth = 0;
        }

        $firstrow = $secondrow = '';
        foreach ($tabtree->subtree as $tab) {
            $firstrow .= $this->render($tab);
            if (($tab->selected || $tab->activated) && !empty($tab->subtree) && $tab->subtree !== array()) {
                $this->_tabdepth++;
                $secondrow = $this->tabtree($tab->subtree);
                $this->_tabdepth--;
            }
        }
        
        $classes = array('nav', 'nav-tabs', 'nav-tabs-' . $this->_tabdepth);
        if ($this->_tabdepth == 0) {
            $classes[] = 'nav-tabs-first';
        }
        if ($this->_tabdepth > 0 && empty($secondrow)) {
            $classes[] = 'nav-tabs-last';
        }

        $tabs = html_writer::tag('ul', $firstrow, array('class' => implode(' ', $classes))) . $secondrow;

        if ($this->_tabdepth == 0) {
            $tabs = html_writer::tag('div', $tabs, array('class' => 'nav-tabset'));
        }

        return $tabs;
    }

    /**
     * Renders tabobject (part of tabtree)
     *
     * This function is called from {@link core_renderer::render_tabtree()}
     * and also it calls itself when printing the $tabobject subtree recursively.
     *
     * @param tabobject $tabobject
     * @return string HTML fragment
     */
    protected function render_tabobject(tabobject $tab) {
        if (($tab->selected and (!$tab->linkedwhenselected)) or $tab->activated) {
            return html_writer::tag('li', html_writer::tag('a', $tab->text), array('class' => 'active'));
        } else if ($tab->inactive) {
            return html_writer::tag('li', html_writer::tag('a', $tab->text), array('class' => 'disabled'));
        } else {
            if (!($tab->link instanceof moodle_url)) {
                // backward compartibility when link was passed as quoted string
                $link = "<a href=\"$tab->link\" title=\"$tab->title\">$tab->text</a>";
            } else {
                $link = html_writer::link($tab->link, $tab->text, array('title' => $tab->title));
            }
            $params = $tab->selected ? array('class' => 'active') : null;
            return html_writer::tag('li', $link, $params);
        }
    }

    /*
     * Overriding the custom_menu function ensures the custom menu is
     * always shown, even if no menu items are configured in the global
     * theme settings page.
     */
    public function custom_menu($custommenuitems = '') {
        global $CFG;

        if (empty($custommenuitems) && !empty($CFG->custommenuitems)) {
            $custommenuitems = $CFG->custommenuitems;
        }
        $custommenu = new custom_menu($custommenuitems, current_language());
        return $this->render_custom_menu($custommenu);
    }

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

        // Edit icon.
        $editbutton = $OUTPUT->page_heading_button();
        $content .= <<<HTML5
        <ul class="nav navbar-nav navbar-right">
            $editbutton
        </ul>
HTML5;

        return $content.'</div></div></nav>';
    }

    /*
     * This code renders the custom menu items for the
     * bootstrap dropdown menu.
     */
    protected function render_custom_menu_item(custom_menu_item $menunode, $level = 0) {
        static $submenucount = 0;

        $content = '';
        if ($menunode->has_children()) {
            if ($level == 1) {
                $class = 'dropdown';
            } else {
                $class = 'dropdown-submenu';
            }

            $content = html_writer::start_tag('li', array(
                'class' => $class
            ));

            // If the child has menus render it as a sub menu.
            $submenucount++;
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#cm_submenu_'.$submenucount;
            }

            $content .= html_writer::start_tag('a', array(
                'href' => $url,
                'class' => 'dropdown-toggle',
                'data-toggle' => 'dropdown',
                'role' => 'button',
                'title' => $menunode->get_title()
            ));

            $content .= $menunode->get_text();
            if ($level == 1) {
                $content .= '<span class="caret"></span>';
            }

            $content .= '</a>';
            $content .= '<ul class="dropdown-menu" role="menu">';
            $content .= '<li class="first"><span class="arrow"></span></li>';

            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->render_custom_menu_item($menunode, 0);
            }

            $content .= '</ul>';
        } else {
            // The node doesn't have children so produce a final menuitem.
            // Also, if the node's text matches '####', add a class so we can treat it as a divider.
            if (preg_match("/^#+$/", $menunode->get_text())) {
                // This is a divider.
                $content = '<li class="divider">&nbsp;</li>';
            } else {
                $content = '<li>';
                if ($menunode->get_url() !== null) {
                    $url = $menunode->get_url();
                } else {
                    $url = '#';
                }
                $content .= html_writer::link($url, $menunode->get_text(), array('title' => $menunode->get_title()));
                $content .= '</li>';
            }
        }

        return $content;
    }

    /**
     * Internal implementation of paging bar rendering.
     *
     * @param paging_bar $pagingbar
     * @return string
     */
    protected function render_paging_bar(paging_bar $pagingbar) {
        $pagingbar = clone($pagingbar);
        $pagingbar->prepare($this, $this->page, $this->target);

        if ($pagingbar->totalcount > $pagingbar->perpage) {
            $output = '';

            if (!empty($pagingbar->previouslink)) {
                $output .= '&#160;(' . $pagingbar->previouslink . ')&#160;';
            }

            if (!empty($pagingbar->firstlink)) {
                $output .= '&#160;' . $pagingbar->firstlink . '&#160;...';
            }

            foreach ($pagingbar->pagelinks as $link) {
                $output .= "&#160;&#160;$link";
            }

            if (!empty($pagingbar->lastlink)) {
                $output .= '&#160;...' . $pagingbar->lastlink . '&#160;';
            }

            if (!empty($pagingbar->nextlink)) {
                $output .= '&#160;&#160;(' . $pagingbar->nextlink . ')';
            }

            return html_writer::tag('div', $output, array('class' => 'paging'));
        }

        return '';
    }

    /**
     * Replace some icons.
     * @param  pix_icon $icon [description]
     * @return [type]         [description]
     */
    public function render_pix_icon(pix_icon $icon) {
        // Disabled, for now.
        return parent::render_pix_icon($icon);

        static $icons = array(
            'add' => 'plus',
            'book' => 'book',
            'chapter' => 'file',
            'docs' => 'question-circle',
            'generate' => 'gift',
            'i/marker' => 'lightbulb-o',
            'i/dragdrop' => 'arrows',
            'i/loading' => 'refresh fa-spin fa-2x',
            'i/loading_small' => 'refresh fa-spin',
            'i/backup' => 'cloud-download',
            'i/checkpermissions' => 'user',
            'i/edit' => 'pencil',
            'i/filter' => 'filter',
            'i/grades' => 'table',
            'i/group' => 'group',
            'i/groupn' => 'group',
            'i/groupv' => 'group',
            'i/groups' => 'group',
            'i/hide' => 'eye',
            'i/import' => 'upload',
            'i/move_2d' => 'arrows',
            'i/navigationitem' => 'file',
            'i/outcomes' => 'magic',
            'i/publish' => 'globe',
            'i/reload' => 'refresh',
            'i/report' => 'list-alt',
            'i/restore' => 'cloud-upload',
            'i/return' => 'repeat',
            'i/roles' => 'user',
            'i/cohort' => 'users',
            'i/scales' => 'signal',
            'i/settings' => 'cogs',
            'i/show' => 'eye-slash',
            'i/switchrole' => 'random',
            'i/user' => 'user',
            'i/users' => 'user',
            't/right' => 'arrow-right',
            't/left' => 'arrow-left',
            't/edit_menu' => 'cogs',
            'i/withsubcat' => 'indent',
            'i/permissions' => 'key',
            't/cohort' => 'users',
            'i/assignroles' => 'lock',
            't/assignroles' => 'lock',
            't/delete' => 'times-circle',
            't/edit' => 'cog',
            't/hide' => 'eye',
            't/show' => 'eye-slash',
            't/up' => 'arrow-up',
            't/down' => 'arrow-down',
            't/copy' => 'copy',
            't/block_to_dock' => 'caret-square-o-left',
            't/sort' => 'sort',
            't/sort_asc' => 'sort-asc',
            't/sort_desc' => 'sort-desc',
            't/grades' => 'th-list',
            't/preview' => 'search',
        );

        if (array_key_exists($icon->pix, $icons)) {
            $alt = $icon->attributes['alt'];
            $icon = $icons[$icon->pix];
            return "<i class=\"fa fa-$icon icon\" title=\"$alt\">";
        } else {
            return parent::render_pix_icon($icon);
        }
    }
}
