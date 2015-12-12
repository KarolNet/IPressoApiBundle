<?php

namespace KarolNet\IPressoApiBundle;

class IPressoApiResponseCode
{
    const OK = 200;
    const CREATE_OK = 201;
    const NON_AUTHORITATIVE = 203;
    const NO_CONTENT = 204;
    const A_LOT_OF_POSSIBILITIES = 300;
    const PERMANENTLY_MOVED = 301;
    const FOUND = 302;
    const SEE_OTHER = 303;
    const NOT_CHANGE = 304;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED_ACCESS = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const TOO_MANY_CALLS = 429;
    const INTERNAL_ERROR = 500;
    const NOT_IMPLEMENTED = 501;
}
