<?php
namespace app\enums;

/**
 *
 * @tutorial Class Work:
 * @author Rodolfo Perez ~ pipo6280@gmail.com
 * @since oct 17, 2016
 */
class ERedSocial extends AEnum
{

    protected static $array = array();

    const FACEBOOK = 'N_1';

    const TWITTER = 'N_2';

    const LINKEDIN = 'N_3';

    const YOUTUBE = 'N_4';

    const SKYPE = 'N_5';

    const GOOGLEPLUS = 'N_6';

    const FLICKR = 'N_7';

    const pinterest = 'N_8';

    /**
     *
     * @tutorial initializes the values ​​listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return void
     */
    protected static function values()
    {
        static::$array[static::FACEBOOK] = new ERedSocial(1, 'Facebook', 'facebook', 'fa fa-facebook');
        static::$array[static::TWITTER] = new ERedSocial(2, 'Twitter', 'twitter', 'fa fa-twitter');
        static::$array[static::LINKEDIN] = new ERedSocial(3, 'Linkedin', 'linkedin', 'fa fa-linkedin');
        static::$array[static::YOUTUBE] = new ERedSocial(4, 'Youtube', 'youtube', 'fa fa-youtube-play');
        static::$array[static::SKYPE] = new ERedSocial(5, 'Skype', 'skype', 'fa fa-skype');
        static::$array[static::GOOGLEPLUS] = new ERedSocial(6, 'Googleplus', 'googleplus', 'fa fa-google-plus');
        static::$array[static::FLICKR] = new ERedSocial(7, 'Flickr', 'flickr', 'fa fa-flickr');
        static::$array[static::pinterest] = new ERedSocial(8, 'Pinterest', 'pinterest', 'fa fa-pinterest');
    }

    /**
     *
     * @tutorial search for ERedesSociales index
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return AEnum
     */
    public static function index($search)
    {
        static::values();
        return static::$array[$search];
    }

    /**
     *
     * @tutorial get result of the ERedesSociales values
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @param string $search            
     * @return Ambigous <\app\enums\ERedesSociales, AEnum>
     */
    public static function result($search)
    {
        static::values();
        $result = new ERedSocial(NULL, NULL);
        foreach (static::$array as $dato) {
            if ($dato->getId() == $search) {
                $result = $dato;
                break;
            }
        }
        return $result;
    }

    /**
     *
     * @tutorial get data values ERedesSociales listed
     * @author Rodolfo Perez ~ pipo6280@gmail.com
     * @since {20/09/2015}
     * @return array
     */
    public static function data()
    {
        static::values();
        return static::$array;
    }
}