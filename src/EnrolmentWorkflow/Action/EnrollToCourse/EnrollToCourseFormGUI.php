<?php

namespace srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Action\EnrollToCourse;

use srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Action\AbstractActionFormGUI;
use srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Action\ActionGUI;

/**
 * Class EnrollToCourseFormGUI
 *
 * @package srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Action\EnrollToCourse
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class EnrollToCourseFormGUI extends AbstractActionFormGUI
{

    /**
     * @var EnrollToCourse
     */
    protected $action;


    /**
     * @inheritDoc
     */
    public function __construct(ActionGUI $parent, EnrollToCourse $action)
    {
        parent::__construct($parent, $action);
    }


    /**
     * @inheritDoc
     */
    protected function initFields()/*:void*/
    {
        parent::initFields();

        $this->fields = array_merge($this->fields, []);
    }
}
