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

namespace GoogleUniversalAnalytics\Form;

use GoogleUniversalAnalytics\GoogleUniversalAnalytics;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Thelia\Model\ConfigQuery;


/**
 * Class ConfigForm
 * @package GoogleUniversalAnalytics\Form
 * @author manuel raynaud <mraynaud@openstudio.fr>
 */
class ConfigForm extends BaseForm
{

    /**
     *
     * in this function you add all the fields you need for your Form.
     * Form this you have to call add method on $this->formBuilder attribute :
     *
     * $this->formBuilder->add("name", "text")
     *   ->add("email", "email", array(
     *           "attr" => array(
     *               "class" => "field"
     *           ),
     *           "label" => "email",
     *           "constraints" => array(
     *               new \Symfony\Component\Validator\Constraints\NotBlank()
     *           )
     *       )
     *   )
     *   ->add('age', 'integer');
     *
     * @return null
     */
    protected function buildForm()
    {
        $this->formBuilder->add(
            'tracking_id',
            TextType::class,
            [
                'data' => ConfigQuery::read(GoogleUniversalAnalytics::ANALYTICS_UA, ''),
                'label' => Translator::getInstance()->trans("Tracking Code"),
                'label_attr' => array(
                    'for' => "trackingcode"
                ),
            ]
        );
    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public static function getName()
    {
        return "GUA_config";
    }
}
