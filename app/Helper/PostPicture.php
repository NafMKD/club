<?php

declare(strict_types=1);

namespace App\Helper;

class PostPicture
{
    /**
     * 
     * show one picture
     * 
     * @param array $image
     * @param string $path
     * 
     * @return string
     */
    public static function showOnePicture(array $image, string $path): string
    {
        if ($image && file_exists($path . $image[0]->file_url)) {
            return '<img src="' . $path . $image[0]->file_url . '" alt="post_img" />';
        }
        return '';
    }

    /**
     * 
     * show two pictures
     * 
     * @param array $image
     * @param string $path
     * 
     * @return string
     */
    public static function showTwoPictures(array $image, string $path): string
    {
        if ($image && file_exists($path . $image[0]->file_url) && file_exists($path . $image[1]->file_url)) {
            return '
            <div class="row mb-3">
                <div class="col-sm-6">
                    <img class="img-fluid" src="' . $path . $image[0]->file_url . '" alt="Photo">
                </div>
                <div class="col-sm-6">
                    <img class="img-fluid mb-3" src="' . $path . $image[1]->file_url . '" alt="Photo">                        
                </div>
            </div> 
            ';
        }
        return '';
    }

    /**
     * 
     * show three pictures
     * 
     * @param array $image
     * @param string $path
     * 
     * @return string
     */
    public static function showThreePictures(array $image, string $path): string
    {
        if ($image && file_exists($path . $image[0]->file_url) && file_exists($path . $image[1]->file_url) && file_exists($path . $image[2]->file_url)) {
            return '
            <div class="row mb-3">
                <div class="col-sm-6">
                    <img class="img-fluid" src="' . $path . $image[0]->file_url . '" alt="Photo">
                </div>
                <div class="col-sm-6">
                    <img class="img-fluid mb-3" src="' . $path . $image[1]->file_url . '" alt="Photo">                        
                </div>
                <div class="col-sm-12">
                    <img class="img-fluid" src="' . $path . $image[2]->file_url . '" alt="Photo">
                </div>
            </div> 
            ';
        }
        return '';
    }

    /**
     * 
     * show four pictures
     * 
     * @param array $image
     * @param string $path
     * 
     * @return string
     */
    public static function showFourPictures(array $image, string $path): string
    {
        if ($image && file_exists($path . $image[0]->file_url) && file_exists($path . $image[1]->file_url) && file_exists($path . $image[2]->file_url) && file_exists($path . $image[3]->file_url)) {
            return '
            <div class="row mb-3">
                <div class="col-sm-6">
                    <img class="img-fluid" src="' . $path . $image[0]->file_url . '" alt="Photo">
                </div>
                <div class="col-sm-6">
                    <img class="img-fluid mb-3" src="' . $path . $image[1]->file_url . '" alt="Photo">                                
                </div>
                <div class="col-sm-6">
                    <img class="img-fluid" src="' . $path . $image[2]->file_url . '" alt="Photo">
                </div>
                <div class="col-sm-6">
                    <img class="img-fluid" src="' . $path . $image[3]->file_url . '" alt="Photo">
                </div>
            </div> 
            ';
        }
        return '';
    }

    /**
     * 
     * show five pictures
     * 
     * @param array $image
     * @param string $path
     * 
     * @return string
     */
    public static function showFivePictures(array $image, string $path): string
    {
        if ($image && file_exists($path . $image[0]->file_url) && file_exists($path . $image[1]->file_url) && file_exists($path . $image[2]->file_url) && file_exists($path . $image[3]->file_url) && file_exists($path . $image[4]->file_url)) {
            return '
            <div class="row mb-3">
                <div class="col-sm-6">
                    <img class="img-fluid" src="' . $path . $image[0]->file_url . '" alt="Photo">
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <img class="img-fluid mb-3" src="' . $path . $image[1]->file_url . '" alt="Photo">
                            <img class="img-fluid" src="' . $path . $image[2]->file_url . '" alt="Photo">
                        </div>
                        <div class="col-sm-6">
                            <img class="img-fluid mb-3" src="' . $path . $image[3]->file_url . '" alt="Photo">
                            <img class="img-fluid" src="' . $path . $image[4]->file_url . '" alt="Photo">
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
        return '';
    }
}
