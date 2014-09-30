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

namespace GoogleUniversalAnalytics\Controller;

use GoogleUniversalAnalytics\GoogleUniversalAnalytics;
use Thelia\Controller\Front\BaseFrontController;

/**
 * Class Client
 * @package GoogleUniversalAnalytics\Controller
 * @author manuel raynaud <mraynaud@openstudio.fr>
 */
class Client extends BaseFrontController
{
    public function saveAction()
    {
        $clientId = $this->getRequest()->query->get('clientId');

        $this->getSession()->set(GoogleUniversalAnalytics::ANALYTICS_UA, $clientId);
    }
}
