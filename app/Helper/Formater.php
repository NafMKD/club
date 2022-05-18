<?php 

declare(strict_types=1);

namespace App\Helper;

class Formater
{
    /**
     * 
     * format date to M d, Y at h:i A
     * 
     * @param string $date
     * @return string
     */
    public static function formatDate(?string $date): string
    {
        if($date) return (new \DateTime($date))->format('M d, Y \a\t h:i a');
        else return '-';
    }

    /**
     * 
     * format date to M, Y
     * 
     * @param string $date
     * @return string
     */
    public static function formatMonthYear(?string $date): string
    {
        if($date) return (new \DateTime($date))->format('M, Y');
        else return '-';
    }
}