<?php

/*
 * Put your renders here for your theme
 */

/* 
 * A test using the render override options of Moodle.
 * This could be useful if we want to avoid overriding functions in blocks.  Goes against the principle of separating themes from logic,
 * but then Moodle have done this with
 * the Renderer option for themes... ;/
 *
 *
 * This is left as comments as an example of how to get set up.
 */

class theme_kent_core_renderer extends core_renderer {

    protected function block_header(block_contents $bc) {

        $show_block_controls = self::kent_determine_show_block_controls($bc->attributes['class'], $bc->controls);

        $title = '';
        if ($bc->title) {
            $title = html_writer::tag('h2', $bc->title, null);
        }

        $controlshtml = '';
        $headerclass = 'header hidedock';
        if ($show_block_controls){
            $controlshtml = $this->block_controls($bc->controls);
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
        
        $systemcontext = get_context_instance(CONTEXT_SYSTEM);
        if(!has_capability('moodle/site:config', $systemcontext) && !empty($controls)){

            //TODO - Move this somewhere else in a more controllable area so FLT's can control what blocks cannot be controlled by what role etc.
            $restrict_blocks = array('kent_course_overview', 'calendar_upcoming', 'calendar_month', 'activity_modules', 'navigation');

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

?>
