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
use GoogleUniversalAnalytics\Model\UniversalanalyticsTransactionQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Model\ConfigQuery;

/**
 * Class TrackingListener
 * @package GoogleUniversalAnalytics\EventListeners
 * @author manuel raynaud <mraynaud@openstudio.fr>
 */
class TrackingListener implements EventSubscriberInterface
{

    public function track(OrderEvent $event)
    {
        $order = $event->getOrder();
        if ($order->isPaid()) {
            $transaction = UniversalanalyticsTransactionQuery::create()
                ->findOneByOrderId($order->getId());

            if (null !== $transaction) {
                $clientId = $transaction->getClientid();
                $analyticsUA = ConfigQuery::read(GoogleUniversalAnalytics::ANALYTICS_UA);
                $tax = 0;
                $transaction = [
                    'v' => 1,
                    'tid' => $analyticsUA,
                    'cid' => $clientId,
                    't' => 'transaction',
                    'ti' => $order->getRef(),
                    'tr' => $order->getTotalAmount($tax, false),
                    'tt' => $tax,
                    'ts' => $order->getPostage(),
                    'cu' => $order->getCurrency()->getCode()
                ];

                $query = "";
                foreach ($transaction as $key => $value) {
                    $query .= "&".$key."=".$value;
                }

                $query = ltrim($query, "&");

                $url = "http://www.google-analytics.com/collect?".$query;

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                $result = curl_exec($curl);
                $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
            }
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
        return [
            TheliaEvents::ORDER_UPDATE_STATUS => ['track', 0]
        ];
    }
}
