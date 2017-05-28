<?php
    
    /**
     *
     *   MasterCMS
     *
     *   Copyright (c) 2017 MasterCMS
     *
     *   @author <Denzel Code>
     *   -------------------------------------------------------------------------
     *   Licensed under the Apache License, Version 2.0 (the "License");
     *   you may not use this file except in compliance with the License.
     *   You may obtain a copy of the License at
     *
     *       http://www.apache.org/licenses/LICENSE-2.0
     *
     *   Unless required by applicable law or agreed to in writing, software
     *   distributed under the License is distributed on an "AS IS" BASIS,
     *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     *   See the License for the specific language governing permissions and
     *   limitations under the License.
     *   -------------------------------------------------------------------------
    */

    namespace MasterCMS\Config;

    class Config {

        public $select = array (
            // Web
            'WEB' => [
                'NAME'          =>          'MasterCMS',
                'TYPE_HTTP'     =>          TYPE_HTTP,
                'URL'           =>          URL,
                'CLIENT_URL'    =>          TYPE_HTTP . URL . '/web/client',
                'LANG'          =>          'ES', // Don't move if you dont't know what you do.
                'HK_LANG'       =>          'ES' // Don't move if you dont't know what you do.
            ],

            // CDNS
            'CDN' => [
                'TYPE_HTTP'     =>          TYPE_HTTP,
                'URL'           =>          URL,
                'HK'            =>          'Resources/Hk',
                'RUTE'          =>          MAIN_ROOT . 'Resources',
                'SWF'           => [
                    'TYPE_HTTP'     =>      TYPE_HTTP,
                    'URL'           =>      URL,
                    'WEB_RUTE'      =>      'Resources/SWF',
                    'DIR_RUTE'      =>      MAIN_ROOT . 'Resources' . DS . 'SWF',
                    'WEB_BADGES'    =>      'c_images/album1584',
                    'DIR_BADGES'    =>      'c_images' . DS . 'album1584',
                    'DIR_MPUS'      =>      'c_images' . DS . 'MPUS',
                    'WEB_MPUS'      =>      'c_images/MPUS',
                    'FLASH_TEXTS'   =>      'gamedata' . DS . 'external_flash_texts.txt'
                ],
            ],

            // Social Networks Login
            'SOCIAL_NETWORKS_LOGIN' => [
                'FACEBOOK'      =>           [
                    'APP_ID'      =>           '',
                    'APP_SECRET'  =>           ''
                ]
            ],

            // Whitelisted Staffs for client
            'WHITE_LIST_STAFFS' => [
                'STATUS' => 0,
                'USERS' => 'LxBlack' // Comma separated
            ],

            // Default Configuration
            # Config this before install the DB
            'DEFAULT_DB_CONFIG' => [
                // Web
                'TEMPLATE_NAME'             =>          'Darker',
                'MAINTENANCE'               =>          '0',
                'MAINTENANCE_DESCRIPTION'   =>          '<p>{@name} is comming!</p>',
                'COLORS'                    =>          '#009688, #4caf50, #6946a7, #2196f3, #e8971e, #ec4134',
                'LOGO'                      =>          '{@cdn}/images/logo.png',
                'HABBO_IMG'                 =>          'http://www.habbo.es/habbo-imaging/avatarimage?figure=',
                // Housekeeping
                'SUPER_USERS'               =>          'LxBlack, Yonier', // Comma separated
                'MIN_RANK'                  =>          '4, 5, 6',
                'MEDIUM_RANK'               =>          '7, 8',
                'MAX_RANK'                  =>          '9, 10',
                // Social Networks
                'FACEBOOK'                  =>          'Denzel-Code-249037048887248',
                'TWITTER'                   =>          'UbblyServer',
                'INSTAGRAM'                 =>          'denzelcode',
                // Optional Things          
                'RADIO'                     =>          'http://example.com/radio.mp3'
            ],

            // PayMents
            'PAYMENTS' => [
                'PAYPAL'         =>      'usubbly@gmail.com'
            ],

            // Register Options
            'USER_REGISTER' => [
                'MAX_ACCOUNTS'   =>      '5',
                'MOTTO'          =>      'I love MasterCMS :3',
                'CREDITS'        =>      '99999',
                'DUCKETS'        =>      '0',
                'DIAMONDS'       =>      '0',
                'HOME_ROOM'      =>      '0'
            ],

            // Client
            'CLIENT' => [
                'HOST'                      =>          'localhost',
                'PORT'                      =>          '30002',
                'EXTERNAL_VARIABLES'        =>          'http://swf.ubbly.es/gamedata/external_variables.txt',
                'EXTERNAL_FLASH_TEXTS'      =>          'http://swf.ubbly.es/gamedata/external_flash_texts.txt',
                'OVERRIDE_TEXTS'            =>          'http://swf.ubbly.es/gamedata/override/external_flash_override_texts.txt',
                'OVERRIDE_VARIABLES'        =>          'http://swf.ubbly.es/gamedata/override/external_override_variables.txt',
                'PRODUCTDATA'               =>          'http://swf.ubbly.es/gamedata/productdata.txt',
                'FURNIDATA'                 =>          'http://swf.ubbly.es/gamedata/furnidata.xml',
                'FIGUREDATA'                =>          'http://swf.ubbly.es/gamedata/figuredata.xml',
                'FIGUREMAP'                 =>          'http://swf.ubbly.es/gamedata/figuremap.xml',
                'HOTELVIEW_BANNER'          =>          'http://swf.ubbly.es/gamedata/supersecret.txt', 
                'FLASH_CLIENT_URL'          =>          'http://swf.ubbly.es/gordon/PRODUCTION-OFICIAL/',
                'HABBO_SWF'                 =>          'Pixel.swf'
            ],

        );

    }

?>
