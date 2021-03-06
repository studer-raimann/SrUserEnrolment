<?php

namespace srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\RequiredData\Field\UserSelect;

use ilSrUserEnrolmentPlugin;
use srag\Plugins\SrUserEnrolment\Utils\SrUserEnrolmentTrait;
use srag\RequiredData\SrUserEnrolment\Field\Field\StaticMultiSearchSelect\StaticMultiSearchSelectFillField;

/**
 * Class UserSelectFillField
 *
 * @package srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\RequiredData\Field\UserSelect
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class UserSelectFillField extends StaticMultiSearchSelectFillField
{

    use SrUserEnrolmentTrait;

    const PLUGIN_CLASS_NAME = ilSrUserEnrolmentPlugin::class;
    /**
     * @var UserSelectField
     */
    protected $field;


    /**
     * @inheritDoc
     */
    public function __construct(UserSelectField $field)
    {
        parent::__construct($field);
    }
}
