<?php

namespace srag\DataTableUI\SrUserEnrolment\Implementation\Column\Formatter;

use srag\DataTableUI\SrUserEnrolment\Component\Column\Column;
use srag\DataTableUI\SrUserEnrolment\Component\Data\Row\RowData;
use srag\DataTableUI\SrUserEnrolment\Component\Format\Format;

/**
 * Class ImageFormatter
 *
 * @package srag\DataTableUI\SrUserEnrolment\Implementation\Column\Formatter
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ImageFormatter extends DefaultFormatter
{

    /**
     * @inheritDoc
     */
    public function formatRowCell(Format $format, $image, Column $column, RowData $row, string $table_id) : string
    {
        if (!empty($image)) {
            return self::output()->getHTML(self::dic()->ui()->factory()->image()->responsive($image, ""));
        } else {
            return "";
        }
    }
}
