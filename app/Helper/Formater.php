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

    /**
     * 
     * format date for db
     * 
     * @param string $date
     * @return ?string
     */
    public static function formatDateForDb(?string $date): ?string
    {
        if($date) return (new \DateTime($date))->format('Y-m-d h:i:s');
        else return null;
    }

    /**
     * 
     * format date like x days ago
     * 
     * @param string $date
     * @return ?string
     */
    public static function formatDateLikeXDaysAgo(?string $date): ?string
    {
        if($date) {
            $date = new \DateTime($date, new \DateTimeZone('Africa/Addis_Ababa'));
            $now = new \DateTime();
            $now->setTimezone(new \DateTimeZone('Africa/Addis_Ababa'));
            $diff = $now->diff($date);
            if($diff->y > 0) return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
            else if($diff->m > 0) return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
            else if($diff->d > 0) return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
            else if($diff->h > 0) return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
            else if($diff->i > 0) return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
            else return $diff->s . ' second' . ($diff->s > 1 ? 's' : '') . ' ago';
        }
        else return null;
    }

    /**
     * 
     * date format for post M d [at] h:i A
     * 
     */
    public static function formatDatePost(?string $date): string
    {
        if($date) return (new \DateTime($date))->format('M d \a\t h:i a');
        else return '-';
    }

    /**
     * 
     * date format for post h:i A
     * 
     */
    public static function formatTime(?string $date): string
    {
        if($date) return (new \DateTime($date))->format('h:i a');
        else return '-';
    }
}