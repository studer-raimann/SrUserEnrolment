<?php

namespace srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Action\MoveToStep;

use srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Action\AbstractAction;

/**
 * Class MoveToStep
 *
 * @package srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Action\MoveToStep
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class MoveToStep extends AbstractAction
{

    const TABLE_NAME_SUFFIX = "mvtsp";
    /**
     * @var int
     *
     * @con_has_field    true
     * @con_fieldtype    integer
     * @con_length       8
     * @con_is_notnull   true
     */
    protected $move_to_step_id = 0;


    /**
     * @inheritDoc
     */
    public function getActionDescription() : string
    {
        $descriptions = [];

        $step = self::srUserEnrolment()->enrolmentWorkflow()->steps()->getStepById($this->move_to_step_id);
        if ($step !== null) {
            $descriptions[] = $step->getTitle();
        }

        return nl2br(implode("\n", $descriptions), false);
    }


    /**
     * @return int
     */
    public function getMoveToStepId() : int
    {
        return $this->move_to_step_id;
    }


    /**
     * @param int $move_to_step_id
     */
    public function setMoveToStepId(int $move_to_step_id)/* : void*/
    {
        $this->move_to_step_id = $move_to_step_id;
    }
}