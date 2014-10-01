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
use GoogleUniversalAnalytics\Measurement\Item;
use GoogleUniversalAnalytics\Measurement\Transaction;
use GoogleUniversalAnalytics\Model\UniversalanalyticsTransactionQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Log\Tlog;
use Thelia\Model\ConfigQuery;

/**
 * Class TrackingListener
 * @package GoogleUniversalAnalytics\EventListeners
 * @author manuel raynaud <mraynaud@openstudio.fr>
 */
class TrackingListener implements EventSubscriberInterface
{

    /**
     * Send a transaction and all items to Google Universal Analytics
     *
     * @param OrderEvent $event
     */
    public function track(OrderEvent $event)
    {
        $order = $event->getOrder();
        if ($order->isPaid()) {
            $transaction = UniversalanalyticsTransactionQuery::create()
                ->findOneByOrderId($order->getId());

            if (null !== $transaction) {
                $clientId = $transaction->getClientid();
                $tax = 0;
                $currency = $order->getCurrency()->getCode();
                $ref = $order->getRef();
                $transaction = new Transaction();

                $transaction
                    ->add('cid', $clientId)
                    ->add('ti', $ref)
                    ->add('tr', $order->getTotalAmount($tax, false))
                    ->add('tt', $tax)
                    ->add('ts', $order->getPostage())
                    ->add('cu', $currency)
                    ->send()
                ;

                Tlog::getInstance()->addError('transaction : ' . print_r($transaction->getData(), true));

                foreach ($order->getOrderProducts() as $product) {
                    $taxes = $product->getOrderProductTaxes();
                    $productTax = 0;
                    foreach ($taxes as $tax) {
                        $productTax += $product->getWasInPromo() ? $tax->getPromoAmount() : $tax->getAmount();
                    }

                    $item = new Item();
                    $price = $product->getWasInPromo() ? $product->getPromoPrice() : $product->getPrice();
                    $price += $productTax;
                    $item->add('cid', $clientId)
                        ->add('ti', $ref)
                        ->add('in', $product->getTitle())
                        ->add('iq', $product->getQuantity())
                        ->add('ic', $product->getProductRef())
                        ->add('cu', $currency)
                        ->add('ip', $price)
                        ->send()
                    ;

                    Tlog::getInstance()->addError('item : ' . print_r($item->getData(), true));
                }
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
