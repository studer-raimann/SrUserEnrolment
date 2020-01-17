<?php

namespace srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Assistant;

use ilSrUserEnrolmentPlugin;
use srag\DIC\SrUserEnrolment\DICTrait;
use srag\Plugins\SrUserEnrolment\Utils\SrUserEnrolmentTrait;

/**
 * Class Factory
 *
 * @package srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Assistant
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Factory
{

    use DICTrait;
    use SrUserEnrolmentTrait;
    const PLUGIN_CLASS_NAME = ilSrUserEnrolmentPlugin::class;
    /**
     * @var self
     */
    protected static $instance = null;


    /**
     * @return self
     */
    public static function getInstance() : self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * Factory constructor
     */
    private function __construct()
    {

    }


    /**
     * @return Assistant
     */
    public function newInstance() : Assistant
    {
        $assistant = new Assistant();

        return $assistant;
    }


    /**
     * @param AssistantsGUI $parent
     * @param array         $assistants
     *
     * @return AssistantsFormGUI
     */
    public function newFormInstance(AssistantsGUI $parent, array $assistants) : AssistantsFormGUI
    {
        $form = new AssistantsFormGUI($parent, $assistants);

        return $form;
    }


    /**
     * @param AssistantsRequestGUI $parent
     * @param string               $cmd
     *
     * @return AssistantsRequestTableGUI
     */
    public function newRequestsTableInstance(AssistantsRequestGUI $parent, string $cmd = AssistantsRequestGUI::CMD_LIST_USERS) : AssistantsRequestTableGUI
    {
        $table = new AssistantsRequestTableGUI($parent, $cmd);

        return $table;
    }
}