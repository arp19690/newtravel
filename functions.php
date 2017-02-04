<?php

function create_fake_users($men = true, $women = true)
{
    $women_url = "resources/fake-people/women";
    $men_url = "resources/fake-people/men";

    function db_insert_users($data_array)
    {
        require_once APPPATH . '/models/common_model.php';
        $model = new Common_model();
        return $model->insertData(TABLE_USERS, $data_array);
    }

    // to add all women users
    function insert_women_users($women_url)
    {
        $all_women = scandir($women_url);
        foreach ($all_women as $value)
        {
            if (is_file($women_url . "/" . $value))
            {
                $ext = getFileExtension($value);
                if (in_array($ext, array("jpeg", "jpg", "png", "gif")))
                {
                    $full_name = str_replace("." . $ext, "", $value);
                    $insert_data = get_insert_array($full_name, $value, $women_url);
                    db_insert_users($insert_data);
                }
            }
        }
    }

    // to add all men users
    function insert_men_users($men_url)
    {
        $all_men = scandir($men_url);
        foreach ($all_men as $value)
        {
            if (is_file($men_url . "/" . $value))
            {
                $ext = getFileExtension($value);
                if (in_array($ext, array("jpeg", "jpg", "png", "gif")))
                {
                    $full_name = str_replace("." . $ext, "", $value);
                    $insert_data = get_insert_array($full_name, $value, $men_url, "male");
                    db_insert_users($insert_data);
                }
            }
        }
    }

    function get_insert_array($full_name, $image_file, $image_base_path, $gender = "female")
    {
        $locations = array("California, USA");
        $location_name = $locations[rand(0, count($locations) - 1)];

        $username = str_replace(" ", "", strtolower($full_name));
        $location_data = get_location_details_from_google($location_name);
        $lat_lon_data = getLatLonByAddress($location_name);

        $ext = getFileExtension($image_file);
        $dest_file_path = USER_IMG_PATH . "/" . getEncryptedString($username . time()) . "." . $ext;
        echo uploadImage($image_base_path . "/" . $image_file, $dest_file_path, USER_IMG_WIDTH);
        $tmparr = array(
            "user_fullname" => $full_name,
            "user_username" => $username,
            "user_email" => $username . "@gmmail.com",
            "user_password" => md5($username),
            "user_gender" => $gender,
            "user_city" => $location_data["city"],
            "user_state" => $location_data["state"],
            "user_country" => $location_data["country"],
            "user_location" => $location_name,
            "user_latitude" => $lat_lon_data["latitude"],
            "user_longitude" => $lat_lon_data["longitude"],
            "user_profile_picture" => $dest_file_path,
            "user_ipaddress" => "127.0.0.1",
            "user_created_on" => date("Y-m-d H:i:s"),
        );
        return $tmparr;
    }

    if ($women)
    {
        insert_women_users($women_url);
    }

    if ($men)
    {
        insert_men_users($men_url);
    }
    
    return True;
}

function base_url_admin($request_uri = NULL)
{
    $url = SITE_BASE_URL . 'admin/' . $request_uri;
    return $url;
}

function get_message_timestamp_readable($timestamp)
{
    return date('d M Y G:i a', $timestamp);
}

function get_post_mysql_sort_by($order_by_string)
{
    $order_by = 'p.post_title ASC';
    switch ($order_by_string)
    {
        default:
            $order_by = 'p.post_title ASC';
            break;
        case 'title':
            $order_by = 'p.post_title ASC';
            break;
        case 'price_low':
            $order_by = 'cost_amount ASC';
            break;
        case 'price_high':
            $order_by = 'cost_amount DESC';
            break;
        case 'duration_low':
            $order_by = 'COUNT(pt_post_id) ASC';
            break;
        case 'duration_high':
            $order_by = 'COUNT(pt_post_id) DESC';
            break;
    }
    return $order_by;
}

function get_video_embed_url($url)
{

    function _is_vimeo($url)
    {
        return (preg_match('/vimeo\.com/i', $url));
    }

    function _is_youtube($url)
    {
        return (preg_match('/youtu\.be/i', $url) || preg_match('/youtube\.com\/watch/i', $url));
    }

    if (_is_youtube($url))
    {
        $pattern = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
        preg_match($pattern, $url, $matches);
        if (count($matches) && strlen($matches[7]) == 11)
        {
            return '//www.youtube.com/embed/' . $matches[7];
        }
    }
    else if (_is_vimeo($url))
    {
        $pattern = '/\/\/(www\.)?vimeo.com\/(\d+)($|\/)/';
        preg_match($pattern, $url, $matches);
        if (count($matches))
        {
            return 'http://player.vimeo.com/video/' . $matches[2] . '?title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff';
        }
    }
    else
    {
        return NULL;
    }
}

