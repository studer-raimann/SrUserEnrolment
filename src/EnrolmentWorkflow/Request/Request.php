<?php

namespace srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Request;

use ActiveRecord;
use arConnector;
use ilDatePresentation;
use ilDateTime;
use ilObject;
use ilObjectFactory;
use ilObjUser;
use ilSrUserEnrolmentPlugin;
use srag\DIC\SrUserEnrolment\DICTrait;
use srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Step\Step;
use srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Workflow\Workflow;
use srag\Plugins\SrUserEnrolment\Utils\SrUserEnrolmentTrait;

/**
 * Class Request
 *
 * @package srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Request
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Request extends ActiveRecord
{

    use DICTrait;
    use SrUserEnrolmentTrait;
    const TABLE_NAME = "srusrenr_request";
    const PLUGIN_CLASS_NAME = ilSrUserEnrolmentPlugin::class;


    /**
     * @return string
     */
    public function getConnectorContainerName()
    {
        return self::TABLE_NAME;
    }


    /**
     * @return string
     *
     * @deprecated
     */
    public static function returnDbTableName()
    {
        return self::TABLE_NAME;
    }


    /**
     * @var int
     *
     * @con_has_field    true
     * @con_fieldtype    integer
     * @con_length       8
     * @con_is_notnull   true
     * @con_is_primary   true
     * @con_sequence     true
     */
    protected $request_id;
    /**
     * @var int
     *
     * @con_has_field    true
     * @con_fieldtype    integer
     * @con_length       8
     * @con_is_notnull   true
     */
    protected $obj_ref_id;
    /**
     * @var int
     *
     * @con_has_field    true
     * @con_fieldtype    integer
     * @con_length       8
     * @con_is_notnull   true
     */
    protected $obj_id;
    /**
     * @var int
     *
     * @con_has_field    true
     * @con_fieldtype    integer
     * @con_length       8
     * @con_is_notnull   true
     */
    protected $step_id;
    /**
     * @var int
     *
     * @con_has_field    true
     * @con_fieldtype    integer
     * @con_length       8
     * @con_is_notnull   true
     */
    protected $user_id;
    /**
     * @var bool
     *
     * @con_has_field    true
     * @con_fieldtype    integer
     * @con_length       1
     * @con_is_notnull   true
     */
    protected $accepted = false;
    /**
     * @var int[]
     *
     * @con_has_field    true
     * @con_fieldtype    text
     * @con_is_notnull   true
     */
    protected $responsible_users = [];
    /**
     * @var int
     *
     * @con_has_field    true
     * @con_fieldtype    integer
     * @con_length       8
     * @con_is_notnull   true
     */
    protected $create_time;


    /**
     * Request constructor
     *
     * @param int              $primary_key_value
     * @param arConnector|null $connector
     */
    public function __construct(/*int*/ $primary_key_value = 0, arConnector $connector = null)
    {
        parent::__construct($primary_key_value, $connector);
    }


    /**
     * @return ilObject
     */
    public function getObject() : ilObject
    {
        return ilObjectFactory::getInstanceByRefId($this->obj_ref_id, false);
    }


    /**
     * @return Workflow|null
     */
    public function getWorkflow()/*:?Workflow*/
    {
        return self::srUserEnrolment()->enrolmentWorkflow()->workflows()->getWorkflowById($this->getStep()->getWorkflowId());
    }


    /**
     * @return Step|null
     */
    public function getStep()/*:?Step*/
    {
        return self::srUserEnrolment()->enrolmentWorkflow()->steps()->getStepById($this->step_id);
    }


    /**
     * @return ilObjUser
     */
    public function getUser() : ilObjUser
    {
        return new ilObjUser($this->user_id);
    }


    /**
     * @return array
     */
    public function getRequiredData() : array
    {
        return self::srUserEnrolment()->requiredData()->fills()->getFillValues($this->request_id);
    }


    /**
     * @return array
     */
    public function getFormattedRequiredData() : array
    {
        return self::srUserEnrolment()
            ->requiredData()
            ->fills()
            ->formatAsStrings(Step::REQUIRED_DATA_PARENT_CONTEXT_STEP, $this->step_id, $this->getRequiredData());
    }


    /**
     * @return string
     */
    public function getFormattedCreatedTime() : string
    {
        return ilDatePresentation::formatDate(new ilDateTime($this->create_time, IL_CAL_UNIX));
    }


    /**
     * @return ilObjUser[]
     */
    public function getFormattedResponsibleUsers() : array
    {
        return array_combine($this->responsible_users, array_map(function (int $responsible_user_id) : ilObjUser {
            return new ilObjUser($responsible_user_id);
        }, $this->responsible_users));
    }


    /**
     * @param string $field_name
     *
     * @return mixed|null
     */
    public function sleep(/*string*/ $field_name)
    {
        $field_value = $this->{$field_name};

        switch ($field_name) {
            case "accepted":
                return ($field_value ? 1 : 0);

            case "responsible_users":
                return json_encode($field_value);

            default:
                return null;
        }
    }


    /**
     * @param string $field_name
     * @param mixed  $field_value
     *
     * @return mixed|null
     */
    public function wakeUp(/*string*/ $field_name, $field_value)
    {
        switch ($field_name) {
            case "accepted":
                return boolval($field_value);

            case "responsible_users":
                return json_decode($field_value);

            default:
                return null;
        }
    }


    /**
     * @return int
     */
    public function getRequestId() : int
    {
        return $this->request_id;
    }


    /**
     * @param int $request_id
     */
    public function setRequestId(int $request_id)/* : void*/
    {
        $this->request_id = $request_id;
    }


    /**
     * @return int
     */
    public function getObjRefId() : int
    {
        return $this->obj_ref_id;
    }


    /**
     * @param int $obj_ref_id
     */
    public function setObjRefId(int $obj_ref_id)/* : void*/
    {
        $this->obj_ref_id = $obj_ref_id;
    }


    /**
     * @return int
     */
    public function getObjId() : int
    {
        return $this->obj_id;
    }


    /**
     * @param int $obj_id
     */
    public function setObjId(int $obj_id)/* : void*/
    {
        $this->obj_id = $obj_id;
    }


    /**
     * @return int
     */
    public function getStepId() : int
    {
        return $this->step_id;
    }


    /**
     * @param int $step_id
     */
    public function setStepId(int $step_id)/* : void*/
    {
        $this->step_id = $step_id;
    }


    /**
     * @return int
     */
    public function getUserId() : int
    {
        return $this->user_id;
    }


    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id)/* : void*/
    {
        $this->user_id = $user_id;
    }


    /**
     * @return bool
     */
    public function isAccepted() : bool
    {
        return $this->accepted;
    }


    /**
     * @param bool $accepted
     */
    public function setAccepted(bool $accepted)/* : void*/
    {
        $this->accepted = $accepted;
    }


    /**
     * @return int[]
     */
    public function getResponsibleUsers() : array
    {
        return $this->responsible_users;
    }


    /**
     * @param int[] $responsible_users
     */
    public function setResponsibleUsers(array $responsible_users)/* : void*/
    {
        $this->responsible_users = $responsible_users;
    }


    /**
     * @return int
     */
    public function getCreateTime() : int
    {
        return $this->create_time;
    }


    /**
     * @param int $create_time
     */
    public function setCreateTime(int $create_time)/* : void*/
    {
        $this->create_time = $create_time;
    }
}