<?php

return [
    'valid_domains' => explode(',', env('VALID_LOGIN_DOMAINS', 'prologuetechnology.com')),
    'valid_users' => explode(',', env('VALID_LOGIN_USERS', '')),
];
