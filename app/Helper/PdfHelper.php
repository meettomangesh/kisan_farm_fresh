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
use Storage;

class PdfHelper
{

    /**
     * To Generate PDF
     *
     */
    public static function generatePDF($html, $filePath, $fileName, $details = [])
    {
        try {

            $emailText = $html;
            $emailTemplate = $emailText;
            $filepath = $filePath;
            $filename = $fileName;
            $finalFileNameWithPath = $filepath . $filename . '.pdf';
            $path = '';
            PDF::setOptions(['isRemoteEnabled' => true])->loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false)->save($finalFileNameWithPath);
            if (file_exists($finalFileNameWithPath)) {
                //send mail of newly generated quotation pdf.
                $path = self::uploadInvoiceToS3($finalFileNameWithPath, $details);
                exit;
            } else {
                $path = ''; //not generated successfully  
            }
        } catch (Exception $e) {
            $path = '';
        }
        return $path;
    }


    public static function uploadInvoiceToS3($finalFileNameWithPath, $details)
    {   
        //create s3 object
        //$s3 = App::make('aws')->createClient('s3');
        $s3 = Storage::disk('s3');
        $path = $details['user_id'] . "/";
        $final_url = $path . $details['order_id'] . '.pdf';
        // $path = self::getBrandImageUploadFolder();
        // $milliseconds = round(microtime(true) * 1000);
        // $fileName = 'brand' . '-' . $milliseconds;
        // $fileExtension = self::getFileExtension($fileObj['name']);
        // $final_url = $path . $fileName . "." . $fileExtension;
        // $brandMediumImageWidth = 200;
        // $brandMediumImageHeight = 200;
        // $realPath = $fileObj['tmp_name'];
        try {

            // $fileNameMedium = $path . 'medium-brand' . '-' . $milliseconds . '.' . $fileExtension;
            // $imageMedium = Image::make($realPath)->resize($brandMediumImageWidth, $brandMediumImageHeight, function ($c) {
            //         $c->aspectRatio();
            //         $c->upsize();
            //     })->save('/tmp/medium-brand' . $milliseconds . $fileExtension);

            // $s3->put($fileNameMedium, file_get_contents('/tmp/medium-brand' . $milliseconds . $fileExtension), 'public');

            // $s3->put($final_url, file_get_contents($finalFileNameWithPath), 'public');
            $result = $s3->putObject([
                'Bucket' => 'kff-invoice-dev',
                'Key'    => $details['order_id'] . '.pdf',
                'Body'   => $finalFileNameWithPath,
                'ACL'    => 'public-read'
            ]);
            print_r($result);
            echo $result['ObjectURL'] . PHP_EOL; exit;
        } catch (Aws\Exception\S3Exception $e) {
            echo "There was an error uploading the file.\n";
        }
        return $path . $details['order_id'] . '.pdf';
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
