


# How to run tests


## Unit tests
php vendor/bin/phpunit -c test/phpunit.xml

## Code style
php vendor/bin/phpcs --standard=./test/codesniffer.xml --encoding=utf-8 --extensions=php -p -s lib









## TODO 

### add CSP to HTML response.



// TODO - we could lock down the javascript and other resources that can be run on
// a site, via a CSP header, like one of the following.
//
// Content-Security-Policy: default-src 'self'; ...; report-uri /my_amazing_csp_report_parser;
// Content-Security-Policy: script-src 'unsafe-inline';
// Content-Security-Policy-Report-Only: default-src 'self'; ...; report-uri /my_amazing_csp_report_parser;
// Content-Security-Policy: default-src 'none'; script-src 'self' 'unsafe-inline' www.google-analytics.com; img-src www.google-analytics.com;

    // Cache-Control: must-revalidate
    // Cache-Control: no-cache
    // Cache-Control: no-store
    // Cache-Control: no-transform
    // Cache-Control: public
    // Cache-Control: private
    // Cache-Control: proxy-revalidate
    // Cache-Control: max-age=<seconds>
    // Cache-Control: s-maxage=<seconds>