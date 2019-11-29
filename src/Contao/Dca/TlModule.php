<?php

/*
 * Copyright Marko Cupic <m.cupic@gmx.ch>, 2019
 * @author Marko Cupic
 * @link https://github.com/markocupic/calendar-event-booking-frontend-bundle
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Markocupic\CalendarEventBookingFrontendBundle\Contao\Dca;

use Contao\Backend;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

/**
 * Class TlModule
 * @package Markocupic\CalendarEventBookingFrontendBundle\Contao\Dca
 */
class TlModule extends Backend
{

    /**
     * @var ContaoFramework
     */
    private $framework;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $projectDir;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var ScopeMatcher
     */
    private $scopeMatcher;

    /**
     * DummyModuleController constructor.
     * @param ContaoFramework $framework
     * @param Connection $connection
     * @param string $projectDir
     * @param Security $security
     * @param RequestStack $requestStack
     * @param ScopeMatcher $scopeMatcher
     */
    public function __construct(ContaoFramework $framework, Connection $connection, string $projectDir, Security $security, RequestStack $requestStack, ScopeMatcher $scopeMatcher)
    {
        $this->framework = $framework;
        $this->connection = $connection;
        $this->projectDir = $projectDir;
        $this->security = $security;
        $this->requestStack = $requestStack;
        $this->scopeMatcher = $scopeMatcher;
        //parent::__construct();
    }

    /**
     * @return array
     */
    public function getCalendarEventBookingMemberListTemplate(): array
    {
        return $this->getTemplateGroup('mod_calendar_event_booking_member_list');
    }

    /**
     * @return array
     */
    public function getCalendarEventBookingMemberListPartialTemplate(): array
    {
        return $this->getTemplateGroup('calendar_event_booking_member_list_partial');
    }

}
