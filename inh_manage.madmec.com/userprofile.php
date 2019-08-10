<?php

class userprofile {

    protected $parameters = array();

    function __construct($parameters = false) {
        $this->parameters = $parameters;
    }

    public function changePassword($newpass) {
        $query = 'UPDATE `user_profile` SET `password`="' . mysql_real_escape_string($newpass) . '" WHERE `id`="' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]) . '";';
        $result = executeQuery($query);
        return $result;
    }

    public function fetchClientProfile() {
        $query = 'SELECT up.user_name,
                        up.owner_name,
                        up.business_name,
                        up.email,
                        up.cell_code,
                        up.cell_number,
                        up.date_of_join,
                        up.addressline,
                        up.town,
                        up.city,
                        up.district,
                        up.province,
                        up.country,
                        up.zipcode,
                        CASE WHEN up.postal_code IS NULL OR up.postal_code = ""
                        THEN
                        "NOT Provided"
                        ELSE
                        up.postal_code
                        END AS postal_code,
                        CASE WHEN up.telephone IS NULL OR up.telephone = ""
                        THEN
                        "NOT Provided"
                        ELSE
                        up.telephone
                        END AS telephone,
                        CASE WHEN up.website IS NULL OR up.website = ""
                        THEN
                        "NOT Provided"
                        ELSE
                        up.website
                        END AS website,
                        vtype.type AS validitytype,
                        vl.subscribe_date AS subscribe,
                        vl.expiry_date AS expireon,
                        ud.document_type,
                        ud.document_number,
                        up.sms_cost
                        FROM user_profile up
                        LEFT JOIN validity vl
                        ON vl.user_pk=up.id
                        LEFT JOIN validity_type vtype
                        ON vtype.id=vl.validity_type_pk
                        LEFT JOIN user_documents ud
                        ON ud.user_pk=up.id
                        WHERE up.id=' . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]) . ';';
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            $row = mysql_fetch_assoc($result);
//             $data ='<div class="col-lg-12">'
//                     . '<div class="col-lg-2"><strong>Business Name</strong></div>'
//                     . '<div class="col-lg-3"><strong>'.$row['business_name'].'</strong></div>'
//                     . '<div class="col-lg-2"></div>'
//                     . '<div class="col-lg-2"><strong>UserName</strong></div>'
//                     . '<div class="col-lg-3"><strong>'.$row['user_name'].'</strong></div>'
//                     . '</div>'
//                     .'<div class="col-lg-12">&nbsp;</div>'
//                      .'<div class="col-lg-12">'
//                     . '<div class="col-lg-2"><strong>Name</strong></div>'
//                     . '<div class="col-lg-3"><strong>'.$row['owner_name'].'</strong></div>'
//                     . '<div class="col-lg-2"></div>'
//                     . '<div class="col-lg-2"><strong>Email</strong></div>'
//                     . '<div class="col-lg-3"><strong>'.$row['email'].'</strong></div>'
//                     . '</div>'
//                     .'<div class="col-lg-12">&nbsp;</div>'
//                      .'<div class="col-lg-12">'
//                     . '<div class="col-lg-2"><strong>Mobile</strong></div>'
//                     . '<div class="col-lg-3"><strong>'.$row['cell_code'].'-'.$row['cell_number'].'</strong></div>'
//                     . '<div class="col-lg-2"></div>'
//                     . '<div class="col-lg-2"><strong>Land Line</strong></div>'
//                     . '<div class="col-lg-3"><strong>'.$row['postal_code'].'-'.$row['telephone'].'</strong></div>'
//                     . '</div>'
//                     .'<div class="col-lg-12">&nbsp;</div>'
//                      .'<div class="col-lg-12">'
//                     . '<div class="col-lg-2"><strong>Document Type</strong></div>'
//                     . '<div class="col-lg-3"><strong>'.$row['document_type'].'</strong></div>'
//                     . '<div class="col-lg-2"></div>'
//                     . '<div class="col-lg-2"><strong>Document Number</strong></div>'
//                     . '<div class="col-lg-3"><strong>'.$row['document_number'].'</strong></div>'
//                     . '</div>'
//                     .'<div class="col-lg-12">&nbsp;</div>'
//                      .'<div class="col-lg-12">'
//                     . '<div class="col-lg-2"><strong>Date of Join</strong></div>'
//                     . '<div class="col-lg-3"><strong>'.$row['date_of_join'].'</strong></div>'
//                     . '<div class="col-lg-2"></div>'
//                     . '<div class="col-lg-2"><strong>SMS Cost</strong></div>'
//                     . '<div class="col-lg-3"><strong>'.$row['sms_cost'].'</strong></div>'
//                     . '</div>'
//                     .'<div class="col-lg-12">&nbsp;</div>'
//                      .'<div class="col-lg-12">'
//                     . '<div class="col-lg-2"><strong>Subscription Date</strong></div>'
//                     . '<div class="col-lg-3"><strong>'.$row['subscribe'].'</strong></div>'
//                     . '<div class="col-lg-2"></div>'
//                     . '<div class="col-lg-2"><strong>Expire Date</strong></div>'
//                     . '<div class="col-lg-3"><strong>'.$row['expireon'].'</strong></div>'
//                     . '</div>'
//                 ;
            $data = '<div class="col-lg-12">'
                    . '<table class="table table-striped table-bordered table-hover"><tbody><tr><td>Business Name</td>'
                    . '<td><strong>' . $row['business_name'] . '</strong></td><td></td>'
                    . '<td>UserName</td>'
                    . '<td><strong>' . $row['user_name'] . '</strong></td></tr>'
                    . '<tr><td> Name</td>'
                    . '<td><strong>' . $row['owner_name'] . '</strong></td><td></td>'
                    . '<td>Email</td>'
                    . '<td><strong>' . $row['email'] . '</strong></td></tr>'
                    . '<tr><td> Mobile</td>'
                    . '<td><strong>' . $row['cell_code'] . '-' . $row['cell_number'] . '</strong></td><td></td>'
                    . '<td>Land Line</td>'
                    . '<td><strong>' . $row['postal_code'] . '-' . $row['telephone'] . '</strong></td></tr>'
                    . '<tr><td> Document Type</td>'
                    . '<td><strong>' . $row['document_type'] . '</strong></td><td></td>'
                    . '<td>Document Number</td>'
                    . '<td><strong>' . $row['document_number'] . '-' . $row['telephone'] . '</strong></td></tr>'
                    . '<tr><td> Date of Joined</td>'
                    . '<td><strong>' . $row['date_of_join'] . '</strong></td><td></td>'
                    . '<td>SMS Cost</td>'
                    . '<td><strong>' . $row['sms_cost'] . '</strong></td></tr>'
                    . '<tr><td>Subscription Date</td>'
                    . '<td><strong>' . $row['subscribe'] . '</strong></td><td></td>'
                    . '<td>Expire Date</td>'
                    . '<td><strong>' . $row['expireon'] . '</strong></td></tr>'
                    . '<tr><td>Address</td>'
                    . '<td colspan="4"><strong>' . $row['addressline'] . ' ,<br/>' . $row['town'] . ' ,<br/>' . $row['city'] .
                    ' ,<br/>' . $row['district'] . ' ,<br/>' . $row['province'] . ' ,<br/>' . $row['country'] . ' ,<br/> Pincode - ' . $row['zipcode'] . '.</strong></td>'
                    . '</tr>'
                    . '</tbody></table>'
            ;
            $jsondata = array(
                "status" => "success",
                "data" => $data
            );
            return $jsondata;
        } else {
            $jsondata = array(
                "status" => "error",
                "data" => NULL
            );
            return $jsondata;
        }
    }

}
