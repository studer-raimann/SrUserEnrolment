<?php

namespace srag\RequiredData\SrUserEnrolment\Field\Field\Group\Form;

use srag\RequiredData\SrUserEnrolment\Field\Field\Group\GroupField;
use srag\RequiredData\SrUserEnrolment\Field\Field\Group\GroupsCtrl;
use srag\RequiredData\SrUserEnrolment\Field\FieldCtrl;
use srag\RequiredData\SrUserEnrolment\Field\Form\AbstractFieldFormBuilder;

/**
 * Class GroupFieldFormBuilder
 *
 * @package srag\RequiredData\SrUserEnrolment\Field\Field\Group\Form
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class GroupFieldFormBuilder extends AbstractFieldFormBuilder
{

    /**
     * @var GroupField
     */
    protected $field;


    /**
     * @inheritDoc
     */
    public function __construct(FieldCtrl $parent, GroupField $field)
    {
        parent::__construct($parent, $field);
    }


    /**
     * @inheritDoc
     */
    public function render() : string
    {
        GroupsCtrl::addTabs();

        return parent::render();
    }
}