function modify_url($base_url, $param_array = NULL, $separator = '&amp;')
{
    // parse the url
    $pathInfo = parse_url($_SERVER['REQUEST_URI']);
    $newQueryStr = NULL;
    $query = array();
    if (isset($pathInfo['query']) && !empty(@$pathInfo['query']))
    {
        parse_str($pathInfo['query'], $query);
    }

    if (!empty($param_array))
    {
        // build the new query string
        $newQueryStr .= http_build_query($param_array + $query);
    }

    return $base_url . (!empty($newQueryStr) == TRUE ? ('?' . $newQueryStr) : ($newQueryStr));
}

function get_google_ad()
{
    $str = NULL;
    if (USER_IP != '127.0.0.1')
    {
        $str = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- GoBacPac - Live website -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-7594968339633253"
                         data-ad-slot="3984546122"
                         data-ad-format="auto"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>';
    }
    return $str;
}

function getImage($image_path_filename)
{
    if (!is_file($image_path_filename))
    {
        $image_path_filename = NO_IMAGE_PATH;
    }
    return $image_path_filename;
}

function get_currency_symbol($string)
{
    $output = '$';
    $string = strtolower($string);
    switch ($string)
    {
        case 'usd':
            $output = '$';
            break;
        case 'eur':
            $output = '€';
            break;
        case 'gbp':
            $output = '£';
            break;
        case 'inr':
            $output = '₹';
            break;
    }
    return $output;
}

function display_404_page()
{
    require_once APPPATH . 'controllers/index.php';
    $index_controller = new Index();
    $index_controller->pagenotfound();
}

function isValidImageExt($ext)
{
    $valid_ext_Arr = array('jpg', 'jpeg', 'png', 'gif');
    $returnValue = TRUE;
    if (!in_array(strtolower($ext), $valid_ext_Arr))
    {
        $returnValue = FALSE;
    }

    return $returnValue;
}

function uploadImage($fileTmpname, $destFilePathAndName, $width, $height = NULL)
{
    require_once APPPATH . '/libraries/SimpleImage.php';
    $img = new SimpleImage();
    $img->load($fileTmpname);

    if ($height == NULL || empty($height))
    {
        $img->resizeToWidth($width);
    }
    else
    {
        $img->resize($width, $height);
    }

    //save image
    $path = $destFilePathAndName;
    $img->save($path);
}

function get_trip_url_key($trip_title, $post_id = NULL)
{
    $trip_title = str_replace(' ', '-', $trip_title);
    $trip_title = str_replace('"', '', $trip_title);
    $trip_title = str_replace("'", '', $trip_title);
    $trip_title = str_replace('/', '', $trip_title);
    $trip_title = str_replace('&', '', $trip_title);
    $trip_title = str_replace('!', '', $trip_title);
    $trip_title = str_replace('@', '', $trip_title);
    $trip_title = str_replace('#', '', $trip_title);
    $trip_title = str_replace('%', '', $trip_title);
    $trip_title = str_replace('*', '', $trip_title);
    $trip_title = str_replace('$', '', $trip_title);

    $trip_title = strtolower($trip_title);
    $trip_url_key = checkIfTripURLKeyUnique($trip_title, $post_id);
    return $trip_url_key;
}

function get_breadcrumbs($input_arr)
{
    $i = 1;
    $str = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">';
    foreach ($input_arr as $url => $title)
    {
        if (count($input_arr) > $i)
        {
            $str.='<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            $str.='<a itemprop="item" href="' . $url . '"><span itemprop="name">' . $title . '</span></a>';
            $str.= '<meta itemprop="position" content="' . $i . '" />';
            $str.='</span>';
            $str.=' / ';
        }
        else
        {
            $str.='<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            $str.='<span itemprop="name">' . $title . '</span>';
            $str.= '<meta itemprop="position" content="' . $i . '" />';
            $str.='</span>';
        }
        $i++;
    }
    $str.='</div>';
    return $str;
}

function get_external_url($url)
{
    $output = base_url('r?url=' . stripslashes($url));
    return $output;
}

