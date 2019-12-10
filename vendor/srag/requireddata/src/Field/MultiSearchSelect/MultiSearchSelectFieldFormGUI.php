<?php

namespace srag\RequiredData\SrUserEnrolment\Field\MultiSearchSelect;

use srag\RequiredData\SrUserEnrolment\Field\FieldCtrl;
use srag\RequiredData\SrUserEnrolment\Field\MultiSelect\MultiSelectFieldFormGUI;

/**
 * Class MultiSearchSelectFieldFormGUI
 *
 * @package srag\RequiredData\SrUserEnrolment\Field\MultiSearchSelect
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class MultiSearchSelectFieldFormGUI extends MultiSelectFieldFormGUI
{

    /**
     * @var MultiSearchSelectField
     */
    protected $object;


    /**
     * @inheritDoc
     */
    public function __construct(FieldCtrl $parent, MultiSearchSelectField $object)
    {
        parent::__construct($parent, $object);
    }
}