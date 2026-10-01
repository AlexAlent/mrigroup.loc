<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!function_exists('mriConsentPrivateRoot')) {
    function mriConsentPrivateRoot()
    {
        $documentRoot = rtrim(
            (string)($_SERVER['DOCUMENT_ROOT'] ?? ''),
            '/\\'
        );

        if ($documentRoot === '') {
            return '';
        }

        return dirname($documentRoot)
            . '/private/consent-evidence';
    }
}

if (!function_exists('mriConsentEnsurePrivateRoot')) {
    function mriConsentEnsurePrivateRoot()
    {
        $privateRoot = mriConsentPrivateRoot();

        if ($privateRoot === '') {
            return '';
        }

        if (
            !is_dir($privateRoot)
            && !@mkdir($privateRoot, 0700, true)
            && !is_dir($privateRoot)
        ) {
            error_log(
                'Consent evidence directory could not be created.'
            );

            return '';
        }

        @chmod($privateRoot, 0700);

        return $privateRoot;
    }
}

if (!function_exists('mriConsentGetKey')) {
    function mriConsentGetKey()
    {
        $privateRoot = mriConsentEnsurePrivateRoot();

        if ($privateRoot === '') {
            return false;
        }

        $keyFile = $privateRoot . '/.consent-log.key';

        if (!is_file($keyFile)) {
            try {
                $key = random_bytes(32);
            } catch (Throwable $error) {
                $key = hash(
                    'sha256',
                    uniqid((string)mt_rand(), true),
                    true
                );
            }

            if (
                @file_put_contents(
                    $keyFile,
                    $key,
                    LOCK_EX
                ) === false
            ) {
                error_log(
                    'Consent evidence key could not be created.'
                );

                return false;
            }

            @chmod($keyFile, 0600);
        }

        $key = @file_get_contents($keyFile);

        if ($key === false || $key === '') {
            return false;
        }

        return $key;
    }
}

if (!function_exists('mriConsentEvidenceId')) {
    function mriConsentEvidenceId()
    {
        try {
            return date('YmdHis') . '-' . bin2hex(random_bytes(8));
        } catch (Throwable $error) {
            return date('YmdHis') . '-' . sha1(
                uniqid((string)mt_rand(), true)
            );
        }
    }
}

if (!function_exists('mriConsentLimitText')) {
    function mriConsentLimitText($value, $length)
    {
        $value = trim((string)$value);

        if (function_exists('mb_substr')) {
            return mb_substr($value, 0, $length, 'UTF-8');
        }

        return substr($value, 0, $length);
    }
}

if (!function_exists('mriConsentNormalizePhone')) {
    function mriConsentNormalizePhone($value)
    {
        $digits = preg_replace('/\D+/', '', (string)$value);

        if (strlen($digits) === 11 && $digits[0] === '8') {
            $digits = '7' . substr($digits, 1);
        } elseif (strlen($digits) === 10) {
            $digits = '7' . $digits;
        }

        return $digits;
    }
}

if (!function_exists('mriConsentNormalizeEmail')) {
    function mriConsentNormalizeEmail($value)
    {
        $email = trim((string)$value);

        if (function_exists('mb_strtolower')) {
            return mb_strtolower($email, 'UTF-8');
        }

        return strtolower($email);
    }
}

if (!function_exists('mriConsentLookupHash')) {
    function mriConsentLookupHash($type, $value)
    {
        $key = mriConsentGetKey();

        if ($key === false) {
            return '';
        }

        if ($type === 'phone') {
            $normalized = mriConsentNormalizePhone($value);
        } elseif ($type === 'email') {
            $normalized = mriConsentNormalizeEmail($value);
        } else {
            $normalized = trim((string)$value);
        }

        if ($normalized === '') {
            return '';
        }

        return hash_hmac(
            'sha256',
            $type . ':' . $normalized,
            $key
        );
    }
}

if (!function_exists('mriConsentMaskPhone')) {
    function mriConsentMaskPhone($value)
    {
        $digits = mriConsentNormalizePhone($value);

        if (strlen($digits) < 4) {
            return '';
        }

        return '+7 (***) ***-'
            . substr($digits, -4, 2)
            . '-'
            . substr($digits, -2);
    }
}

if (!function_exists('mriConsentMaskEmail')) {
    function mriConsentMaskEmail($value)
    {
        $email = mriConsentNormalizeEmail($value);

        if (
            $email === ''
            || strpos($email, '@') === false
        ) {
            return '';
        }

        [$local, $domain] = explode('@', $email, 2);

        if ($local === '') {
            return '***@' . $domain;
        }

        $first = function_exists('mb_substr')
            ? mb_substr($local, 0, 1, 'UTF-8')
            : substr($local, 0, 1);

        return $first . '***@' . $domain;
    }
}

if (!function_exists('mriBuildConsentEvidence')) {
    function mriBuildConsentEvidence(
        $formType,
        array $consents,
        $consentVersion,
        $formUrl = '',
        array $identifiers = []
    ) {
        try {
            $date = new DateTimeImmutable(
                'now',
                new DateTimeZone('Europe/Moscow')
            );
        } catch (Throwable $error) {
            $date = new DateTimeImmutable('now');
        }

        $phone = (string)($identifiers['phone'] ?? '');
        $email = (string)($identifiers['email'] ?? '');

        return [
            'evidence_id' => mriConsentEvidenceId(),
            'submitted_at' => $date->format(DateTimeInterface::ATOM),
            'form_type' => mriConsentLimitText($formType, 100),
            'site_host' => mriConsentLimitText(
                $_SERVER['HTTP_HOST'] ?? '',
                255
            ),
            'form_url' => mriConsentLimitText($formUrl, 2000),
            'ip_address' => mriConsentLimitText(
                $_SERVER['REMOTE_ADDR'] ?? '',
                64
            ),
            'user_agent' => mriConsentLimitText(
                $_SERVER['HTTP_USER_AGENT'] ?? '',
                1000
            ),
            'consent_version' => mriConsentLimitText(
                $consentVersion,
                100
            ),
            'phone_lookup_hmac' =>
                mriConsentLookupHash('phone', $phone),
            'email_lookup_hmac' =>
                mriConsentLookupHash('email', $email),
            'phone_masked' =>
                mriConsentMaskPhone($phone),
            'email_masked' =>
                mriConsentMaskEmail($email),
            'personal_data_consent' =>
                !empty($consents['personal_data']),
            'privacy_acknowledged' =>
                !empty($consents['privacy']),
            'advertising_consent' =>
                !empty($consents['advertising']),
        ];
    }
}

