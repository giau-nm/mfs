<?php

if (!defined('PAGGING_NUMBER_DEFAULT')) {
    define('PAGGING_NUMBER_DEFAULT', 20);
}
if (!defined('EMAIL_ADMIN_DEFAULT')) {
    define('EMAIL_ADMIN_DEFAULT', 'giaunm.56@gmail.com');
}
if (!defined('COMPANY_EMAIL_DOMAIN')) {
    define('COMPANY_EMAIL_DOMAIN', [
        'gmail.com',
    ]);
}
if (!defined('REQUEST_LONG_TIME_TEXT')) {
    define('REQUEST_LONG_TIME_TEXT', [
        1 => 'request.longTimeText',
        0 => 'request.shortTimeText'
    ]);
}
if (!defined('REQUEST_STATUS_TEXT')) {
    define('REQUEST_STATUS_TEXT', [
        1 => 'request.newRequest',
        2 => 'request.acceptedRequest',
        3 => 'request.rejectRequest',
        4 => 'request.paidRequest',
    ]);
}
if (!defined('STATUS_ERROR')) {
    define('STATUS_ERROR', 'error');
}
if (!defined('STATUS_SUCCESS')) {
    define('STATUS_SUCCESS', 'success');
}
if (!defined('LIST_STATUS_DEVICES')) {
    define('LIST_STATUS_DEVICES', [0 => 'break', 1 => 'buzy', 2 => 'avaiable']);
}
if (!defined('STATUS_DEVICES_BREAK')) {
    define('STATUS_DEVICES_BREAK', 0);
}
if (!defined('STATUS_DEVICES_BUZY')) {
    define('STATUS_DEVICES_BUZY', 1);
}
if (!defined('STATUS_DEVICES_AVAIABLE')) {
    define('STATUS_DEVICES_AVAIABLE', 2);
}
if (!defined('STATUS_REPORT_NEW')) {
    define('STATUS_REPORT_NEW', 1);
}
if (!defined('STATUS_REPORT_RECEIVED')) {
    define('STATUS_REPORT_RECEIVED', 2);
}
if (!defined('STATUS_REPORT_PROCESSED')) {
    define('STATUS_REPORT_PROCESSED', 3);
}
if (!defined('STATUS_REPORT_REJECT')) {
    define('STATUS_REPORT_REJECT', 0);
}
if (!defined('STATUS_REQUEST_NEW')) {
    define('STATUS_REQUEST_NEW', 1);
}
if (!defined('STATUS_REQUEST_ACCEPT')) {
    define('STATUS_REQUEST_ACCEPT', 2);
}
if (!defined('STATUS_REQUEST_REJECT')) {
    define('STATUS_REQUEST_REJECT', 3);
}
if (!defined('STATUS_REQUEST_PAID')) {
    define('STATUS_REQUEST_PAID', 4);
}
if (!defined('LIST_CLASS_STATUS_DEVICES')) {
    define('LIST_CLASS_STATUS_DEVICES', [0 => 'danger', 1 => 'warning', 2 => 'success']);
}
if (!defined('EXPIRED_REQUEST_COMMAND_TEXT')) {
    define('EXPIRED_REQUEST_COMMAND_TEXT', 'done');
}
if (!defined('MAX_REQUEST_DATE')) {
    define('MAX_REQUEST_DATE',  7);
}
if (!defined('KEY_PAGINATE_ALL_DEVICE')) {
    define('KEY_PAGINATE_ALL_DEVICE', 'page');
}
if (!defined('KEY_PAGINATE_ALL_DEVICE_EXPIRED')) {
    define('KEY_PAGINATE_ALL_DEVICE_EXPIRED', 'p');
}
if (!defined('KEY_PAGINATE_ALL_REQUESTING')) {
    define('KEY_PAGINATE_ALL_REQUESTING', 'pg');
}
if (!defined('REQUEST_LONG_TIME')) {
    define('REQUEST_LONG_TIME', 1);
}
if (!defined('REQUEST_NOT_LONG_TIME')) {
    define('REQUEST_NOT_LONG_TIME', 0);
}
if (!defined('PAGGING_NUMBER_DEVICE_UPDATE')) {
    define('PAGGING_NUMBER_DEVICE_UPDATE', 6);
}

if (!defined('MAIL_NAME')) {
    define('MAIL_NAME', 'ADM');
}
