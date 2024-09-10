<?php
defined('MOODLE_INTERNAL') || die();

class block_statcards extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_statcards');
    }

    public function get_content() {
        global $DB, $USER;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';

        // Retrieve statistics from the database.
        $sql = "SELECT * FROM {block_statcards_data} WHERE userid = :userid";
        $params = array('userid' => $USER->id);
        $record = $DB->get_record_sql($sql, $params);

        if ($record) {
            $this->content->text .= html_writer::tag('div', get_string('coursesenrolled', 'block_statcards') . ': ' . $record->courseenrolled, array('class' => 'card'));
            $this->content->text .= html_writer::tag('div', get_string('coursescompleted', 'block_statcards') . ': ' . $record->coursecompleted, array('class' => 'card'));
            $this->content->text .= html_writer::tag('div', get_string('activitycompleted', 'block_statcards') . ': ' . $record->activitycompleted, array('class' => 'card'));
            $this->content->text .= html_writer::tag('div', get_string('activitiesdue', 'block_statcards') . ': ' . $record->activitiesdue, array('class' => 'card'));
        } else {
            $this->content->text = get_string('no_data_available', 'block_statcards');
        }

        $this->content->text = html_writer::tag('div', $this->content->text, array('class' => 'card-container'));
        $this->content->footer = '';

        return $this->content;
    }
}