if (!function_exists('mriFormatConsentEvidence')) {
    function mriFormatConsentEvidence(array $record)
    {
        return implode(PHP_EOL, [
            '--- Подтверждение согласий ---',
            'ID подтверждения: '
                . ($record['evidence_id'] ?? ''),
            'Дата и время: '
                . ($record['submitted_at'] ?? ''),
            'Тип формы: '
                . ($record['form_type'] ?? ''),
            'Страница: '
                . ($record['form_url'] ?? ''),
            'IP-адрес: '
                . ($record['ip_address'] ?? ''),
            'User-Agent: '
                . ($record['user_agent'] ?? ''),
            'Согласие на обработку персональных данных: '
                . (!empty($record['personal_data_consent'])
                    ? 'Да'
                    : 'Нет'),
            'Ознакомление с политикой: '
                . (!empty($record['privacy_acknowledged'])
                    ? 'Да'
                    : 'Нет'),
            'Согласие на рекламные сообщения: '
                . (!empty($record['advertising_consent'])
                    ? 'Да'
                    : 'Нет'),
            'Версия текстов согласий: '
                . ($record['consent_version'] ?? ''),
        ]);
    }
}

if (!function_exists('mriConsentRecordSignature')) {
    function mriConsentRecordSignature(array $record)
    {
        $key = mriConsentGetKey();

        if ($key === false) {
            return '';
        }

        unset($record['hmac_sha256']);

        $json = json_encode(
            $record,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
        );

        if ($json === false) {
            return '';
        }

        return hash_hmac('sha256', $json, $key);
    }
}

if (!function_exists('mriVerifyConsentEvidence')) {
    function mriVerifyConsentEvidence(array $record)
    {
        $stored = (string)($record['hmac_sha256'] ?? '');

        if ($stored === '') {
            return false;
        }

        $calculated = mriConsentRecordSignature($record);

        return $calculated !== ''
            && hash_equals($stored, $calculated);
    }
}

if (!function_exists('mriWriteConsentEvidence')) {
    function mriWriteConsentEvidence(array $record)
    {
        $privateRoot = mriConsentEnsurePrivateRoot();

        if ($privateRoot === '') {
            return false;
        }

        $signature = mriConsentRecordSignature($record);

        if ($signature === '') {
            return false;
        }

        $record['hmac_sha256'] = $signature;

        $line = json_encode(
            $record,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
        );

        if ($line === false) {
            return false;
        }

        $logFile =
            $privateRoot
            . '/consents-'
            . date('Y-m')
            . '.jsonl';

        $written = @file_put_contents(
            $logFile,
            $line . PHP_EOL,
            FILE_APPEND | LOCK_EX
        );

        if ($written === false) {
            error_log(
                'Consent evidence record could not be written.'
            );

            return false;
        }

        @chmod($logFile, 0600);

        return true;
    }
}

if (!function_exists('mriFindConsentEvidence')) {
    function mriFindConsentEvidence($query, $limit = 100)
    {
        $query = trim((string)$query);

        if ($query === '') {
            return [];
        }

        $privateRoot = mriConsentPrivateRoot();

        if (
            $privateRoot === ''
            || !is_dir($privateRoot)
        ) {
            return [];
        }

        $phoneHash = mriConsentLookupHash('phone', $query);
        $emailHash = mriConsentLookupHash('email', $query);

        $files = glob(
            $privateRoot . '/consents-*.jsonl'
        ) ?: [];

        rsort($files, SORT_STRING);

        $matches = [];

        foreach ($files as $file) {
            $handle = @fopen($file, 'rb');

            if (!$handle) {
                continue;
            }

            while (($line = fgets($handle)) !== false) {
                $record = json_decode($line, true);

                if (!is_array($record)) {
                    continue;
                }

                $isMatch =
                    hash_equals(
                        (string)($record['evidence_id'] ?? ''),
                        $query
                    )
                    || (
                        $phoneHash !== ''
                        && hash_equals(
                            (string)(
                                $record['phone_lookup_hmac']
                                ?? ''
                            ),
                            $phoneHash
                        )
                    )
                    || (
                        $emailHash !== ''
                        && hash_equals(
                            (string)(
                                $record['email_lookup_hmac']
                                ?? ''
                            ),
                            $emailHash
                        )
                    );

                if (!$isMatch) {
                    continue;
                }

                $record['_signature_valid'] =
                    mriVerifyConsentEvidence($record);
                $record['_source_file'] =
                    basename($file);

                $matches[] = $record;

                if (count($matches) >= $limit) {
                    break 2;
                }
            }

            fclose($handle);
        }

        usort(
            $matches,
            static function (array $left, array $right) {
                return strcmp(
                    (string)($right['submitted_at'] ?? ''),
                    (string)($left['submitted_at'] ?? '')
                );
            }
        );

        return $matches;
    }
}
