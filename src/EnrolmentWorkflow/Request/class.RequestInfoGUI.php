<?php

namespace srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Request;

use ilObject;
use ilPersonalDesktopGUI;
use ilSrUserEnrolmentPlugin;
use ilSrUserEnrolmentUIHookGUI;
use ilTemplate;
use ilUIPluginRouterGUI;
use ilUtil;
use srag\DIC\SrUserEnrolment\DICTrait;
use srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Step\StepGUI;
use srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Step\StepsGUI;
use srag\Plugins\SrUserEnrolment\Utils\SrUserEnrolmentTrait;

/**
 * Class RequestInfoGUI
 *
 * @package           srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Request
 *
 * @author            studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @ilCtrl_isCalledBy srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Request\RequestInfoGUI: srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Request\RequestsGUI
 * @ilCtrl_isCalledBy srag\Plugins\SrUserEnrolment\EnrolmentWorkflow\Request\RequestInfoGUI: ilUIPluginRouterGUI
 */
class RequestInfoGUI
{

    use DICTrait;
    use SrUserEnrolmentTrait;
    const PLUGIN_CLASS_NAME = ilSrUserEnrolmentPlugin::class;
    const CMD_BACK = "back";
    const CMD_SHOW_WORKFLOW = "showWorkflow";
    const GET_PARAM_REQUEST_ID = "request_id";
    const TAB_WORKFLOW = "workflow";
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var bool
     */
    protected $single = true;


    /**
     * RequestInfoGUI constructor
     *
     * @param bool $single
     */
    public function __construct(bool $single = true)
    {
        $this->single = $single;
    }


    /**
     *
     */
    public function executeCommand()/*: void*/
    {
        $this->request = self::srUserEnrolment()->enrolmentWorkflow()->requests()->getRequestById(filter_input(INPUT_GET, self::GET_PARAM_REQUEST_ID));

        if (!self::srUserEnrolment()->enrolmentWorkflow()->requests()->hasRequestAccess($this->request, self::dic()->user()->getId())) {
            die();
        }

        self::dic()->ctrl()->saveParameter($this, self::GET_PARAM_REQUEST_ID);

        $this->setTabs();

        $next_class = self::dic()->ctrl()->getNextClass($this);

        switch (strtolower($next_class)) {
            case strtolower(AcceptRequestGUI::class):
                if (!$this->single) {
                    self::dic()->ctrl()->forwardCommand(new AcceptRequestGUI($this));
                }
                break;

            default:
                $cmd = self::dic()->ctrl()->getCmd();

                switch ($cmd) {
                    case self::CMD_BACK:
                    case self::CMD_SHOW_WORKFLOW:
                        $this->{$cmd}();
                        break;

                    default:
                        break;
                }
                break;
        }
    }


    /**
     * @return array
     */
    public static function addRequestsToPersonalDesktop() : array
    {
        $requests = array_reduce(self::srUserEnrolment()->enrolmentWorkflow()->requests()->getRequests(null, null, self::dic()->user()->getId()), function (array $requests, Request $request) : array {
            $requests[$request->getObjRefId()] = $request;

            return $requests;
        }, []);

        if (!empty($requests)) {
            $tpl = self::plugin()->template("EnrolmentWorkflow/pd_my_requests.html");

            $tpl->setVariable("MY_REQUESTS_TITLE", self::plugin()->translate("my_requests", RequestsGUI::LANG_MODULE));

            foreach ($requests as $request
            ) {
                /**
                 * @var Request $request
                 * @var Request $current_request
                 */

                self::dic()->ctrl()->setParameterByClass(self::class, self::GET_PARAM_REQUEST_ID, $request->getRequestId());

                $tpl->setVariable("LINK", self::dic()->ctrl()
                    ->getLinkTargetByClass([ilUIPluginRouterGUI::class, self::class], self::CMD_SHOW_WORKFLOW));

                $tpl->setVariable("OBJECT_TITLE", self::dic()->objDataCache()->lookupTitle($request->getObjId()));

                $tpl->setVariable("OBJECT_ICON", self::output()->getHTML(self::dic()->ui()->factory()->image()->standard(ilObject::_getIcon($request->getObjId()), "")));

                $current_request = current(self::srUserEnrolment()->enrolmentWorkflow()->requests()->getRequests($request->getObjRefId(), null, $request->getUserId(), null, null, null, false));
                if ($current_request !== false) {
                    $current_step = self::srUserEnrolment()->enrolmentWorkflow()->steps()->getStepById($current_request->getStepId());
                    $tpl->setVariable("CURRENT_STEP", self::plugin()->translate("step", StepsGUI::LANG_MODULE) . ": " . $current_step->getTitle());
                }

                $tpl->parseCurrentBlock();
            }

            return ["mode" => ilSrUserEnrolmentUIHookGUI::APPEND, "html" => self::output()->getHTML($tpl)];
        }

        return ["mode" => ilSrUserEnrolmentUIHookGUI::KEEP, "html" => ""];
    }


