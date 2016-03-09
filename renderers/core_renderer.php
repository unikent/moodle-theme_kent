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

    private static $tabdepth = 0;
    private static $inusermenu = false;
    private static $blockperfdata = array();

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
        $listitems = '<li>'.join("</li><li>", $breadcrumbs).'</li>';
        $title = '<span class="accesshide">'.get_string('pagepath').'</span>';
        return $title . "<ul class=\"breadcrumb\">$listitems</ul>";
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
        static::$inusermenu = true;
        $result = parent::user_menu($user, $withlinks);
        static::$inusermenu = false;

        return $result;
    }

    /**
     * Internal implementation of user image rendering.
     *
     * @param user_picture $userpicture
     * @return string
     */
    protected function render_user_picture(user_picture $userpicture) {
        if (static::$inusermenu) {
            $userpicture->size = 50;
            $userpicture->class = 'img-circle';
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

        $firstrow = $secondrow = '';
        foreach ($tabtree->subtree as $tab) {
            $firstrow .= $this->render($tab);
            if (($tab->selected || $tab->activated) && !empty($tab->subtree) && $tab->subtree !== array()) {
                static::$tabdepth++;
                $secondrow = $this->tabtree($tab->subtree);
                static::$tabdepth--;
            }
        }

        $classes = array('nav', 'nav-tabs', 'nav-tabs-' . static::$tabdepth);
        if (static::$tabdepth == 0) {
            $classes[] = 'nav-tabs-first';
        }
        if (static::$tabdepth > 0 && empty($secondrow)) {
            $classes[] = 'nav-tabs-last';
        }

        $tabs = html_writer::tag('ul', $firstrow, array('class' => implode(' ', $classes))) . $secondrow;

        if (static::$tabdepth == 0) {
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
                // Backwards compatibility when link was passed as quoted string.
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

            $previouslinkclass = '';
            if (empty($pagingbar->previouslink)) {
                $previouslinkclass = 'disabled';
            }

            $previouslink = html_writer::link(new moodle_url($pagingbar->baseurl, array(
                $pagingbar->pagevar => empty($pagingbar->previouslink) ? $pagingbar->page : $pagingbar->page - 1
            )), '&laquo;', array('aria-label' => 'Previous'));
            $output .= \html_writer::tag('li', $previouslink, array('class' => $previouslinkclass));

            if (!empty($pagingbar->firstlink)) {
                $output .= '<li>' . $pagingbar->firstlink . '</li>';
                $output .= '<li class="disabled"><a>...</a></li>';
            }

            foreach ($pagingbar->pagelinks as $link) {
                if (strpos($link, '<span class="current-page">') === 0) {
                    $output .= "<li class=\"active\">$link</li>";
                } else {
                    $output .= "<li>$link</li>";
                }
            }

            if (!empty($pagingbar->lastlink)) {
                $output .= '<li class="disabled"><a>...</a></li>';
                $output .= '<li>' . $pagingbar->lastlink . '</li>';
            }

            $nextlinkclass = '';
            if (empty($pagingbar->nextlink)) {
                $nextlinkclass = 'disabled';
            }

            $nextlink = html_writer::link(new moodle_url($pagingbar->baseurl, array(
                $pagingbar->pagevar => empty($pagingbar->nextlink) ? $pagingbar->page : $pagingbar->page + 1
            )), '&raquo;', array('aria-label' => 'Next'));
            $output .= \html_writer::tag('li', $nextlink, array('class' => $nextlinkclass));

            return html_writer::tag('nav', html_writer::tag('ul', $output, array('class' => 'pagination')));
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
            return "<i class=\"fa fa-$icon icon\" title=\"$alt\"></i>";
        } else {
            return parent::render_pix_icon($icon);
        }
    }

    /**
     * Render an FA icon.
     *
     * @param  fa_icon $icon [description]
     * @return [type]         [description]
     */
    public function render_fa_icon(\fa_icon $icon) {
        $alt = $icon->attributes['alt'];
        $class = $icon->attributes['class'];
        return "<i class=\"fa $class icon\" title=\"$alt\"></i>";
    }

    /**
     * Produces a header for a block
     *
     * @param block_contents $bc
     * @return string
     */
    protected function block_header(block_contents $bc) {
        $title = '';
        if ($bc->title) {
            $attributes = array();
            if ($bc->blockinstanceid) {
                $attributes['id'] = 'instance-'.$bc->blockinstanceid.'-header';
            }
            $title = html_writer::tag('h2', $bc->title, $attributes);
        }

        if (!isset(static::$blockperfdata[$bc->blockinstanceid])) {
            static::$blockperfdata[$bc->blockinstanceid] = $bc;
        }

        $blockid = null;
        if (isset($bc->attributes['id'])) {
            $blockid = $bc->attributes['id'];
        }
        $controlshtml = $this->block_controls($bc->controls, $blockid);

        $output = '';
        if ($title || $controlshtml) {
            $actionshtml = html_writer::tag('div', '', array('class' => 'block_action'));
            $actionshtml = html_writer::tag('div', $actionshtml . $controlshtml, array('class' => 'block_actions'));
            $actionshtml = html_writer::tag('div', $title . $actionshtml, array('class' => 'title'));
            $output .= html_writer::tag('div', $actionshtml, array('class' => 'header'));
        }
        return $output;
    }

    /**
     * Outputs the page's footer
     *
     * @return string HTML fragment
     */
    public function footer() {
        global $CFG, $DB;

        $output = $this->container_end_all(true);

        $footer = $this->opencontainers->pop('header/footer');

        if (debugging() && $DB && $DB->is_transaction_started()) {
            debugging("Transaction not completed.");
        }

        // Provide some performance info if required.
        $performanceinfo = '';
        if (defined('MDL_PERF') || (!empty($CFG->perfdebug) && $CFG->perfdebug > 7)) {
            $perf = get_performance_info();
            if (defined('MDL_PERFTOFOOT') || debugging() || $CFG->perfdebug > 7) {
                $performanceinfo = $perf['html'];

                $performanceinfo .= '<div class="performanceinfo">';
                $performanceinfo .= '<div class="blocksused">';
                $performanceinfo .= '<span class="block-stats-heading">Block load times</span>';

                foreach (static::$blockperfdata as $block) {
                    if (!isset($block->loadtime) || $block->loadtime < 0.0001) {
                        continue;
                    }
                    $time = number_format($block->loadtime, 4);

                    $performanceinfo .= <<<HTML5
                    <span class="block-instance-stats">
                        <span class="block-instance-stats-heading">{$block->title} (ID: {$block->blockinstanceid})</span>
                        <span class="block-stats highhits">{$time}s</span>
                    </span>
HTML5;
                }

                $performanceinfo .= '</div></div>';
            }
        }

        // We always want performance data when running a performance test, even if the user is redirected to another page.
        if (MDL_PERF_TEST && strpos($footer, $this->unique_performance_info_token) === false) {
            $footer = $this->unique_performance_info_token . $footer;
        }
        $footer = str_replace($this->unique_performance_info_token, $performanceinfo, $footer);

        $footer = str_replace($this->unique_end_html_token, $this->page->requires->get_end_code(), $footer);

        $this->page->set_state(moodle_page::STATE_DONE);

        return $output . $footer;
    }

    /**
     * Render a list of global notifications.
     */
    public function render_global_notifications($notifications) {
        global $OUTPUT, $USER;

        if (empty($notifications)) {
            return '';
        }

        $out = '';
        foreach ($notifications as $notification) {
            $notification = \theme_kent\notifications::parse($notification);
            if (empty($notification)) {
                continue;
            }

            // Check the audience.
            if ($notification->audience !== 'all') {
                if (!is_array($USER->profile) || !isset($USER->profile['kentacctype']) ||
                    $notification->audience != $USER->profile['kentacctype']) {
                    continue;
                }
            }

            $out .= $OUTPUT->notification($notification->message, 'alert alert-' . $notification->type);
        }

        return $out;
    }

    /**
     * Returns a search box.
     *
     * @param  string $id     The search box wrapper div id, defaults to an autogenerated one. Ignored.
     * @return string         HTML with the search form hidden by default.
     */
    public function search_box($id = false) {
        global $CFG;

        // Accessing $CFG directly as using \core_search::is_global_search_enabled would
        // result in an extra included file for each site, even the ones where global search
        // is disabled.
        if (empty($CFG->enableglobalsearch) || !has_capability('moodle/search:query', context_system::instance())) {
            return '';
        }

        $searchform = html_writer::start_tag('div', array('class' => 'input-group'));
        $searchform .= html_writer::tag('input', '', array(
            'type' => 'text',
            'name' => 'q',
            'class' => 'form-control',
            'placeholder' => 'Search for...'
        ));
        $searchicon .= html_writer::tag('i', '', array('class' => 'fa fa-search'));
        $button = html_writer::tag('button', $searchicon, array('class' => 'btn btn-primary', 'type' => 'submit'));
        $searchform .= html_writer::tag('span', $button, array('class' => 'input-group-btn'));
        $searchform .= html_writer::end_tag('div');

        $formattrs = array('class' => 'search-input-form', 'method' => 'GET', 'action' => $CFG->wwwroot . '/search/index.php');
        $searchinput = html_writer::tag('form', $searchform, $formattrs);

        return html_writer::tag('div', $searchinput, array('class' => 'search-input-wrapper'));
    }
}
