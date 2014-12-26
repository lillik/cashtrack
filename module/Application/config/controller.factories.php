<?php
return [
    'factories' => array(
        'Application\API\Overview' => function ($sm) {
            $locator    = $sm->getServiceLocator();
            return new \Application\API\Overview($locator->get('Reporter\Overview'));
        },

        'Application\API\Merchant' => function ($sm) {
            $locator    = $sm->getServiceLocator();
            return new \Application\API\Merchant($locator->get('\Database\Merchant\Repository'));
        },

        'Application\API\TimeView' => function ($sm) {
            $locator    = $sm->getServiceLocator();
            return new \Application\API\TimeView($locator->get('\Reporter\TimeMaster'));
        },

        'Application\API\Breakdown' => function ($sm) {
            $locator    = $sm->getServiceLocator();

            $breakdown = new \Application\API\Breakdown($locator->get('\Finance\Reporter\Breakdown'));
            return $breakdown;
        },
    ),
];
