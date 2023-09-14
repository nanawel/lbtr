<?php

/**
 * Decode URL-safe base64 encoded string
 *
 * @see https://en.wikipedia.org/wiki/Base64#RFC_4648
 *
 * @param string $input
 * @return string
 */
function base64_url_decode(string $input): string {
    if (false === ($string = base64_decode(strtr($input, '-_.', '+/=')))) {
        throw new \InvalidArgumentException('Invalid base64url string.');
    }

    return $string;
}

foreach ($_GET as $p => $v) {
    switch ($p) {
        case 'header':
            if (is_array($v)) {
                foreach ($v as $header => $value) {
                    if (is_array($value)) {
                        foreach ($value as $subValue) {
                            header("$header: $subValue", false);
                        }
                    } else {
                        header("$header: $value");
                    }
                }
            } else {
                error_log('Invalid header definition, must be an array.');
            }
            break;
        
        case 'body':
            // Defer body rendering
            try {
                $body = base64_url_decode($v);
            } catch (\Throwable $e) {
                try {
                    $body = base64_decode($v);
                } catch (\Throwable $e) {
                    error_log("Unable to decode body (is it valid URL-compatible base64?): {$e->getMessage()}");
                }
            }
            break;
        
        default:
           error_log("Unsupported param: $p. Ignoring.");
    }
}

if (isset($body)) {
    die($body);
}