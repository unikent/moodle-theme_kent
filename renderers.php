<?php

/*
 * Restrict headers for 'kent_course_overview', 'calendar_month', 'activity_modules', 'navigation', 'settings', 'aspirelists'
 */

class theme_kent_core_renderer extends core_renderer {


    protected function block_header(block_contents $bc) {

        $show_block_controls = self::kent_determine_show_block_controls($bc->attributes['class'], $bc->controls);

        $title = '';
        if ($bc->title) {
            $attributes = array();
            if ($bc->blockinstanceid) {
                $attributes['id'] = 'instance-'.$bc->blockinstanceid.'-header';
            }
            $title = html_writer::tag('h2', $bc->title, $attributes);
        }

        $controlshtml = '';
        $headerclass = 'header hidedock';

        if ($show_block_controls) {
            $blockid = null;
            if (isset($bc->attributes['id'])) {
                $blockid = $bc->attributes['id'];
            }
            $controlshtml = $this->block_controls($bc->controls, $blockid);
            $headerclass = 'header';
        } else {
            $bc->collapsible = 0;
        }

        $output = '';
        if ($title || $controlshtml) {
            $output .= html_writer::tag('div', html_writer::tag('div', html_writer::tag('div', '', array('class'=>'block_action')). $title . $controlshtml, array('class' => 'title')), array('class' => $headerclass));
        }
        return $output;
    }


    private function kent_determine_show_block_controls($class, $controls){
        //First check if not an admin and there are controls before doing anything
        
        $systemcontext = context_system::instance();
        if(!has_capability('moodle/site:config', $systemcontext)){

            //TODO - Move this somewhere else in a more controllable area so FLT's can control what blocks cannot be controlled by what role etc.
            $restrict_blocks = array('kent_course_overview', 'calendar_month', 'activity_modules', 'navigation', 'settings', 'aspirelists');

            foreach($restrict_blocks as $restricted_block){
                $check_block = "block_$restricted_block";

                if (strstr($class, $check_block)){
                    return FALSE;
                }
            }
        }

        return TRUE;

    }

}
