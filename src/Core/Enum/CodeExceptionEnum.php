<?php

declare(strict_types=1);

namespace App\Core\Enum;

enum CodeExceptionEnum: int
{
    case ENTITY_VALIDATION = 1003;
    case CATEGORY_NOT_FOUND = 1004;
    case CREATE_CATEGORY_ERROR = 1005;
    case INVALID_JSEND_STATUS = 1006;
    case JSEND_ERROR_MESSAGE_REQUIRED = 1007;
    case ERROR_LIST_CATEGORY = 1008;
    case ERROR_UPDATE_CATEGORY = 1009;
    case GENRE_NOT_FOUND = 1010;
    case ERROR_CREATE_GENRE = 1011;
    case ERROR_UPDATE_GENRE = 1012;
    case ERROR_DELETE_GENRE = 1013;
    case ERROR_LIST_GENRES = 1014;
    case CAST_MEMBER_NOT_FOUND = 1015;
}
