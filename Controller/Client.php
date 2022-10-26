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
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\HttpFoundation\Response;

/**
 * Class Client
 * @package GoogleUniversalAnalytics\Controller
 * @author manuel raynaud <mraynaud@openstudio.fr>
 */
class Client extends BaseFrontController
{
    public function saveAction(Request $request)
    {
        $clientId = $request->query->get('clientId');

        $request->getSession()->set(GoogleUniversalAnalytics::ANALYTICS_UA, $clientId);

        return new Response();
    }
}
