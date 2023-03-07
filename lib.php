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
 * News Slider Plus block helper functions and callbacks.
 *
 * @package block_news_slider_plus
 * @copyright 2017 Manoj Solanki (Coventry University)
 * @copyright 2017 John Tutchings (Coventry University)
 * @copyright
 *
 * @license 
 *
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . "/mod/forum/lib.php");

define('NEWS_SLIDER_PLUS_EXCERPT_LENGTH', 110);
define('NEWS_SLIDER_PLUS_SUBJECT_MAX_LENGTH', 25);
define('NEWS_SLIDER_PLUS_CACHING_TTL', 300);
define('NEWS_SLIDER_PLUS_EXTRACT_CATEGORY', '');

$defaultblocksettings = array(
        'excerptlength' => NEWS_SLIDER_PLUS_EXCERPT_LENGTH,
        'subjectmaxlength' => NEWS_SLIDER_PLUS_SUBJECT_MAX_LENGTH
);

/**
 * Get news items that need to be displayed.
 *
 * @param stdClass $course a course to get the news items from for the current user
 * @param bool     $getsitenews optional flag.  If set to true, get site news instead
 * @param stdClass $sliderconfig  Object containing config data
 *
 * @return array List of news items to show
 */
function news_slider_plus_get_course_news($course, $getsitenews = false, $sliderconfig = null, &$currenttotalcoursesretrieved = null) {
    global $USER, $OUTPUT, $COURSE, $DB, $CFG;
    $posttext = '';

    $newsitems = array();

    // If getsitenews is set to true, get site news instead.
    if ($getsitenews) {
        global $SITE, $DB;

        if (! $newsforum = forum_get_course_forum($SITE->id, "news")) {
            return $newsitems;
        }
        $cm = get_coursemodule_from_instance('forum', $newsforum->id, $SITE->id, false, MUST_EXIST);

        $totalpoststoshow = $sliderconfig->siteitemstoshow;
        $postsupdatedsince = $sliderconfig->siteitemsperiod * 86400;
        $postsupdatedsince = time() - $postsupdatedsince;
        $sort = forum_get_default_sort_order(true, 'p.modified', 'd', true); // Last parameter set to true to include pinned posts.
        $discussions = forum_get_discussions($cm, "", true, null, $totalpoststoshow, null, null, null, null, $postsupdatedsince);
    } else {
        // Get course posts.
        if ($currenttotalcoursesretrieved !== null) {
            // If reached limit, retrieve no more (as used when this function is called consecutively for many courses).
            if ($currenttotalcoursesretrieved == $sliderconfig->courseitemstoshow) {
                    return array();
            } else {
                $totalpoststoshow = $sliderconfig->courseitemstoshow - $currenttotalcoursesretrieved;
            }
        } else {
            $totalpoststoshow = $sliderconfig->courseitemstoshow;
        }

        $postsupdatedsince = $sliderconfig->courseitemsperiod * 86400;
        $postsupdatedsince = time() - $postsupdatedsince;
        $newsforum = forum_get_course_forum($course->id, 'news');
        $cm = get_coursemodule_from_instance('forum', $newsforum->id, $newsforum->course);
        $discussions = forum_get_discussions($cm, "", true, null, $totalpoststoshow, null, null, null, null, $postsupdatedsince);

        if ($currenttotalcoursesretrieved !== null) {
            $currenttotalcoursesretrieved += count($discussions);
        }
    }

    $strftimerecent = get_string('strftimerecent');

    // If this is a site page, do not pin course posts.
    $getpinnedposts = true;
    if ( ($COURSE->id <= 1) && ($course->id <= 1) ) {
        $getpinnedposts = false;
    }
    $extractcategories = explode (",", str_replace(' ', '', get_config('block_news_slider_plus', 'extractcategory')));
    $usedcourses = array();
    foreach ($discussions as $discussion) {
        if ($COURSE->id == '1') {
            $newscourse_catid = $DB->get_field('course', 'category', array('id'=>$discussion->course));
        // if (in_array($newscourse_catid, $extractcategories)) {
        //     echo('<br>'.$newscourse_catid.' should be included');
        // } else {
        //     echo('<br>'.$newscourse_catid.' NOT INCLUDED');
        // }
        // print_object($discussion);
            if ($discussion->course == '1' || ($discussion->pinned == '1'  && (!in_array($discussion->course, $usedcourses) && $discussion->course !== $COURSE->id) && (in_array($newscourse_catid, $extractcategories)))) {
                // maximum 1 pinned post from each course
                $usedcourses[] = $discussion->course;
                // $sourcecoursecolour = 
                // Set main colour for slides
                if (($sliderconfig->maincolour === 'random') || (empty($sliderconfig->maincolour))) {
                    // Generate random colour for each discussion
                    $rgbColour = array();
                    //Create a loop.
                    foreach(array('r', 'g', 'b') as $colour){
                        //Generate a random number between 0 and 250.
                        $rgbColour[$colour] = mt_rand(0, 250);
                    }
                    // Set the colour
                    $colour = 'rgba('. implode(",", $rgbColour).', 1)';
                    $sourcecolour = 'rgba('. implode(",", $rgbColour).', .2)';
                }
                else {
                    $blockid = $DB->get_field('block', 'id', array('name'=>'news_slider_plus'));
                    $context = $DB->get_field('context', 'id', array('instanceid'=>$discussion->course,'contextlevel'=>'50'));
                    $instance = $DB->get_field('block_instances', 'id', array('parentcontextid'=>$context,'blockname'=>'news_slider_plus'));
                    if ($instance) {
                        $parentblockconfig = unserialize_object(base64_decode($DB->get_field('block_instances', 'configdata', array('parentcontextid'=>$context,'blockname'=>'news_slider_plus'))));
                        // print_object($parentblockconfig);
                        if ($parentblockconfig) {
                            $colour = $parentblockconfig->maincolour;
                            $sourcecolour = $parentblockconfig->maincolour.'33';
                        }
                    } else {
                        $contextpath = $DB->get_field('context', 'path', array('id'=>$context,'contextlevel'=>'50'));
                        $sql = "SELECT ctx.*, bi.*
                                FROM {context} ctx
                                JOIN {block_instances} bi on bi.parentcontextid = ctx.id
                                WHERE ctx.contextlevel != ? 
                                AND ctx.path LIKE ?
                                AND bi.blockname = ?
                                ORDER BY bi.id DESC LIMIT 0, 1";
                        $parentblock = 
                            $DB->get_record_sql($sql, ['50', $contextpath.'/%', 'news_slider_plus']);
                        $parentblockconfig = unserialize_object(base64_decode($parentblock->configdata));
                        $colour = $parentblockconfig->maincolour;
                        $sourcecolour = $parentblockconfig->maincolour.'33';
                        
                    } 
                    if (!$colour) {
                        $colour = $sliderconfig->maincolour;
                        $sourcecolour = $sliderconfig->maincolour.'33';
                    }
                    
                }
                
                // Get attached files and images
                $post = $DB->get_record('forum_posts', array('id' => $discussion->id));
                list($attachments, $attachedimages) = forum_print_attachments($post, $cm, 'separateimages');
                if ($attachedimages) {
                    $attachedimages_url = str_replace(array('<img src="', '" alt="" />', '<br>', '<br />'), '', $attachedimages);
                } else { // Use default image if none uploaded
                    $attachedimages_url = $CFG->wwwroot.'/blocks/news_slider_plus/pix/placeholder.jpg';
                }

                // Split date
                $created = date('d/m/Y', $discussion->created);
                $dt = DateTime::createFromFormat('d/m/Y', $created);
                $created_day = strtoupper($dt->format('j'));
                $created_month = strtoupper($dt->format('M'));


                // Get user profile picture.

                // Build an object that represents the posting user.
                $postuser = new stdClass;
                $postuserfields = $fields = \core_user\fields::for_userpic()->get_required_fields();;
                $postuser = username_load_fields_from_object($postuser, $discussion, null, $postuserfields);
                $postuser->id = $discussion->userid;
                $postuser->fullname    = $discussion->firstname . ' ' . $discussion->lastname;
                $postuser->profilelink = new moodle_url('/user/view.php', array('id' => $discussion->userid, 'course' => $course->id));

                $userpicture = $OUTPUT->user_picture($postuser, array('courseid' => $course->id, 'size' => 80));

                $newsitems[$discussion->id]['course'] = $course->shortname;
                $newsitems[$discussion->id]['courseid'] = $course->id;
                $newsitems[$discussion->id]['discussion'] = $discussion->discussion;
                $newsitems[$discussion->id]['modified'] = $discussion->modified;
                $newsitems[$discussion->id]['daycreated'] = $created_day;
                $newsitems[$discussion->id]['monthcreated'] = $created_month;
                $newsitems[$discussion->id]['author'] = $discussion->firstname . ' ' . $discussion->lastname;
                $newsitems[$discussion->id]['subject'] = $discussion->subject;
                $newsitems[$discussion->id]['message'] = $discussion->message;
                $newsitems[$discussion->id]['pinned'] = ( ($COURSE->id <= 1) && ($course->id > 1) ) ? "" : $discussion->pinned;
                $newsitems[$discussion->id]['userdate'] = userdate($discussion->modified, $strftimerecent);
                $newsitems[$discussion->id]['userid'] = $discussion->userid;
                $newsitems[$discussion->id]['userpicture'] = $userpicture;
                // $newsitems[$discussion->id]['attachedimage'] = $attachedimages;
                $newsitems[$discussion->id]['attachedimage_url'] = $attachedimages_url;
                $newsitems[$discussion->id]['colour'] = $colour;
                $newsitems[$discussion->id]['sourcecolour'] = $sourcecolour;

                // Check if message is pinned.
                if ($getpinnedposts == true) {
                    if (FORUM_DISCUSSION_PINNED == $discussion->pinned) {
                        $newsitems[$discussion->id]['pinned'] = 1;
                    } else {
                        $newsitems[$discussion->id]['pinned'] = 0;
                    }
                }

                $posttext .= $discussion->subject;
                $posttext .= userdate($discussion->modified, $strftimerecent);
                $posttext .= $discussion->message . "\n";
            }
        } else {
            // Set main colour for slides
            if (($sliderconfig->maincolour === 'random') || (empty($sliderconfig->maincolour))) {
                // Generate random colour for each discussion
                $rgbColour = array();
                //Create a loop.
                foreach(array('r', 'g', 'b') as $colour){
                    //Generate a random number between 0 and 250.
                    $rgbColour[$colour] = mt_rand(0, 250);
                }
                // Set the colour
                $colour = 'rgba('. implode(",", $rgbColour).', 1)';;
                $sourcecolour = 'rgba('. implode(",", $rgbColour).', .2)';
            }
            else {
                $colour = $sliderconfig->maincolour;
                $sourcecolour = $sliderconfig->maincolour.' 33';
            }
            
            // Get attached files and images
            $post = $DB->get_record('forum_posts', array('id' => $discussion->id));
            list($attachments, $attachedimages) = forum_print_attachments($post, $cm, 'separateimages');
            if ($attachedimages) {
                $attachedimages_url = str_replace(array('<img src="', '" alt="" />', '<br>', '<br />'), '', $attachedimages);
            } else { // Use default image if none uploaded
                $attachedimages_url = $CFG->wwwroot.'/blocks/news_slider_plus/pix/placeholder.jpg';
            }

            // Split date
            $created = date('d/m/Y', $discussion->created);
            $dt = DateTime::createFromFormat('d/m/Y', $created);
            $created_day = strtoupper($dt->format('j'));
            $created_month = strtoupper($dt->format('M'));

            // Get user profile picture.

            // Build an object that represents the posting user.
            $postuser = new stdClass;
            $postuserfields = \core_user\fields::for_userpic()->get_required_fields();
            $postuser = username_load_fields_from_object($postuser, $discussion, null, $postuserfields);
            $postuser->id = $discussion->userid;
            $postuser->fullname    = $discussion->firstname . ' ' . $discussion->lastname;
            $postuser->profilelink = new moodle_url('/user/view.php', array('id' => $discussion->userid, 'course' => $course->id));

            $userpicture = $OUTPUT->user_picture($postuser, array('courseid' => $course->id, 'size' => 80));

            $newsitems[$discussion->id]['course'] = $course->fullname;
            $newsitems[$discussion->id]['courseid'] = $course->id;
            $newsitems[$discussion->id]['discussion'] = $discussion->discussion;
            $newsitems[$discussion->id]['modified'] = $discussion->modified;
            $newsitems[$discussion->id]['daycreated'] = $created_day;
            $newsitems[$discussion->id]['monthcreated'] = $created_month;
            $newsitems[$discussion->id]['author'] = $discussion->firstname . ' ' . $discussion->lastname;
            $newsitems[$discussion->id]['subject'] = $discussion->subject;
            $newsitems[$discussion->id]['message'] = $discussion->message;
            $newsitems[$discussion->id]['pinned'] = ( ($COURSE->id <= 1) && ($course->id > 1) ) ? "" : $discussion->pinned;
            $newsitems[$discussion->id]['userdate'] = userdate($discussion->modified, $strftimerecent);
            $newsitems[$discussion->id]['userid'] = $discussion->userid;
            $newsitems[$discussion->id]['userpicture'] = $userpicture;
            // $newsitems[$discussion->id]['attachedimage'] = $attachedimages;
            $newsitems[$discussion->id]['attachedimage_url'] = $attachedimages_url;
            $newsitems[$discussion->id]['colour'] = $colour;

            // Check if message is pinned.
            if ($getpinnedposts == true) {
                if (FORUM_DISCUSSION_PINNED == $discussion->pinned) {
                    $newsitems[$discussion->id]['pinned'] = $OUTPUT->pix_icon('i/pinned', get_string('discussionpinned', 'forum'),
                        'mod_forum', array ('style' => ' display: inline-block; vertical-align: middle;'));
                } else {
                    $newsitems[$discussion->id]['pinned'] = "";
                }
            }

            $posttext .= $discussion->subject;
            $posttext .= userdate($discussion->modified, $strftimerecent);
            $posttext .= $discussion->message . "\n";
        }
    }
    return $newsitems;
}