function checkIfTripURLKeyUnique($trip_url_key, $post_id = NULL)
{
    require_once APPPATH . '/models/common_model.php';
    $model = new Common_model();
    $whereCondArr = array('post_url_key' => $trip_url_key);
    if ($post_id != NULL)
    {
        $whereCondArr['post_id !='] = $post_id;
    }
    $is_exists = $model->is_exists('post_id', TABLE_POSTS, $whereCondArr);
    if (!empty($is_exists))
    {
        $new_trip_url_key = $trip_url_key . '-' . rand(10, 999);
        $trip_url_key = checkIfTripURLKeyUnique($new_trip_url_key);
    }

    return $trip_url_key;
}

function getUniqueContactRequestID()
{
    require_once APPPATH . '/models/common_model.php';
    $model = new Common_model();

    $request_id = strtoupper(substr(getEncryptedString(time()), 0, 8));
    $is_exists = $model->is_exists('wc_id', TABLE_WEBSITE_CONTACT, array('wc_request_id' => $request_id));
    if (!empty($is_exists))
    {
        $request_id = getUniqueContactRequestID();
    }

    return $request_id;
}

function getUniqueUsernameFromEmail($email, $user_id = NULL)
{
    require_once APPPATH . '/models/common_model.php';
    $model = new Common_model();
    $explode_email = explode('@', $email);
    $username = trim($explode_email[0]);
    $whereCondArr = array('user_username' => $username);
    if ($user_id != NULL)
    {
        $whereCondArr['user_id !='] = $user_id;
    }
    $is_exists = $model->is_exists('user_id', TABLE_USERS, $whereCondArr);
    if (!empty($is_exists))
    {
        $username = getUniqueUsernameFromEmail($username . '-' . rand(100, 999));
    }

    return $username;
}

function getUniqueBlogURLKey($random_number = NULL, $string_lenth = 10)
{
    require_once APPPATH . '/models/common_model.php';
    $model = new Common_model();
    if ($random_number == NULL)
    {
        $random_number = getRandomNumberLength(time(), $string_lenth);
    }
    $is_exists = $model->is_exists('blog_id', TABLE_BLOGS, array('blog_url_key' => $random_number));
    if (!empty($is_exists))
    {
        getUniqueBlogURLKey(getRandomNumberLength($random_number), $string_lenth);
    }

    return $random_number;
}

function goBack($steps = '1')
{
    return 'javascript:history.go(-' . $steps . ');';
}

function getUserImage($user_id, $facebook_id, $facebook_type = NULL, $width = NULL, $height = NULL)
{
    $fileName = USER_IMG_PATH . "/" . getEncryptedString($user_id) . ".jpg";
    if (!is_file($fileName))
    {
        if (!empty($facebook_id))
        {
            $returnValue = getFacebookUserImageSource($facebook_id, $facebook_type, $width, $height);
        }
        else
        {
            $returnValue = base_url(NO_IMAGE_PATH);
        }
    }
    else
    {
        $returnValue = base_url($fileName);
    }

    return $returnValue;
}

function getTripHeaderImage($image_name, $other_images_array = NULL)
{
    $filename = TRIP_HEADER_IMG_PATH . "/" . $image_name;
    if (!is_file($filename))
    {
        if ($other_images_array != NULL)
        {
            $explode_other_images = explode(ARRAY_SEPARATOR, $other_images_array);
            $filename = TRIP_IMG_PATH . "/" . $explode_other_images[0];
        }
        else
        {
            $filename = NO_IMAGE_PATH;
        }
    }

    return base_url($filename);
}

function getMapMidpoint($lat1, $lng1, $lat2, $lng2)
{
    $lat1 = deg2rad($lat1);
    $lng1 = deg2rad($lng1);
    $lat2 = deg2rad($lat2);
    $lng2 = deg2rad($lng2);

    $dlng = $lng2 - $lng1;
    $Bx = cos($lat2) * cos($dlng);
    $By = cos($lat2) * sin($dlng);
    $lat3 = atan2(sin($lat1) + sin($lat2), sqrt((cos($lat1) + $Bx) * (cos($lat1) + $Bx) + $By * $By));
    $lng3 = $lng1 + atan2($By, (cos($lat1) + $Bx));
    $pi = pi();
//        return ($lat3 * 180) / $pi . ' ' . ($lng3 * 180) / $pi;

    return array(
        "latitude" => ($lat3 * 180) / $pi,
        "longitude" => ($lng3 * 180) / $pi
    );
}