    /**
     *
     */
    protected function setTabs()/*: void*/
    {
        self::dic()->tabs()->clearTargets();

        self::dic()->mainTemplate()->setTitleIcon(ilObject::_getIcon("", "tiny",
            self::dic()->objDataCache()->lookupType(self::dic()->objDataCache()->lookupObjId($this->request->getObjRefId()))));

        self::dic()->mainTemplate()->setTitle(self::dic()->objDataCache()->lookupTitle(self::dic()->objDataCache()->lookupObjId($this->request->getObjRefId())));

        if ($this->single) {
            self::dic()->tabs()->setBackTarget(self::dic()->language()->txt("personal_desktop"), self::dic()->ctrl()
                ->getLinkTarget($this, self::CMD_BACK));
        } else {
            self::dic()->tabs()->setBackTarget(self::plugin()->translate("requests", RequestsGUI::LANG_MODULE), self::dic()->ctrl()
                ->getLinkTarget($this, self::CMD_BACK));
        }

        self::dic()->tabs()->addTab(self::TAB_WORKFLOW, $this->request->getWorkflow()->getTitle(), self::dic()->ctrl()
            ->getLinkTarget($this, self::CMD_SHOW_WORKFLOW));
    }


    /**
     *
     */
    protected function back()/*: void*/
    {
        if ($this->single) {
            self::dic()->ctrl()->redirectByClass(ilPersonalDesktopGUI::class);
        } else {
            self::dic()->ctrl()->redirectByClass(RequestsGUI::class, RequestsGUI::CMD_LIST_REQUESTS);
        }
    }


    /**
     *
     */
    protected function showWorkflow()/*: void*/
    {
        $steps = self::srUserEnrolment()->enrolmentWorkflow()->steps()->getSteps($this->request->getStep()->getWorkflowId());

        $workflow_list = '<ul>';

        foreach ($steps as $step) {
            $request = self::srUserEnrolment()->enrolmentWorkflow()->requests()->getRequest($this->request->getObjRefId(), $step->getStepId(), $this->request->getUserId());

            $text = '<div>' . $step->getTitle() . '</div>';

            if ($request !== null) {
                $text = self::output()->getHTML(self::dic()->ui()->factory()->image()->standard($request->isAccepted() ? ilUtil::getImagePath("icon_ok.svg") : ilUtil::getImagePath("icon_not_ok.svg"),
                        "")) . $text;

                if ($request->getRequestId() === $this->request->getRequestId()) {
                    $text = '<b>' . $text . '</b>';
                }

                self::dic()->ctrl()->setParameter($this, self::GET_PARAM_REQUEST_ID, $request->getRequestId());
                $text = self::output()->getHTML(self::dic()->ui()->factory()->link()->standard($text, self::dic()->ctrl()->getLinkTarget($this, self::CMD_SHOW_WORKFLOW)));
            } else {
                $text = '<span>' . $text . '</span>';
            }

            $workflow_list .= '<li>' . $text . '</li>';
        }
        self::dic()->ctrl()->setParameter($this, self::GET_PARAM_REQUEST_ID, filter_input(INPUT_GET, self::GET_PARAM_REQUEST_ID));

        $workflow_list .= '</ul>';

        // Can not use `ilChecklistGUI` because in `ilGroupedListGUI` links are top and nolinks bottom (because bad different `ilTemplate` block) and this will break the step sort
        $workflow_tpl = new ilTemplate("Services/UIComponent/Checklist/templates/default/tpl.checklist.html", true, true);
        $workflow_tpl->setVariable("LIST", $workflow_list);

        if (!$this->single) {
            $actions = [];

            foreach (self::srUserEnrolment()->enrolmentWorkflow()->steps()->getStepsForAcceptRequest($this->request, self::dic()->user()->getId()) as $step) {
                self::dic()->ctrl()->setParameterByClass(AcceptRequestGUI::class, StepGUI::GET_PARAM_STEP_ID, $step->getStepId());

                $actions[] = self::dic()->ui()->factory()->button()->shy($step->getActionAcceptTitle(), self::dic()->ctrl()
                    ->getLinkTargetByClass(AcceptRequestGUI::class, AcceptRequestGUI::CMD_ACCEPT_REQUEST));
            }

            self::dic()->mainTemplate()->setHeaderActionMenu(self::output()->getHTML(self::dic()->ui()->factory()->dropdown()->standard($actions)->withLabel(self::plugin()
                ->translate("actions", RequestsGUI::LANG_MODULE))));
        }

        self::output()->output([$workflow_tpl, self::dic()->ui()->factory()->listing()->descriptive($this->request->getFormattedRequiredData())], true);
    }


    /**
     * @return Request
     */
    public function getRequest() : Request
    {
        return $this->request;
    }
}
