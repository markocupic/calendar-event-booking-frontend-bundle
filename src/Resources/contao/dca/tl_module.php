<?php

/*
 * Copyright Marko Cupic <m.cupic@gmx.ch>, 2019
 * @author Marko Cupic
 * @link https://github.com/markocupic/calendar-event-booking-frontend-bundle
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Set palettes
$GLOBALS['TL_DCA']['tl_module']['palettes']['calendar_event_booking_member_list'] = '{title_legend},name,headline,type;{template_legend},calendar_event_booking_member_list_partial_template,calendar_event_booking_member_list_template;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

// Fields
$GLOBALS['TL_DCA']['tl_module']['fields']['calendar_event_booking_member_list_template'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_modules']['calendar_event_booking_member_list_template'],
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => array('markocupic.calendar_event_booking_frontend_bundle.contao.dca.tl_module', 'getCalendarEventBookingMemberListTemplate'),
    'eval'             => array('tl_class' => 'w50'),
    'sql'              => "varchar(128) NOT NULL default 'mod_calendar_event_booking_member_list'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['calendar_event_booking_member_list_partial_template'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_modules']['calendar_event_booking_member_list_partial_template'],
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => array('markocupic.calendar_event_booking_frontend_bundle.contao.dca.tl_module', 'getCalendarEventBookingMemberListPartialTemplate'),
    'eval'             => array('tl_class' => 'w50'),
    'sql'              => "varchar(128) NOT NULL default 'calendar_event_booking_member_list_partial'"
);

