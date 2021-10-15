<?php
/*
 * WeatherAPILib
 *
 * This file was automatically generated by APIMATIC v2.0 ( https://apimatic.io ).
 */

namespace WeatherAPILib\Controllers;

use WeatherAPILib\APIException;
use WeatherAPILib\APIHelper;
use WeatherAPILib\Configuration;
use WeatherAPILib\Models;
use WeatherAPILib\Exceptions;
use WeatherAPILib\Utils\DateTimeHelper;
use WeatherAPILib\Http\HttpRequest;
use WeatherAPILib\Http\HttpResponse;
use WeatherAPILib\Http\HttpMethod;
use WeatherAPILib\Http\HttpContext;
use Unirest\Request;

/**
 * @todo Add a general description for this controller.
 */
class APIsController extends BaseController
{
    /**
     * @var APIsController The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * Returns the *Singleton* instance of this class.
     * @return APIsController The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }

    /**
     * Current weather or realtime weather API method allows a user to get up to date current weather
     * information in json and xml. The data is returned as a Current Object.Current object contains
     * current or realtime weather information for a given city.
     *
     * @param string $q    Pass US Zipcode, UK Postcode, Canada Postalcode, IP address, Latitude/Longitude (decimal
     *                     degree) or city name. Visit [request parameter section](https://www.weatherapi.
     *                     com/docs/#intro-request) to learn more.
     * @param string $lang (optional) Returns 'condition:text' field in API in the desired language. Visit [request
     *                     parameter section](https://www.weatherapi.com/docs/#intro-request) to check 'lang-code'.
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function getRealtimeWeather(
        $q,
        $lang = null
    ) {

        //prepare query string for API call
        $_queryBuilder = '/current.json';

        //process optional query parameters
        APIHelper::appendUrlWithQueryParameters($_queryBuilder, array (
            'q'    => $q,
            'lang' => $lang,
            'key' => Configuration::$key,
        ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::$BASEURI . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json'
        );

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::GET, $_headers, $_queryUrl);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::get($_queryUrl, $_headers);

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //Error handling using HTTP status codes
        if ($response->code == 400) {
            throw new APIException(
                'Error code 1003: Parameter \'q\' not provided.Error code 1005: API request url is invalid.Error ' .
                'code 1006: No location found matching parameter \'q\'Error code 9999: Internal application error.',
                $_httpContext
            );
        }

        if ($response->code == 401) {
            throw new APIException(
                'Error code 1002: API key not provided.Error code 2006: API key provided is invalid',
                $_httpContext
            );
        }

        if ($response->code == 403) {
            throw new APIException(
                'Error code 2007: API key has exceeded calls per month quota.<br />Error code 2008: API key has ' .
                'been disabled.',
                $_httpContext
            );
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'WeatherAPILib\\Models\\CurrentJsonResponse');
    }

    /**
     * Forecast weather API method returns upto next 10 day weather forecast and weather alert as json. The
     * data is returned as a Forecast Object.<br />Forecast object contains astronomy data, day weather
     * forecast and hourly interval weather information for a given city.
     *
     * @param string   $q      Pass US Zipcode, UK Postcode, Canada Postalcode, IP address, Latitude/Longitude (decimal
     *                         degree) or city name. Visit [request parameter section](https://www.weatherapi.
     *                         com/docs/#intro-request) to learn more.
     * @param integer  $days   Number of days of weather forecast. Value ranges from 1 to 10
     * @param DateTime $dt     (optional) Date should be between today and next 10 day in yyyy-MM-dd format
     * @param integer  $unixdt (optional) Please either pass 'dt' or 'unixdt' and not both in same request.<br />unixdt
     *                         should be between today and next 10 day in Unix format
     * @param integer  $hour   (optional) Must be in 24 hour. For example 5 pm should be hour=17, 6 am as hour=6
     * @param string   $lang   (optional) Returns 'condition:text' field in API in the desired language. Visit [request
     *                         parameter section](https://www.weatherapi.com/docs/#intro-request) to check 'lang-code'.
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function getForecastWeather(
        $q,
        $days,
        $dt = null,
        $unixdt = null,
        $hour = null,
        $lang = null,
        $alerts = null
    ) {

        //prepare query string for API call
        $_queryBuilder = '/forecast.json';

        //process optional query parameters
        APIHelper::appendUrlWithQueryParameters($_queryBuilder, array (
            'q'      => $q,
            'days'   => $days,
            'dt'     => DateTimeHelper::toSimpleDate($dt),
            'unixdt' => $unixdt,
            'hour'   => $hour,
            'lang'   => $lang,
            'alerts' => $alerts ? 'yes' : 'no',
            'key' => Configuration::$key,
        ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::$BASEURI . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json'
        );

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::GET, $_headers, $_queryUrl);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::get($_queryUrl, $_headers);

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //Error handling using HTTP status codes
        if ($response->code == 400) {
            throw new APIException(
                'Error code 1003: Parameter \'q\' not provided.Error code 1005: API request url is invalid.Error ' .
                'code 1006: No location found matching parameter \'q\'Error code 9999: Internal application error.',
                $_httpContext
            );
        }

        if ($response->code == 401) {
            throw new APIException(
                'Error code 1002: API key not provided.Error code 2006: API key provided is invalid',
                $_httpContext
            );
        }

        if ($response->code == 403) {
            throw new APIException(
                'Error code 2007: API key has exceeded calls per month quota.<br />Error code 2008: API key has ' .
                'been disabled.',
                $_httpContext
            );
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'WeatherAPILib\\Models\\ForecastJsonResponse');
    }

    /**
     * History weather API method returns historical weather for a date on or after 1st Jan, 2015 as json.
     * The data is returned as a Forecast Object.
     *
     * @param string   $q          Pass US Zipcode, UK Postcode, Canada Postalcode, IP address, Latitude/Longitude
     *                             (decimal degree) or city name. Visit [request parameter section](https://www.
     *                             weatherapi.com/docs/#intro-request) to learn more.
     * @param DateTime $dt         Date on or after 1st Jan, 2015 in yyyy-MM-dd format
     * @param integer  $unixdt     (optional) Please either pass 'dt' or 'unixdt' and not both in same request.<br
     *                             />unixdt should be on or after 1st Jan, 2015 in Unix format
     * @param DateTime $endDt      (optional) Date on or after 1st Jan, 2015 in yyyy-MM-dd format'end_dt' should be
     *                             greater than 'dt' parameter and difference should not be more than 30 days between
     *                             the two dates.
     * @param integer  $unixendDt  (optional) Date on or after 1st Jan, 2015 in Unix Timestamp format<br />unixend_dt
     *                             has same restriction as 'end_dt' parameter. Please either pass 'end_dt' or
     *                             'unixend_dt' and not both in same request. e.g.: unixend_dt=1490227200
     * @param integer  $hour       (optional) Must be in 24 hour. For example 5 pm should be hour=17, 6 am as hour=6
     * @param string   $lang       (optional) Returns 'condition:text' field in API in the desired language. Visit
     *                             [request parameter section](https://www.weatherapi.com/docs/#intro-request) to check
     *                             'lang-code'.
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function getHistoryWeather(
        $q,
        $dt,
        $unixdt = null,
        $endDt = null,
        $unixendDt = null,
        $hour = null,
        $lang = null
    ) {

        //prepare query string for API call
        $_queryBuilder = '/history.json';

        //process optional query parameters
        APIHelper::appendUrlWithQueryParameters($_queryBuilder, array (
            'q'          => $q,
            'dt'         => DateTimeHelper::toSimpleDate($dt),
            'unixdt'     => $unixdt,
            'end_dt'     => DateTimeHelper::toSimpleDate($endDt),
            'unixend_dt' => $unixendDt,
            'hour'       => $hour,
            'lang'       => $lang,
            'key' => Configuration::$key,
        ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::$BASEURI . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json'
        );

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::GET, $_headers, $_queryUrl);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::get($_queryUrl, $_headers);

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //Error handling using HTTP status codes
        if ($response->code == 400) {
            throw new APIException(
                'Error code 1003: Parameter \'q\' not provided.Error code 1005: API request url is invalid.Error ' .
                'code 1006: No location found matching parameter \'q\'Error code 9999: Internal application error.',
                $_httpContext
            );
        }

        if ($response->code == 401) {
            throw new APIException(
                'Error code 1002: API key not provided.Error code 2006: API key provided is invalid',
                $_httpContext
            );
        }

        if ($response->code == 403) {
            throw new APIException(
                'Error code 2007: API key has exceeded calls per month quota.<br />Error code 2008: API key has ' .
                'been disabled.',
                $_httpContext
            );
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'WeatherAPILib\\Models\\HistoryJsonResponse');
    }

    /**
     * WeatherAPI.com Search or Autocomplete API returns matching cities and towns as an array of Location
     * object.
     *
     * @param string $q Pass US Zipcode, UK Postcode, Canada Postalcode, IP address, Latitude/Longitude (decimal
     *                  degree) or city name. Visit [request parameter section](https://www.weatherapi.com/docs/#intro-
     *                  request) to learn more.
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function searchAutocompleteWeather(
        $q
    ) {

        //prepare query string for API call
        $_queryBuilder = '/search.json';

        //process optional query parameters
        APIHelper::appendUrlWithQueryParameters($_queryBuilder, array (
            'q' => $q,
            'key' => Configuration::$key,
        ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::$BASEURI . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json'
        );

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::GET, $_headers, $_queryUrl);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::get($_queryUrl, $_headers);

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //Error handling using HTTP status codes
        if ($response->code == 400) {
            throw new APIException(
                'Error code 1003: Parameter \'q\' not provided.Error code 1005: API request url is invalid.Error ' .
                'code 1006: No location found matching parameter \'q\'Error code 9999: Internal application error.',
                $_httpContext
            );
        }

        if ($response->code == 401) {
            throw new APIException(
                'Error code 1002: API key not provided.Error code 2006: API key provided is invalid',
                $_httpContext
            );
        }

        if ($response->code == 403) {
            throw new APIException(
                'Error code 2007: API key has exceeded calls per month quota.<br />Error code 2008: API key has ' .
                'been disabled.',
                $_httpContext
            );
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        $mapper = $this->getJsonMapper();

        return $mapper->mapClassArray($response->body, 'WeatherAPILib\\Models\\SearchJsonResponse');
    }

    /**
     * IP Lookup API method allows a user to get up to date information for an IP address.
     *
     * @param string $q Pass IP address.
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function getIpLookup(
        $q
    ) {

        //prepare query string for API call
        $_queryBuilder = '/ip.json';

        //process optional query parameters
        APIHelper::appendUrlWithQueryParameters($_queryBuilder, array (
            'q' => $q,
            'key' => Configuration::$key,
        ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::$BASEURI . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json'
        );

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::GET, $_headers, $_queryUrl);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::get($_queryUrl, $_headers);

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //Error handling using HTTP status codes
        if ($response->code == 400) {
            throw new APIException(
                'Error code 1003: Parameter \'q\' not provided.Error code 1005: API request url is invalid.Error ' .
                'code 1006: No location found matching parameter \'q\'Error code 9999: Internal application error.',
                $_httpContext
            );
        }

        if ($response->code == 401) {
            throw new APIException(
                'Error code 1002: API key not provided.Error code 2006: API key provided is invalid',
                $_httpContext
            );
        }

        if ($response->code == 403) {
            throw new APIException(
                'Error code 2007: API key has exceeded calls per month quota.<br />Error code 2008: API key has ' .
                'been disabled.',
                $_httpContext
            );
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'WeatherAPILib\\Models\\IpJsonResponse');
    }

    /**
     * Return Location Object
     *
     * @param string $q Pass US Zipcode, UK Postcode, Canada Postalcode, IP address, Latitude/Longitude (decimal
     *                  degree) or city name. Visit [request parameter section](https://www.weatherapi.com/docs/#intro-
     *                  request) to learn more.
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function getTimeZone(
        $q
    ) {

        //prepare query string for API call
        $_queryBuilder = '/timezone.json';

        //process optional query parameters
        APIHelper::appendUrlWithQueryParameters($_queryBuilder, array (
            'q' => $q,
            'key' => Configuration::$key,
        ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::$BASEURI . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json'
        );

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::GET, $_headers, $_queryUrl);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::get($_queryUrl, $_headers);

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //Error handling using HTTP status codes
        if ($response->code == 400) {
            throw new APIException(
                'Error code 1003: Parameter \'q\' not provided.Error code 1005: API request url is invalid.Error ' .
                'code 1006: No location found matching parameter \'q\'Error code 9999: Internal application error.',
                $_httpContext
            );
        }

        if ($response->code == 401) {
            throw new APIException(
                'Error code 1002: API key not provided.Error code 2006: API key provided is invalid',
                $_httpContext
            );
        }

        if ($response->code == 403) {
            throw new APIException(
                'Error code 2007: API key has exceeded calls per month quota.<br />Error code 2008: API key has ' .
                'been disabled.',
                $_httpContext
            );
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'WeatherAPILib\\Models\\TimezoneJsonResponse');
    }

    /**
     * Return Location and Astronomy Object
     *
     * @param string   $q  Pass US Zipcode, UK Postcode, Canada Postalcode, IP address, Latitude/Longitude (decimal
     *                     degree) or city name. Visit [request parameter section](https://www.weatherapi.
     *                     com/docs/#intro-request) to learn more.
     * @param DateTime $dt Date on or after 1st Jan, 2015 in yyyy-MM-dd format
     * @return mixed response from the API call
     * @throws APIException Thrown if API call fails
     */
    public function getAstronomy(
        $q,
        $dt
    ) {

        //prepare query string for API call
        $_queryBuilder = '/astronomy.json';

        //process optional query parameters
        APIHelper::appendUrlWithQueryParameters($_queryBuilder, array (
            'q'  => $q,
            'dt' => DateTimeHelper::toSimpleDate($dt),
            'key' => Configuration::$key,
        ));

        //validate and preprocess url
        $_queryUrl = APIHelper::cleanUrl(Configuration::$BASEURI . $_queryBuilder);

        //prepare headers
        $_headers = array (
            'user-agent'    => BaseController::USER_AGENT,
            'Accept'        => 'application/json'
        );

        //call on-before Http callback
        $_httpRequest = new HttpRequest(HttpMethod::GET, $_headers, $_queryUrl);
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnBeforeRequest($_httpRequest);
        }

