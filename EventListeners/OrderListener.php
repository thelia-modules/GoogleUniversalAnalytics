<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace GoogleUniversalAnalytics\EventListeners;

use GoogleUniversalAnalytics\GoogleUniversalAnalytics;
use GoogleUniversalAnalytics\Model\UniversalanalyticsTransaction;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpFoundation\Request;

/**
 * Class OrderListener
 * @package GoogleUniversalAnalytics\EventListeners
 * @author manuel raynaud <mraynaud@openstudio.fr>
 */
class OrderListener implements EventSubscriberInterface
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function saveTransaction(OrderEvent $event)
    {
        $clientId = $this->request->getSession()->get(GoogleUniversalAnalytics::ANALYTICS_UA);

        if (null !== $clientId) {
            $order = $event->getPlacedOrder();

            $universalAnalytics = new UniversalanalyticsTransaction();

            $universalAnalytics
                ->setClientid($clientId)
                ->setOrderId($order->getId())
                ->save();
        }

    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        $events = [
            TheliaEvents::ORDER_PAY => 'saveTransaction',
        ];

        if (defined("Thelia\\Core\\Event\\TheliaEvents::ORDER_CREATE_MANUAL")) {
            $events[TheliaEvents::ORDER_CREATE_MANUAL] = 'saveTransaction';
        }

        return $events;
    }
}
