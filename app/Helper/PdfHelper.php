<?php

/**
 * The helper library class for Data related functionality
 *
 *
 * @author 
 * @package Admin
 * @since 1.0
 */

namespace App\Helper;

use Exception;
use DB;
// use Barryvdh\DomPDF\PDF;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade as PDF;


class PdfHelper
{

    /**
     * To Generate PDF
     *
     */
    public static function generatePDF($html, $filePath, $fileName)
    {
        try {

            $emailText = $html;
            $emailTemplate = $emailText;
            $filepath = $filePath;
            $filename = $fileName;
            $finalFileNameWithPath = $filepath . $filename . '.pdf';
            PDF::setOptions(['isRemoteEnabled' => true])->loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false)->save($finalFileNameWithPath);

            if (file_exists($finalFileNameWithPath)) {
                //send mail of newly generated quotation pdf.
                $emailParams['finalFileNameWithPath'] = $finalFileNameWithPath;

                return 1; //generated successfully

            } else {
                return 0; //not generated successfully  
            }
        } catch (Exception $e) {
            return 0; //not generated successfully  
        }
    }

    //generate random numbers for unique invoice number
    public static function randomNumber($length)
    {
        $digits = '';
        $numbers = range(0, 9);
        shuffle($numbers);
        for ($i = 0; $i < $length; $i++)
            $digits .= $numbers[$i];
        return $digits;
    }
}
