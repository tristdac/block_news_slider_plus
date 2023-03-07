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
 *
 * Settings for Block News Slider Plus.
 *
 * @package   block_news_slider_plus
 * @copyright 2017 Manoj Solanki (Coventry University)
 * @copyright
 * @license   
 *
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_configtext('block_news_slider_plus/excerptlength',
            get_string('excerptlength', 'block_news_slider_plus'),
            get_string('excerptlengthdesc', 'block_news_slider_plus'), NEWS_SLIDER_PLUS_EXCERPT_LENGTH, PARAM_INT));

    $settings->add(new admin_setting_configtext('block_news_slider_plus/subjectmaxlength',
            get_string('subjectmaxlength', 'block_news_slider_plus'),
            get_string('subjectmaxlengthdesc', 'block_news_slider_plus'), NEWS_SLIDER_PLUS_SUBJECT_MAX_LENGTH, PARAM_INT));

    $settings->add(new admin_setting_configcheckbox('block_news_slider_plus/usecaching', get_string('usecaching', 'block_news_slider_plus'),
            get_string('usecachingdesc', 'block_news_slider_plus'), 0));

    $settings->add(new admin_setting_configtext('block_news_slider_plus/cachingttl',
            get_string('cachingttl', 'block_news_slider_plus'),
            get_string('cachingttldesc', 'block_news_slider_plus'), NEWS_SLIDER_PLUS_CACHING_TTL, PARAM_INT));

    $settings->add(new admin_setting_configtext('block_news_slider_plus/extractcategory',
            get_string('extractcategory', 'block_news_slider_plus'),
            get_string('extractcategorydesc', 'block_news_slider_plus'), NEWS_SLIDER_PLUS_EXTRACT_CATEGORY, PARAM_INT));

    // $settings->add(new admin_setting_configcheckbox('block_news_slider_plus/prioritise_site', get_string('prioritisesite', 'block_news_slider_plus'),
    //         get_string('prioritisesite', 'block_news_slider_plus'), 1));
}
