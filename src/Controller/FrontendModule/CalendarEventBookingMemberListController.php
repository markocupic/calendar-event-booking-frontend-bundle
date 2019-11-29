<?php

declare(strict_types=1);

/*
 * Copyright Marko Cupic <m.cupic@gmx.ch>, 2019
 * @author Marko Cupic
 * @link https://github.com/markocupic/calendar-event-booking-frontend-bundle
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Markocupic\CalendarEventBookingFrontendBundle\Controller\FrontendModule;

use Contao\CalendarEventsMemberModel;
use Contao\CalendarEventsModel;
use Contao\Config;
use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\ServiceAnnotation\FrontendModule;
use Contao\Database;
use Contao\FrontendTemplate;
use Contao\Input;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CalendarEventBookingMemberListController
 * @package Markocupic\CalendarEventBookingFrontendBundle\Controller\FrontendModule
 * @FrontendModule(category="events", type="calendar_event_booking_member_list_module")
 */
class CalendarEventBookingMemberListController extends AbstractFrontendModuleController
{

    /**
     * @var ContaoFramework
     */
    protected $framework;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var ScopeMatcher
     */
    protected $scopeMatcher;

    /**
     * @var CalendarEventsModel
     */
    protected $objEvent;

    /**
     * CalendarEventBookingMemberListController constructor.
     * @param ContaoFramework $framework
     * @param RequestStack $requestStack
     * @param ScopeMatcher $scopeMatcher
     */
    public function __construct(ContaoFramework $framework, RequestStack $requestStack, ScopeMatcher $scopeMatcher)
    {
        $this->framework = $framework;
        $this->requestStack = $requestStack;
        $this->scopeMatcher = $scopeMatcher;
    }

    /**
     * Like generate-method in past contao modules
     * ! This method is optional and can be used, if the response should contain an empty string only
     * @param Request $request
     * @param ModuleModel $model
     * @param string $section
     * @param array|null $classes
     * @param PageModel|null $page
     * @return Response
     */
    public function __invoke(Request $request, ModuleModel $model, string $section, array $classes = null, PageModel $page = null): Response
    {
        // Return empty string, if user is not logged in as a frontend user
        if ($this->isFrontend())
        {
            // Set adapters
            $configAdapter = $this->framework->getAdapter(Config::class);
            $inputAdapter = $this->framework->getAdapter(Input::class);
            $calendarEventsModelAdapter = $this->framework->getAdapter(CalendarEventsModel::class);

            $showEmpty = false;
            
            // Set the item from the auto_item parameter
            if (!isset($_GET['events']) && $configAdapter->get('useAutoItem') && isset($_GET['auto_item']))
            {
                $inputAdapter->setGet('events', $inputAdapter->get('auto_item'));
            }

            // Return an empty string if "events" is not set (to combine list and reader on same page)
            if (!$inputAdapter->get('events'))
            {
                $showEmpty = true;
            }
            elseif (null === ($this->objEvent = $calendarEventsModelAdapter->findByIdOrAlias($inputAdapter->get('events'))))
            {
                $showEmpty = true;
            }

            if ($showEmpty)
            {
                return new Response('', Response::HTTP_NO_CONTENT);
            }
        }

        // Call the parent method
        return parent::__invoke($request, $model, $section, $classes);
    }

    /**
     * Like compile-method in past contao modules
     * @param Template $template
     * @param ModuleModel $model
     * @param Request $request
     * @return null|Response
     */
    protected function getResponse(Template $template, ModuleModel $model, Request $request): ?Response
    {
        // Set adapters
        $databaseAdapter = $this->framework->getAdapter(Database::class);
        $calendarEventsMemberModelAdapter = $this->framework->getAdapter(CalendarEventsMemberModel::class);

        $objStmt = $databaseAdapter->getInstance()->prepare('SELECT id FROM tl_calendar_events_member WHERE pid=? ORDER BY lastname, firstname, city')->execute($this->objEvent->id);
        $count = $objStmt->numRows;
        $i = 0;
        $strRows = '';
        while ($objStmt->next())
        {
            // Get partial template
            $partial = new FrontendTemplate($model->calendar_event_booking_member_list_partial_template);

            // Set model
            $memberModel = $calendarEventsMemberModelAdapter->findByPk($objStmt->id);
            $partial->model = $memberModel;

            // Row class
            $rowFirst = ($i == 0) ? ' row_first' : '';
            $rowLast = ($i == $count - 1) ? ' row_last' : '';
            $evenOrOdd = ($i % 2) ? ' odd' : ' even';
            $partial->rowClass = sprintf('row_%s%s%s%s', $i, $rowFirst, $rowLast, $evenOrOdd);

            $strRows .= $partial->parse();
            $i++;
        }
        $template->members = $strRows;

        return $template->getResponse();
    }

    /**
     * Identify the Contao scope (TL_MODE) of the current request
     * @return bool
     */
    protected function isFrontend(): bool
    {
        return $this->scopeMatcher->isFrontendRequest($this->requestStack->getCurrentRequest());
    }
}
