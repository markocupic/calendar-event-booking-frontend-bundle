<?php

declare(strict_types=1);

/*
 * Copyright Marko Cupic <m.cupic@gmx.ch>, 2019
 * @author Marko Cupic
 * @link https://github.com/markocupic/calendar-event-booking-frontend-bundle
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Markocupic\CalendarEventBookingFrontendBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class MarkocupicCalendarEventBookingFrontendExtension
 * @package Markocupic\CalendarEventBookingFrontendBundle\DependencyInjection
 */
class MarkocupicCalendarEventBookingFrontendExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yml');
    }
}
