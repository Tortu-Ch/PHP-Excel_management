<?php
/**
 * Created by PhpStorm.
 * User: DRAGON
 * Date: 6/8/2019
 * Time: 12:15 PM
 */

class CsvManager
{
    public function __construct()
    {

    }

    public  function fileRead($filename, $mode)
    {
        $data = null;
        if (($h = fopen($filename, $mode)) !== FALSE)
        {
            while (($get_data = fgetcsv($h, 1000, ",")) !== FALSE)
            {
                $data[] = $get_data;
            }
            fclose($h);
        }
        return $data;
    }

    public function fileUpdate($filename, $data)
    {
//        chmod($filename, 0777);
        if(count($data)>0) {
            if (($fp = fopen($filename, 'w')) !== FALSE) {
                foreach ($data as $row) {
                    fputcsv($fp, $row);
                }
                fclose($fp);
                return 'successfully updated.';
            }
        }
        return 'error. Please try again.';
    }

}