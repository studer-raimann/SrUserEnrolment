<?php

namespace srag\ActiveRecordConfig\SrUserEnrolment;

use srag\CustomInputGUIs\SrUserEnrolment\TableGUI\TableGUI;

/**
 * Class ActiveRecordConfigTableGUI
 *
 * @package srag\ActiveRecordConfig\SrUserEnrolment
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @deprecated
 */
abstract class ActiveRecordConfigTableGUI extends TableGUI
{

    /**
     * @var string
     *
     * @deprecated
     */
    const LANG_MODULE = ActiveRecordConfigGUI::LANG_MODULE_CONFIG;
    /**
     * @var ActiveRecordConfigGUI
     *
     * @deprecated
     */
    protected $parent_obj;
    /**
     * @var string
     *
     * @deprecated
     */
    protected $tab_id;


    /**
     * ActiveRecordConfigTableGUI constructor
     *
     * @param ActiveRecordConfigGUI $parent
     * @param string                $parent_cmd
     * @param string                $tab_id
     *
     * @deprecated
     */
    public function __construct(
        ActiveRecordConfigGUI $parent, /*string*/
        $parent_cmd, /*string*/
        $tab_id
    ) {
        $this->tab_id = $tab_id;

        parent::__construct($parent, $parent_cmd);
    }


    /**
     * @inheritdoc
     *
     * @deprecated
     */
    protected function initFilterFields()/*: void*/
    {
        $this->setFilterCommand(ActiveRecordConfigGUI::CMD_APPLY_FILTER . "_" . $this->tab_id);
        $this->setResetCommand(ActiveRecordConfigGUI::CMD_RESET_FILTER . "_" . $this->tab_id);
    }


    /**
     * @inheritdoc
     *
     * @deprecated
     */
    protected function initId()/*: void*/
    {

    }


    /**
     * @inheritdoc
     *
     * @deprecated
     */
    protected function initTitle()/*: void*/
    {
        $this->setTitle($this->txt($this->tab_id));
    }
}