function get_location_details_from_google($address)
{
    $url = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=' . urlencode($address);
    $results = json_decode(file_get_contents($url), 1);
//        die('<pre>' . print_r($results, true));
    $parts = array(
        'address' => array('street_number', 'route'),
        'city' => array('locality'),
        'state' => array('administrative_area_level_1'),
        'country' => array('country'),
        'zip' => array('postal_code'),
    );
    if (!empty($results['results'][0]['address_components']))
    {
        $ac = $results['results'][0]['address_components'];
        foreach ($parts as $need => &$types)
        {
            foreach ($ac as &$a)
            {
                if (in_array($a['types'][0], $types))
                {
                    $address_out[$need] = $a['long_name'];
                }
                elseif (empty($address_out[$need]))
                {
                    $address_out[$need] = '';
                }
            }
        }
    }
    else
    {
        echo 'empty results';
    }

//        prd($address_out);
    return $address_out;
}

function getLatLonByIPAddress($ipaddress = USER_IP)
{
    // Get lat and long by ipaddress         
    $record = get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress=' . $ipaddress);
//        prd($record);
    return array("latitude" => $record["latitude"], "longitude" => $record["longitude"]);
}

function getLatLonByAddress($address)
{
    // Get lat and long by address         
    $prepAddr = str_replace(' ', '+', $address);
    $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
    $output = json_decode($geocode);
//        prd($prepAddr);

    $latitude = "--";
    $longitude = "--";
    if (!empty($output->results))
    {
        $latitude = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;
    }

    $returnOutput = array(
        "latitude" => $latitude,
        "longitude" => $longitude
    );
    return $returnOutput;
}

function getPhotoPaginationLinks($image_name_array, $current_photo)
{
    $current_key = "";
    foreach ($image_name_array as $iKey => $iValue)
    {
        if ($iValue['photo_id'] == $current_photo)
        {
            $current_key = $iKey;
            break;
        }
    }

    $previous_url = NULL;
    $next_url = NULL;

    if (isset($image_name_array[$current_key - 1]))
    {
        $previous_url = base_url('view/photo/' . $image_name_array[$current_key - 1]['album_key'] . '/' . $image_name_array[$current_key - 1]['photo_id']);
    }

    if (isset($image_name_array[$current_key + 1]))
    {
        $next_url = base_url('view/photo/' . $image_name_array[$current_key + 1]['album_key'] . '/' . $image_name_array[$current_key + 1]['photo_id']);
    }

//        pr($max_pages);
//        prd($previous_url." --- ".$next_url);

    $str = "";
    if ($previous_url != NULL || $next_url != NULL)
    {
        $str .= '<ul class="pager">';
        if ($previous_url != NULL)
            $str .= '<li class="pull-left"><a href="' . $previous_url . '"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Previous</a></li>';
        if ($next_url != NULL)
            $str .= '<li class="pull-right"><a href="' . $next_url . '">Next&nbsp;&nbsp;<span class="glyphicon glyphicon-arrow-right"></span></a></li>';
        $str .= '</ul>';
    }

    return $str;
}

function getPaginationLinks($url, $total_records, $current_page = 1, $pagination_limit = 20)
{
    $url = parse_url($url);
//        prd($url);
    $earlier_url_path = $url['scheme'] . "://" . $url["host"] . $url["path"];

    $new_array = array();
    if (isset($url["query"]))
    {
        $explode_one = explode("&", $url["query"]);

        foreach ($explode_one as $key => $value)
        {
            $explode_two = explode("=", $value);
            if (!empty($explode_two[1]))
                $new_array[$explode_two[0]] = $explode_two[1];
        }
    }

    $max_pages = ceil($total_records / $pagination_limit);

    $previous_url = NULL;
    $next_url = NULL;

    $previous_page = $current_page - 1;
    if ($previous_page > 0)
    {
        $new_array["page"] = $previous_page;
        $previous_url = $earlier_url_path . "?" . http_build_query($new_array);
    }

    $next_page = $current_page + 1;
    if ($current_page < $max_pages)
    {
        $new_array["page"] = $next_page;
        $next_url = $earlier_url_path . "?" . http_build_query($new_array);
    }

//        pr($max_pages);
//        prd($previous_url." --- ".$next_url);

    $str = "";
    if ($previous_url != NULL || $next_url != NULL)
    {
        $str .= '<ul class="pager">';
        if ($previous_url != NULL)
            $str .= '<li><a href="' . $previous_url . '"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;Previous</a></li>';
        if ($next_url != NULL)
            $str .= '<li><a href="' . $next_url . '">Next&nbsp;&nbsp;<span class="glyphicon glyphicon-arrow-right"></span></a></li>';
        $str .= '</ul>';
    }

    return $str;
}

