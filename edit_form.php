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
 * Form for editing specific news_slider_plus instances.
 *
 * @package   block_news_slider_plus
 * @copyright 2017 Manoj Solanki (Coventry University)
 * @license   
 */

defined('MOODLE_INTERNAL') || die;

/**
 * News Slider Plus edit form implementation class.
 *
 * @package block_news_slider_plus
 * @copyright 2017 Manoj Solanki (Coventry University)
 * @license    
 */
class block_news_slider_plus_edit_form extends block_edit_form {

    /**
     * Override specific definition to provide News Slider Plus instance settings.
     *
     * @param MoodleQuickForm $mform
     */
    protected function specific_definition($mform) {
        global $CFG;
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Display mode, all news, site news or course news.
        $displaymodeoptions = array(
                block_news_slider_plus::DISPLAY_MODE_ALL_NEWS    => get_string('displaymodestringall', 'block_news_slider_plus'),
                block_news_slider_plus::DISPLAY_MODE_SITE_NEWS   => get_string('displaymodestringsite', 'block_news_slider_plus'),
                block_news_slider_plus::DISPLAY_MODE_COURSE_NEWS => get_string('displaymodestringcourse', 'block_news_slider_plus')
        );

        $priorityoptions = array(
            block_news_slider_plus::SITE_PRIORITY => get_string('sitepriority', 'block_news_slider_plus'),
            block_news_slider_plus::DATE_PRIORITY => get_string('datepriority', 'block_news_slider_plus'),
        );

        $mform->addElement('text', 'config_bannertitle', get_string('bannertitle', 'block_news_slider_plus'));
        $mform->setDefault('config_bannertitle', block_news_slider_plus::news_slider_plus_DEFAULT_TITLE_BANNER);
        $mform->setType('config_bannertitle', PARAM_TEXT);

        $mform->addElement('select', 'config_displaymode', get_string('displaymode', 'block_news_slider_plus'), $displaymodeoptions);
        $mform->setDefault('config_displaymode', block_news_slider_plus::DISPLAY_MODE_ALL_NEWS);
        $mform->setType('config_displaymode', PARAM_INT);

        $mform->addElement('select', 'config_fppriority', get_string('fppriority', 'block_news_slider_plus'), $priorityoptions);
        $mform->setDefault('config_fppriority', block_news_slider_plus::SITE_PRIORITY);
        $mform->setType('config_fppriority', PARAM_INT);

        $styleoptions = array(  
                            'Style 1',
                            'Style 2',
                            'Style 3',
                            'Style 4',
                            'Style 5',
                        );
        $mform->addElement('select', 'config_sliderstyle', get_string('sliderstyle', 'block_news_slider_plus'), $styleoptions);
        $mform->setDefault('config_sliderstyle', 'Style 1');
        $mform->setType('config_sliderstyle', PARAM_INT);

        $mform->addElement('text', 'config_numslides', get_string('numslides', 'block_news_slider_plus'));
        $mform->setDefault('config_numslides', block_news_slider_plus::news_slider_plus_DEFAULT_NUM_SLIDES); 
        $mform->setType('config_numslides', PARAM_TEXT);

        $mform->addElement('text', 'config_maincolour', get_string('maincolour', 'block_news_slider_plus'));
        $mform->setDefault('config_maincolour', block_news_slider_plus::news_slider_plus_DEFAULT_MAIN_COLOUR);
        $mform->setType('config_maincolour', PARAM_TEXT);

        $mform->addElement('text', 'config_siteitemstoshow', get_string('siteitemstoshow', 'block_news_slider_plus'));
        $mform->setDefault('config_siteitemstoshow', block_news_slider_plus::news_slider_plus_DEFAULT_SITE_NEWS_ITEMS);
        $mform->setType('config_siteitemstoshow', PARAM_TEXT);

        $mform->addElement('text', 'config_siteitemsperiod', get_string('siteitemsperiod', 'block_news_slider_plus'));
        $mform->setDefault('config_siteitemsperiod', block_news_slider_plus::news_slider_plus_DEFAULT_SITE_NEWS_PERIOD);
        $mform->setType('config_siteitemsperiod', PARAM_TEXT);

        $mform->addElement('text', 'config_courseitemstoshow', get_string('courseitemstoshow', 'block_news_slider_plus'));
        $mform->setDefault('config_courseitemstoshow', block_news_slider_plus::news_slider_plus_DEFAULT_COURSE_NEWS_ITEMS);
        $mform->setType('config_courseitemstoshow', PARAM_TEXT);

        $mform->addElement('text', 'config_courseitemsperiod', get_string('courseitemsperiod', 'block_news_slider_plus'));
        $mform->setDefault('config_courseitemsperiod', block_news_slider_plus::news_slider_plus_DEFAULT_COURSE_NEWS_PERIOD);
        $mform->setType('config_courseitemsperiod', PARAM_TEXT);

        // Show old site news link yes / no option.
        $mform->addElement('selectyesno', 'config_showoldnews', get_string('showoldnews', 'block_news_slider_plus'));
        $mform->setDefault('config_showoldnews', 0);

        // Show slick dot navigation (bullets) on bottom.
        $mform->addElement('selectyesno', 'config_showdots', get_string('showdots', 'block_news_slider_plus'));
        $mform->setDefault('config_showdots', 1);

    }
}
