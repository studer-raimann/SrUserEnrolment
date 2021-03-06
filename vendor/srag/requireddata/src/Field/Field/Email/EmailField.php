<?php

namespace srag\RequiredData\SrUserEnrolment\Field\Field\Email;

use srag\RequiredData\SrUserEnrolment\Field\Field\Text\TextField;

/**
 * Class EmailField
 *
 * @package srag\RequiredData\SrUserEnrolment\Field\Field\Email
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class EmailField extends TextField
{

    const TABLE_NAME_SUFFIX = "eml";


    /**
     * @inheritDoc
     */
    public function supportsMultiLang() : bool
    {
        return false;
    }
}
