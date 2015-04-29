<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function no_cache()
{
    header("Expires: Mon, 26 Jul 1990 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}

    
function site_data()
    {

        $data['_site_title']='Lightspeed To Xero';
        $data['_site_description']='Lightspeed To Xero';
        $data['_author']='Ariful Haque';

        $CI = get_instance();
        return $data;

    }// end site_data
    
    function getImagePath(){
        return base_url().'store/images/';
    }

    function getPaginationConfig(){
        $config=array();

        //$config['use_page_numbers'] = TRUE;


        $config['full_tag_open'] = '<ul class="pagination pagination-sm m-t-none m-b-none">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = ' <i title="First" class="fa  fa-angle-double-left"></i>';
        $config['first_tag_open'] = '<li class="first">';
        $config['first_tag_close'] = '</li>';

        $config['next_link'] = ' <i title="Next" class="">»</i>';
        $config['next_tag_open'] = '<li class="next">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = ' <i title="Previous" class="">«</i>';
        $config['prev_tag_open'] = '<li class="previous">';
        $config['prev_tag_close'] = '</li>';

        $config['last_link'] = '<i title="Last" class="fa fa-angle-double-right"></i>';
        $config['last_tag_open'] = '<li class="last">';
        $config['last_tag_close'] = '</li>';

        $config['cur_tag_open']='<li class="current"><a href="#">';
        $config['cur_tag_close']='</a><li>';
        $config['num_tag_open']='<li>';
        $config['num_tag_close']='</li>';

        return $config;

    }//end function

    /**
     * function:
     * @param type $type_id
     * @return string
     */
    function getUserType($type_id)
    {
        if($type_id==1){
            return 'Super User';
        }elseif($type_id==2){
            return 'Sales Consultant';
        }elseif($type_id==3){
            return 'Quotation Team';
        }elseif($type_id==4 ){
            return 'Accountant';
        }elseif($type_id==5 ){
            return 'External Agent';
        }

    }//end funcion

    /**
     *
     * @param type $key
     * @return type
     */
    function  getUserAccess($key)
    {
    switch ($key)
        {
            // Super User
            case 1:
                return array('user','user_add','user_edit','user_delete','user_view','user_change_pass',//user section
                             'quotation','quotation_all','quotation_add','quotation_edit','quotation_view','quotation_delete',//quotation
                             'qt_state_won','assign_commission', //Assigned Commission (in quotation)
                             'won_renew', 'won_export',  // Renewal & export of won deals
                             'css','css_add','css_edit','css_view','css_delete',  //css=Commission Schemes Structure (set commission)
                             'rec','rec_add','rec_edit','rec_view','rec_delete',  //Reconciliation
                             'cust','cust_add','cust_edit','cust_view','cust_delete'  //Customer
                            );
                break;

            // Sales Consultant
            case 2:
                return array(
                             'quotation','quotation_add','quotation_edit','quotation_view','quotation_delete',//quotation
                             'assign_commission', //Assigned Commission (in quotation)
                             'cust','cust_add','cust_edit','cust_view','cust_delete',  //Customer
                              'user_change_pass'
                            );
                break;

            // Quotation team
            case 3:
                return array(
                             'quotation','quotation_all','quotation_add','quotation_edit','quotation_view','quotation_delete',//quotation
                             'assign_commission', //Assigned Commission (in quotation)
                             'cust','cust_add','cust_edit','cust_view','cust_delete',  //Customer
                             'user_change_pass'
                            );
                break;

            // Accountant
            case 4:
                return array(
                             'quotation','quotation_all','quotation_add','quotation_edit','quotation_view','quotation_delete',//quotation
                             'qt_state_won','assign_commission', //Assigned Commission (in quotation)
                             'won_export',  // Renewal & export of won deals
                             'rec','rec_add','rec_edit','rec_view','rec_delete',  //Reconciliation
                             'cust','cust_add','cust_edit','cust_view','cust_delete',  //Customer
                            'user_change_pass'
                            );
                break;

            // External Agent
            case 5:
                return array('quotation','quotation_all','quotation_view', 'user_change_pass');
                break;

            default:
                return array('none');
                break;
        }
    }//end function
    
    function getMyYearDiff($_from){
        $datetime1 = new DateTime();
        $datetime2 = new DateTime(date('Y-m-d',$_from));//date('Y-m-d',$item['nd_dob']);
        $interval  = $datetime1->diff($datetime2);
        //$elapsed   = $interval->format('%y years, %m months, %a days, %h hours, %i minutes, %S seconds');
        $elapsed   = $interval->format('%y years, %m months');
        $elapsed = str_replace(array('0 years,', ' 0 months,', ' 0 days,', ' 0 hours,', ' 0 minutes,'), '', $elapsed);
        $elapsed = str_replace(array('1 years, ', ' 1 months, ', ' 1 days, ', ' 1 hours, ', ' 1 minutes'), array('1 year, ', '1 month, ', ' 1 day, ', ' 1 hour, ', ' 1 minute'), $elapsed);

        return $elapsed;
    }//end function
    
    function convertMyDate($date){
        //CONVERT FROM dd-mm-yyyy
        //conver to Y M D
        $showDate='';
        //echo 'date: '.$date.'<br>';
        if($date!=''){
            $_year  =substr($date,6,4);        
            $_month =substr($date,3,2);
            $_day =substr($date,0,2);

            $showDate=$_year.'-'.$_month.'-'.$_day;
        }
        return $showDate;
    }//end function
    
    function revertMyDate($date){
        //conver to Y M D
        $showDate='';
        //echo 'date: '.$date.'<br>';
        if($date!=''){
            $_year  =substr($date,0,4);        
            $_month =substr($date,5,2);
            $_day =substr($date,8,2);

            $showDate=$_day.'/'.$_month.'/'.$_year;
        }
        return $showDate;
    }//end function
    
    function getCountry(){
        $country=array(
        "SG"=>'Singapore',
        "AF"=>'Afghanistan',"AX"=>'Åland Islands',"AL"=>'Albania',"DZ"=>'Algeria',
        "AS"=>'American Samoa',"AD"=>'Andorra',"AO"=>'Angola',"AI"=>'Anguilla',"AQ"=>'Antarctica',
        "AG"=>'Antigua and Barbuda',"AR"=>'Argentina',"AM"=>'Armenia',"AW"=>'Aruba',
        "AU"=>'Australia',"AT"=>'Austria',"AZ"=>'Azerbaijan',
        "BS"=>'Bahamas',"BH"=>'Bahrain',"BD"=>'Bangladesh',"BB"=>'Barbados',
        "BY"=>'Belarus',"BE"=>'Belgium',"BZ"=>'Belize',"BJ"=>'Benin',
        "BM"=>'Bermuda',"BT"=>'Bhutan',"BO"=>'Bolivia, Plurinational State of',
        "BQ"=>'Bonaire, Sint Eustatius and Saba',"BA"=>'Bosnia and Herzegovina',"BW"=>'Botswana',
        "BV"=>'Bouvet Island',"BR"=>'Brazil',"IO"=>'British Indian Ocean Territory',
        "BN"=>'Brunei Darussalam',"BG"=>'Bulgaria',"BF"=>'Burkina Faso',"BI"=>'Burundi',"KH"=>'Cambodia',
        "CM"=>'Cameroon',"CA"=>'Canada',"CV"=>'Cape Verde',"KY"=>'Cayman Islands',"CF"=>'Central African Republic',
        "TD"=>'Chad',"CL"=>'Chile',"CN"=>'China',"CX"=>'Christmas Island',
        "CC"=>'Cocos (Keeling) Islands',"CO"=>'Colombia',"KM"=>'Comoros',"CG"=>'Congo',
        "CD"=>'Congo, the Democratic Republic of the',
        "CK"=>'Cook Islands',"CR"=>'Costa Rica',"CI"=>'Côte dIvoire',"HR"=>'Croatia',"CU"=>'Cuba',"CW"=>'Curaçao',"CY"=>'Cyprus',"CZ"=>'Czech Republic',
        "DK"=>'Denmark',"DJ"=>'Djibouti',"DM"=>'Dominica',"DO"=>'Dominican Republic',
        "EC"=>'Ecuador',"EG"=>'Egypt',"SV"=>'El Salvador',"GQ"=>'Equatorial Guinea',"ER"=>'Eritrea',"EE"=>'Estonia',
        "ET"=>'Ethiopia',"FK"=>'Falkland Islands (Malvinas)',"FO"=>'Faroe Islands',"FJ"=>'Fiji',"FI"=>'Finland',"FR"=>'France',
        "GF"=>'French Guiana',"PF"=>'French Polynesia',"TF"=>'French Southern Territories',"GA"=>'Gabon',"GM"=>'Gambia',
        "GE"=>'Georgia',"DE"=>'Germany',"GH"=>'Ghana',"GI"=>'Gibraltar',
        "GR"=>'Greece',"GL"=>'Greenland',"GD"=>'Grenada',"GP"=>'Guadeloupe',"GU"=>'Guam',
        "GT"=>'Guatemala',"GG"=>'Guernsey',"GN"=>'Guinea',"GW"=>'Guinea-Bissau',
        "GY"=>'Guyana',"HT"=>'Haiti',"HM"=>'Heard Island and McDonald Islands',"VA"=>'Holy See (Vatican City State)',
        "HN"=>'Honduras',
        "HK"=>'Hong Kong',
        "HU"=>'Hungary',
        "IS"=>'Iceland',
        "IN"=>'India',
        "ID"=>'Indonesia',
        "IR"=>'Iran, Islamic Republic of',
        "IQ"=>'Iraq',
        "IE"=>'Ireland',
        "IM"=>'Isle of Man',
        "IL"=>'Israel',
        "IT"=>'Italy',
        "JM"=>'Jamaica',
        "JP"=>'Japan',
        "JE"=>'Jersey',
        "JO"=>'Jordan',
        "KZ"=>'Kazakhstan',
        "KE"=>'Kenya',
        "KI"=>'Kiribati',
        "KP"=>'Korea, Democratic Peoples Republic of',
        "KR"=>'Korea, Republic of',
        "KW"=>'Kuwait',
        "KG"=>'Kyrgyzstan',
        "LA"=>'Lao Peoples Democratic Republic',
        "LV"=>'Latvia',
        "LB"=>'Lebanon',
        "LS"=>'Lesotho',
        "LR"=>'Liberia',
        "LY"=>'Libya',
        "LI"=>'Liechtenstein',
        "LT"=>'Lithuania',
        "LU"=>'Luxembourg',
        "MO"=>'Macao',
        "MK"=>'Macedonia, the former Yugoslav Republic of',
        "MG"=>'Madagascar',
        "MW"=>'Malawi',
        "MY"=>'Malaysia',
        "MV"=>'Maldives',
        "ML"=>'Mali',
        "MT"=>'Malta',
        "MH"=>'Marshall Islands',
        "MQ"=>'Martinique',
        "MR"=>'Mauritania',
        "MU"=>'Mauritius',
        "YT"=>'Mayotte',
        "MX"=>'Mexico',
        "FM"=>'Micronesia, Federated States of',
        "MD"=>'Moldova, Republic of',
        "MC"=>'Monaco',
        "MN"=>'Mongolia',
        "ME"=>'Montenegro',
        "MS"=>'Montserrat',
        "MA"=>'Morocco',
        "MZ"=>'Mozambique',
        "MM"=>'Myanmar',
        "NA"=>'Namibia',
        "NR"=>'Nauru',
        "NP"=>'Nepal',
        "NL"=>'Netherlands',
        "NC"=>'New Caledonia',
        "NZ"=>'New Zealand',
        "NI"=>'Nicaragua',
        "NE"=>'Niger',
        "NG"=>'Nigeria',
        "NU"=>'Niue',
        "NF"=>'Norfolk Island',
        "MP"=>'Northern Mariana Islands',
        "NO"=>'Norway',
        "OM"=>'Oman',
        "PK"=>'Pakistan',
        "PW"=>'Palau',
        "PS"=>'Palestinian Territory, Occupied',
        "PA"=>'Panama',
        "PG"=>'Papua New Guinea',
        "PY"=>'Paraguay',
        "PE"=>'Peru',
        "PH"=>'Philippines',
        "PN"=>'Pitcairn',
        "PL"=>'Poland',
        "PT"=>'Portugal',
        "PR"=>'Puerto Rico',
        "QA"=>'Qatar',
        "RE"=>'Réunion',
        "RO"=>'Romania',
        "RU"=>'Russian Federation',
        "RW"=>'Rwanda',
        "BL"=>'Saint Barthélemy',
        "SH"=>'Saint Helena, Ascension and Tristan da Cunha',
        "KN"=>'Saint Kitts and Nevis',
        "LC"=>'Saint Lucia',
        "MF"=>'Saint Martin (French part)',
        "PM"=>'Saint Pierre and Miquelon',
        "VC"=>'Saint Vincent and the Grenadines',
        "WS"=>'Samoa',
        "SM"=>'San Marino',
        "ST"=>'Sao Tome and Principe',
        "SA"=>'Saudi Arabia',
        "SN"=>'Senegal',
        "RS"=>'Serbia',
        "SC"=>'Seychelles',
        "SL"=>'Sierra Leone',
        "SX"=>'Sint Maarten (Dutch part)',
        "SK"=>'Slovakia',
        "SI"=>'Slovenia',
        "SB"=>'Solomon Islands',
        "SO"=>'Somalia',
        "ZA"=>'South Africa',
        "GS"=>'South Georgia and the South Sandwich Islands',
        "SS"=>'South Sudan',
        "ES"=>'Spain',
        "LK"=>'Sri Lanka',
        "SD"=>'Sudan',
        "SR"=>'Suriname',
        "SJ"=>'Svalbard and Jan Mayen',
        "SZ"=>'Swaziland',
        "SE"=>'Sweden',
        "CH"=>'Switzerland',
        "SY"=>'Syrian Arab Republic',
        "TW"=>'Taiwan, Province of China',
        "TJ"=>'Tajikistan',
        "TZ"=>'Tanzania, United Republic of',
        "TH"=>'Thailand',
        "TL"=>'Timor-Leste',
        "TG"=>'Togo',
        "TK"=>'Tokelau',
        "TO"=>'Tonga',
        "TT"=>'Trinidad and Tobago',
        "TN"=>'Tunisia',
        "TR"=>'Turkey',
        "TM"=>'Turkmenistan',
        "TC"=>'Turks and Caicos Islands',
        "TV"=>'Tuvalu',
        "UG"=>'Uganda',
        "UA"=>'Ukraine',
        "AE"=>'United Arab Emirates',
        "GB"=>'United Kingdom',
        "US"=>'United States',
        "UM"=>'United States Minor Outlying Islands',
        "UY"=>'Uruguay',
        "UZ"=>'Uzbekistan',
        "VU"=>'Vanuatu',
        "VE"=>'Venezuela, Bolivarian Republic of',
        "VN"=>'Viet Nam',
        "VG"=>'Virgin Islands, British',
        "VI"=>'Virgin Islands, U.S.',
        "WF"=>'Wallis and Futuna',
        "EH"=>'Western Sahara',
        "YE"=>'Yemen',
        "ZM"=>'Zambia',
        "ZW"=>'Zimbabwe'
        );
        
        return $country;
    }//end functioin