function getPaginationLimit($current_page = 1, $max_records = TRIPS_PAGINATION_LIMIT)
{
    $limit_record_one = ($current_page - 1) * $max_records;
    $limit = $limit_record_one . ', ' . ($limit_record_one + $max_records);

    return $limit;
}

function getTripUrl($url_key)
{
    return base_url('trip/view/' . $url_key);
}

function getTripImages($image_name)
{
    if (is_file(TRIP_IMG_PATH . "/" . $image_name))
    {
        $image = base_url(TRIP_IMG_PATH . "/" . $image_name);
    }
    else
    {
        $image = base_url(IMAGES_PATH . "/no-image.png");
    }
    return $image;
}

function getAddThisVertical()
{
    return '<!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_floating_style addthis_counter_style" style="left:50px;top:50px;">
                        <a class="addthis_button_facebook_share" fb:share:layout="box_count"></a>
                        <a class="addthis_button_tweet" tw:count="vertical"></a>
                        <a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
                        <a class="addthis_counter"></a>
                    </div>
                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-52dc2b230b860ab0"></script>
                    <!-- AddThis Button END -->';
}

function getFacebookLikeBox($width = 300, $color_scheme = "light")
{
    return '<div class="fb-like-box" data-href="' . FACEBOOK_SOCIAL_LINK . '" data-width="' . $width . '" data-colorscheme="' . $color_scheme . '" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>';
}

function getChitikaAd($width = 300, $height = 250)
{
    return '<script type="text/javascript">
                        ( function() {
                          if (window.CHITIKA === undefined) { window.CHITIKA = { "units" : [] }; };
                          var unit = {"calltype":"async[2]","publisher":"arpit19690","width":' . $width . ',"height":' . $height . ',"sid":"TravelWidMe"};
                          var placement_id = window.CHITIKA.units.length;
                          window.CHITIKA.units.push(unit);
                          document.write("<div id=\'chitikaAdBlock-" + placement_id+ "\'></div>");
                      }());
                      </script>
                      <script type="text/javascript" src="//cdn.chitika.net/getads.js" async></script>';
}

function getAddThis()
{
    return '<!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style ">
                        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                        <a class="addthis_button_tweet"></a>
                        <a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal"></a>
                        <a class="addthis_counter addthis_pill_style"></a>
                    </div>
                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-52dc2b230b860ab0"></script>
                    <!-- AddThis Button END -->';
}

function getAge($user_birthday)
{
    if (!empty($user_birthday))
    {
        $birthYear = date('Y', strtotime($user_birthday));
        $current_year = date("Y", time());
        return $current_year - $birthYear;
    }
    else
    {
        return NULL;
    }
}

function getPublicProfileUrl($username)
{
    return base_url("profile/$username");
}

function getActualFacebookImageUrl($image_url)
{
    $headers = get_headers($image_url, 1);
//        prd($headers);
    // just a precaution, check whether the header isset...
    if (isset($headers['Location']))
    {
        $url = $headers['Location']; // string
    }
    else
    {
        $url = FALSE; // nothing there? .. weird, but okay!
    }
    return $url;
}

function getFacebookUserLink($facebook_id)
{
    return "https://www.facebook.com/" . $facebook_id;
}

function getNWordsFromString($text, $numberOfWords = 20)
{
    if ($text != null)
    {
        $textArray = explode(" ", $text);
        if (count($textArray) > $numberOfWords)
        {
            return implode(" ", array_slice($textArray, 0, $numberOfWords)) . "...";
        }
        return $text;
    }
    return "";
}

function getFileExtension($file_name)
{
    $exploded_name = explode(".", $file_name);
    $count_of_Array = count($exploded_name);
    $extension = $exploded_name[$count_of_Array - 1];
    return $extension;
}

function getUniquePaymentReferenceNumber($reference_number = NULL)
{
    require_once APPPATH . '/models/common_model.php';
    $model = new Common_model();

    $reference_number = strtoupper(substr($reference_number, 0, 10));
    $is_exists = $model->is_exists('payment_id', TABLE_PAYMENTS, array('payment_reference_number' => $reference_number));
    if (!empty($is_exists))
    {
        $reference_number = getUniquePaymentReferenceNumber(rand(100, 99999) . '-' . $reference_number);
    }

    return $reference_number;
}

