<?php
/*************************************************************************************/
/*      This file is part of the module CustomerFamily                               */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace CustomerFamily\Form;

use CustomerFamily\CustomerFamily;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Symfony\Component\Validator\Constraints\Callback;
use Thelia\Model\LangQuery;

/**
 * Class CustomerFamilyExportForm
 * @package CustomerFamily\Form
 */
class CustomerFamilyExportForm extends BaseForm
{
    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return 'customer_family_export_form';
    }

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'productref',
                'text',
                array(
                    'constraints' => array(
                        new NotBlank()
                    ),
                    'required' => true,
                    'empty_data' => false,
                    'label' => Translator::getInstance()->trans(
                        'Product Reference',
                        array(),
                        CustomerFamily::MESSAGE_DOMAIN
                    ),
                    'label_attr' => array(
                        'for' => 'productref'
                    )
                )
            )
            ;
    }
}
