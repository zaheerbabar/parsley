<?php
namespace Site\Helpers;

class ClientError extends Helper
{
    public static function statusCode() {
        return isset($_SERVER['REDIRECT_STATUS']) ? $_SERVER['REDIRECT_STATUS'] : \http_response_code();
    }
    
    public static function title($code = null) {
        if (empty($code)) $code = self::statusCode();
        
        switch ($code) {
            case '400':
                return 'Bad Request';
            case '401':
                return 'Unauthorized';
            case '403':
                return 'Forbidden';
            case '404':
                return 'Not Found';
            case '405':
                return 'Method Not Allowed';
            case '408':
                return 'Request Timeout';
            case '414':
                return 'URI Too Long';
            case '500':
                return 'Internal Server Error';
            case '502':
                return 'Bad Gateway';
            case '504':
                return 'Gateway Timeout';
            default:
                return 'Unknown Error';
        }
    }
    
    public static function message($code = null) {
        if (empty($code)) $code = self::statusCode();
        
        switch ($code) {
            case '400':
                return 'The request cannot be fulfilled due to bad format.';
            case '401':
                return 'It appears that you\'re not authorized. Make sure the credentials you entered are correct.';
            case '403':
                return 'Sorry, you\'re not authorized to access this area.';
            case '404':
                return 'We\'re sorry, but the page you\'re looking for is missing, hiding, or maybe it moved somewhere else';
            case '405':
                return 'The method specified in the Request-Line is not allowed for the specified resource.';
            case '408':
                return 'Your browser failed to send a request in the time allowed by the server.';
            case '414':
                return 'The URL you entered is longer than the maximum length.';
            case '500':
                return 'The request was unsuccessful due to an unexpected condition encountered by the server.';
            case '502':
                return 'The server received an invalid response from the upstream server while trying to fulfill the request.';
            case '504':
                return 'The upstream server failed to send a request in the time allowed by the server.';
            default:
                return 'An unknown error has occurred.';
        }
    }
}