        //and invoke the API call request to fetch the response
        $response = Request::get($_queryUrl, $_headers);

        $_httpResponse = new HttpResponse($response->code, $response->headers, $response->raw_body);
        $_httpContext = new HttpContext($_httpRequest, $_httpResponse);

        //call on-after Http callback
        if ($this->getHttpCallBack() != null) {
            $this->getHttpCallBack()->callOnAfterRequest($_httpContext);
        }

        //Error handling using HTTP status codes
        if ($response->code == 400) {
            throw new APIException(
                'Error code 1003: Parameter \'q\' not provided.Error code 1005: API request url is invalid.Error ' .
                'code 1006: No location found matching parameter \'q\'Error code 9999: Internal application error.',
                $_httpContext
            );
        }

        if ($response->code == 401) {
            throw new APIException(
                'Error code 1002: API key not provided.Error code 2006: API key provided is invalid',
                $_httpContext
            );
        }

        if ($response->code == 403) {
            throw new APIException(
                'Error code 2007: API key has exceeded calls per month quota.<br />Error code 2008: API key has ' .
                'been disabled.',
                $_httpContext
            );
        }

        //handle errors defined at the API level
        $this->validateResponse($_httpResponse, $_httpContext);

        $mapper = $this->getJsonMapper();

        return $mapper->mapClass($response->body, 'WeatherAPILib\\Models\\AstronomyJsonResponse');
    }
}
