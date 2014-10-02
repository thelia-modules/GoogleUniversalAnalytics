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
namespace GoogleUniversalAnalytics\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/**
 * Class Client
 * @author manuel raynaud <mraynaud@openstudio.fr>
 */
class Client extends BaseHook
{

    public function insertTag(HookRenderEvent $event)
    {
        $event->add($this->render("analytics-client.html"));
    }
}
