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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	 See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Search block functions
 * @package	   block_search
 * @copyright	 Anthony Kuske <www.anthonykuske.com>
 * @license	   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_search extends block_base
{

	public function init()
	{
		if (!empty($this->page->course)) {
			$this->title = get_string('searchverb', 'block_search') . $this->page->course->fullname;
		} else {
			$this->title = get_string('pluginname', 'block_search');
		}
	}

	//Set the content of the block when displayed as a block on a page
	public function get_content()
	{
		global $CFG, $OUTPUT, $PAGE;
	
		//Include the CSS for the block
		$PAGE->requires->css('/blocks/search/assets/css/block.css');
		
		require_once dirname(__FILE__) . '/MoodleSearch/Block.php';
		$searchBlock = new \MoodleSearch\Block();
		
		$this->content = new stdClass;
		$this->content->text = $searchBlock->display->showSearchBox(
			$_GET['q'],
			$this->page->course->id,
			false,
			false,
			get_string('search_input_text_block', 'block_search')
		);
		
		return $this->content;
	}

	// my moodle can only have SITEID and it's redundant here, so take it away
	public function applicable_formats()
	{
		return array(
			'all' => false,
			'site' => true,
			'site-index' => true,
			'course-view' => true,
			'course-view-social' => false,
			'mod' => true,
			'mod-quiz' => false
		);
	}


	//Can multiple instance of this block be added to the same page?
	public function instance_allow_multiple()
	{
		return false;
	}

	//Do we have a settings.php file? (Global admin settings for the block)
	public function has_config()
	{
		return true;
	}

	/*public function cron()
	{
		mtrace("Hey, my cron script is running");
		// do something
		return true;
	}*/
}
