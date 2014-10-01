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

use GoogleUniversalAnalytics\Form\ConfigForm;
use GoogleUniversalAnalytics\GoogleUniversalAnalytics;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Model\ConfigQuery;
use Thelia\Tools\URL;

/**
 * Class ConfigController
 * @package GoogleUniversalAnalytics\Controller
 * @author manuel raynaud <mraynaud@openstudio.fr>
 */
class ConfigController extends BaseAdminController
{

    public function saveAction()
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, ['googleuniversalanalytics'], AccessManager::UPDATE)) {
            return $response;
        }

        $form = new ConfigForm($this->getRequest());
        $error_message = null;
        $response = null;
        try {
            $vform = $this->validateForm($form);

            ConfigQuery::write(GoogleUniversalAnalytics::ANALYTICS_UA, $vform->get('tracking_id')->getData(), 1, 1);

            $response = RedirectResponse::create(URL::getInstance()->absoluteUrl('/admin/module/GoogleUniversalAnalytics'));
        } catch (\Exception $e) {
            $error_message = $this->createStandardFormValidationErrorMessage($e);
        }

        if (null !== $error_message) {
            $this->setupFormErrorContext(
                'carousel upload',
                $error_message,
                $form
            );
            $response = $this->render(
                "module-configure",
                [
                    'module_code' => 'Carousel'
                ]
            );
        }
        return $response;
    }
}
