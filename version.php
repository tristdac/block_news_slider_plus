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
 * Version details
 *
 * @package   block_news_slider_plus
 * @copyright 2017 Manoj Solanki (Coventry University)
 * @copyright
 * @license   
 *
 */

defined('MOODLE_INTERNAL') || die();

// Recommended since 2.0.2 (MDL-26035). Required since 3.0 (MDL-48494).
$plugin->component = 'block_news_slider_plus';

// YYYYMMDDHH (year, month, day, 24-hr time).
$plugin->version = 2022113001;

// YYYYMMDDHH (This is the release version for Moodle 3.2).
$plugin->requires = 2016120500;

// $plugin->dependencies = array('theme_adaptable' => 2017053100);

$plugin->maturity = MATURITY_STABLE;
$plugin->release = "1.2.1";
