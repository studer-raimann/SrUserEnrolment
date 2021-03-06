<?php

namespace srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Rule\Fields\Value;

use ilTextInputGUI;
use srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Rule\RulesGUI;

/**
 * Trait ValueFormGUI
 *
 * @package srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Rule\Fields\Value
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait ValueFormGUI
{

    /**
     * @return array
     */
    protected function getValueFormFields() : array
    {
        return [
            "value" => [
                self::PROPERTY_CLASS    => ilTextInputGUI::class,
                self::PROPERTY_REQUIRED => true,
                "setTitle"              => self::plugin()->translate("value", RulesGUI::LANG_MODULE)
            ]
        ];
    }
}
