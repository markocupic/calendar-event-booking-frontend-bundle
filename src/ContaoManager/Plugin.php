<?php

declare(strict_types=1);

/*
 * Copyright Marko Cupic <m.cupic@gmx.ch>, 2019
 * @author Marko Cupic
 * @link https://github.com/markocupic/calendar-event-booking-frontend-bundle
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Markocupic\CalendarEventBookingFrontendBundle\ContaoManager;

use Contao\CalendarBundle\ContaoCalendarBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Markocupic\CalendarEventBookingBundle\MarkocupicCalendarEventBookingBundle;
use Markocupic\CalendarEventBookingFrontendBundle\MarkocupicCalendarEventBookingFrontendBundle;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ContaoCalendarBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
        ];
    }
}
