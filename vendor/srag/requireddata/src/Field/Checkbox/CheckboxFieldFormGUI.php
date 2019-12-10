<?php

namespace srag\RequiredData\SrUserEnrolment\Field\Checkbox;

use srag\RequiredData\SrUserEnrolment\Field\AbstractFieldFormGUI;
use srag\RequiredData\SrUserEnrolment\Field\FieldCtrl;

/**
 * Class CheckboxFieldFormGUI
 *
 * @package srag\RequiredData\SrUserEnrolment\Field\Checkbox
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class CheckboxFieldFormGUI extends AbstractFieldFormGUI
{

    /**
     * @var CheckboxField
     */
    protected $object;


    /**
     * @inheritDoc
     */
    public function __construct(FieldCtrl $parent, CheckboxField $object)
    {
        parent::__construct($parent, $object);
    }
}