/**
 * Truncates the News item so it fits in the news tabs nicely
 *
 * @param stdClass  $text   The news item text.
 * @param stdClass  $length The length to trim it down to.
 * @param stdClass  $ending  What to display at the end of the string if we have trimmed the item.
 * @param stdClass  $exact
 * @param stdClass  $considerhtml If the html make up tages should be ignored in the length to trim the text down to.
 * @return string
 */
function news_slider_plus_truncate_news($text, $length = 100, $ending = '...', $exact = false, $considerhtml = true) {
    if ($considerhtml) {
        // If the plain text is shorter than the maximum length, return the whole text.
        if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        // Splits all html-tags to scanable lines.
        preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
        $totallength = strlen($ending);
        $opentags = array();
        $truncate = '';
        foreach ($lines as $linematchings) {
            // If there is any html-tag in this line, handle it and add it (uncounted) to the output.
            if (!empty($linematchings[1])) {
                // If it's an "empty element" with or without xhtml-conform closing slash.
                if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $linematchings[1], $tagmatchings)) {
                    // Delete tag from $opentags list.
                    $pos = array_search($tagmatchings[1], $opentags);
                    if ($pos !== false) {
                        unset($opentags[$pos]);
                    }
                    // If tag is an opening tag.
                } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $linematchings[1], $tagmatchings)) {
                    // Add tag to the beginning of $opentags list.
                    array_unshift($opentags, strtolower($tagmatchings[1]));
                }
                // Add html-tag to $truncate'd text.
                $truncate .= $linematchings[1];
            }
            // Calculate the length of the plain text part of the line; handle entities as one character.
            $contentlength = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $linematchings[2]));
            if ($totallength + $contentlength > $length) {
                // The number of characters which are left.
                $left = $length - $totallength;
                $entitieslength = 0;
                // Search for html entities.
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i',
                                    $linematchings[2],
                                    $entities,
                                    PREG_OFFSET_CAPTURE)) {
                    // Calculate the real length of all entities in the legal range.
                    foreach ($entities[0] as $entity) {
                        if ($entity[1] + 1 - $entitieslength <= $left) {
                            $left--;
                            $entitieslength += strlen($entity[0]);
                        } else {
                            // No more characters left.
                            break;
                        }
                    }
                }
                $truncate .= substr($linematchings[2], 0, $left + $entitieslength);
                // Maximum length is reached, so get off the loop.
                break;
            } else {
                $truncate .= $linematchings[2];
                $totallength += $contentlength;
            }
            // If the maximum length is reached, get off the loop.
            if ($totallength >= $length) {
                break;
            }
        }
    } else {
        if (strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = substr($text, 0, $length - strlen($ending));
        }
    }
    // If the words shouldn't be cut in the middle...
    if (!$exact) {
        // ...search the last occurance of a space...
        $spacepos = strrpos($truncate, ' ');
        if (isset($spacepos)) {
            // ...and cut the text in this position.
            $truncate = substr($truncate, 0, $spacepos);
        }
    }

    // Add the defined ending to the text.
    $truncate .= $ending;
    if ($considerhtml) {
        // Close all unclosed html-tags.
        foreach ($opentags as $tag) {
            $truncate .= '</' . $tag . '>';
        }
    }
    return $truncate;
}
