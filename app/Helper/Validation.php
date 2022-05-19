<?php 

declare(strict_types=1);

namespace App\Helper;

class Validation
{
    /**
     * 
     * check if the input is empty
     * 
     * @param string $input
     * @return boolean
     */
    public static function isEmpty(string $input): bool
    {
        return empty($input);
    }

    /**
     * 
     * check if the input is a valid username   (a-z, A-Z, 0-9, _, -)
     * 
     * @param string $input
     * @return boolean
     */
    public static function isValidUsername(string $input): bool|int
    {
        return preg_match('/^[a-zA-Z0-9_-]*$/', $input);
    }

    /**
     * 
     * check if the input is a valid password   (a-z, A-Z, 0-9, _, -)
     * 
     * @param string $input
     * @return boolean
     */
    public static function isValidPassword(string $input): bool|int
    {
        return preg_match('/^[a-zA-Z0-9_-]*$/', $input);
    }

    /**
     * 
     * check if the file is a valid image
     * 
     * @param string $input
     * @return boolean
     */
    public static function isValidImage(string $input): bool|int
    {
        return preg_match('/^image\/(jpeg|png|gif)$/', $input);
    }

    /**
     * 
     * check date range
     * 
     * @param string $start_date
     * @param string $end_date
     * @return bool
     */
    public static function checkDateRange(?string $start_date, ?string $end_date): bool
    {
        if($start_date && $end_date) return (new \DateTime($start_date))->format('Y-m-d') <= (new \DateTime($end_date))->format('Y-m-d');
        else return false;
    }

    /**
     * 
     * check start date
     * 
     * @param string $start_date
     * @return bool
     */
    public static function checkStartDate(?string $start_date): bool
    {
        if($start_date) return (new \DateTime($start_date))->format('Y-m-d') >= (new \DateTime())->format('Y-m-d');
        else return false;
    }

}