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
   
    $smtp = array (

        // SMTP Servers
        'SMTP' => [
            'MAILS' => [
                'PRINCIPAL'        => [
                    'HOST'          =>          'smtp.gmail.com',
                    'PORT'          =>          465,
                    'USER'          =>          'master@example.com',
                    'PASS'          =>          '',
                    'FROM'          =>          'master@example.com',
                    'NAME'          =>          'MasterCMS',
                    'MAILER'        =>          'smtp',
                    'SMTP_SECURE'   =>          'ssl',
                ],

                'CONTACT'          => [
                    'HOST'          =>          'smtp.gmail.com',
                    'PORT'          =>          465,
                    'USER'          =>          'master@example.com',
                    'PASS'          =>          '',
                    'FROM'          =>          'master@example.com',
                    'NAME'          =>          'MasterCMS Contact',
                    'MAILER'        =>          'smtp',
                    'SMTP_SECURE'   =>          'ssl',
                ],
                
                'SUPPORT'          => [
                    'HOST'          =>          'smtp.gmail.com',
                    'PORT'          =>          465,
                    'USER'          =>          'master@example.com',
                    'PASS'          =>          '',
                    'FROM'          =>          'master@example.com',
                    'NAME'          =>          'MasterCMS Support',
                    'MAILER'        =>          'smtp',
                    'SMTP_SECURE'   =>          'ssl',
                ],
            ],
        ],

    );

?>