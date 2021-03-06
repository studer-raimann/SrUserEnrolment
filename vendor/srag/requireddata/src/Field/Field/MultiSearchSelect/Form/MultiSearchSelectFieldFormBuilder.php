<?php

namespace srag\RequiredData\SrUserEnrolment\Field\Field\MultiSearchSelect\Form;

use srag\RequiredData\SrUserEnrolment\Field\Field\MultiSearchSelect\MultiSearchSelectField;
use srag\RequiredData\SrUserEnrolment\Field\Field\MultiSelect\Form\MultiSelectFieldFormBuilder;
use srag\RequiredData\SrUserEnrolment\Field\FieldCtrl;

/**
 * Class MultiSearchSelectFieldFormBuilder
 *
 * @package srag\RequiredData\SrUserEnrolment\Field\Field\MultiSearchSelect\Form
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class MultiSearchSelectFieldFormBuilder extends MultiSelectFieldFormBuilder
{

    /**
     * @var MultiSearchSelectField
     */
    protected $field;


    /**
     * @inheritDoc
     */
    public function __construct(FieldCtrl $parent, MultiSearchSelectField $field)
    {
        parent::__construct($parent, $field);
    }
}