function getShareWithFacebookLinkPopup($link, $title)
{
    $href = '<script>
            function fbs_click() 
            {
            u=location.href;t=document.title;window.open("http://www.facebook.com/sharer.php?u="+encodeURIComponent(u)+"&t="+encodeURIComponent(t),"sharer","toolbar=0,status=0,width=626,height=436");
            return false;
            }
            </script>
            <a rel="nofollow" href="http://www.facebook.com/share.php?u=' . $link . '" onclick="return fbs_click()" target="_blank">' . stripslashes($title) . '</a>';

    return $href;
}

function getBrowserType()
{
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)))
        $returnValue = 'mobile';
    else
        $returnValue = 'desktop';

    return $returnValue;
}

function pr($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function prd($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
    die;
}

function getClientBrowserName()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $ub = '';
    if (preg_match('/MSIE/i', $u_agent))
    {
        $ub = "Internet Explorer";
    }
    elseif (preg_match('/Firefox/i', $u_agent))
    {
        $ub = "Mozilla Firefox";
    }
    elseif (preg_match('/Chrome/i', $u_agent))
    {
        $ub = "Google Chrome";
    }
    elseif (preg_match('/Safari/i', $u_agent))
    {
        $ub = "Apple Safari";
    }
    elseif (preg_match('/Flock/i', $u_agent))
    {
        $ub = "Flock";
    }
    elseif (preg_match('/Opera/i', $u_agent))
    {
        $ub = "Opera";
    }
    elseif (preg_match('/Netscape/i', $u_agent))
    {
        $ub = "Netscape";
    }

    return $ub;
}

function getClientOS()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $os_platform = "Unknown OS Platform";

    $os_array = array(
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );

    foreach ($os_array as $regex => $value)
    {

        if (preg_match($regex, $user_agent))
        {
            $os_platform = $value;
        }
    }

    return $os_platform;
}

function getUrl($value)
{
    if (preg_match("/http/", $value))
        $url = $value;
    else
//            $url = SITE_BASE_URL . "/" . $value;
        $url = SITE_BASE_URL . $value;
    return $url;
}

function getEncryptedString($string, $action = "encode")
{
    $output = false;

    $encrypt_method = ENCRYPT_METHOD;
    $secret_key = ENCRYPT_SECRET_KEY;
    $secret_iv = ENCRYPT_SECRET_IV;

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'encode')
    {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if ($action == 'decode')
    {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

function getRandomNumberLength($str, $length = "8")
{
    return substr(uniqid(md5($str . time()), true), -$length);
}

function getTimeAgo($time)
{
    $etime = time() - $time;

    if ($etime < 1)
    {
//            return '0 seconds';
        return 'Just now';
    }

    $a = array(12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
        }
    }
}

function getFacebookUserImageSource($facebook_id, $type = NULL, $width = USER_IMG_WIDTH, $height = USER_IMG_HEIGHT)
{
    $src = "https://graph.facebook.com/v2.5/$facebook_id/picture?width=" . $width;

    if ($type != NULL)
    {
        $src = "https://graph.facebook.com/v2.5/$facebook_id/picture?type=$type";
    }
    else
    {
        if ($height != NULL)
        {
            $src .= "&height=$height";
        }
    }

    return $src;
}

function getShareWithPinterest($url, $img_src, $description)
{
    $str = "http://pinterest.com/pin/create/button/?url=" . rawurlencode($url) . "&media=" . rawurlencode($img_src) . "&description=" . rawurlencode($description);
    return $str;
}

function getShareWithGooglePlus($url)
{
    $str = "https://plus.google.com/share?url=" . rawurlencode($url);
    return $str;
}

function getShareWithFacebook($url)
{
    $str = "https://www.facebook.com/sharer/sharer.php?u=" . rawurlencode($url);
    return $str;
}

function getShareWithTwitter($status)
{
    $str = "http://twitter.com/home?status=" . rawurlencode($status);
    return $str;
}

function createCaptcha()
{
    $arr = array(
        array("3 + 5" => "8"),
        array("7 - 2" => "5"),
        array("4 + 6" => "10"),
        array("9 - 7" => "2"),
    );

    $count = count($arr) - 1;
    $rand_num = rand("0", $count);

    foreach ($arr[$rand_num] as $key => $value)
    {
        define("CAPTCHA_QUESTION", $key);
        define("CAPTCHA_ANSWER", $value);
    }
}
