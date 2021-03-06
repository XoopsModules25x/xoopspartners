<?php
/*
 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Module: xoopsPartners
 *
 * @package         module\Xoopspartners\include
 * @author          ZySpec <zyspec@yahoo.com>
 * @copyright       https://xoops.org 2001-2016 XOOPS Project
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @since           1.13
 */
$moduleDirName = basename(dirname(__DIR__));
$helper        = \Xmf\Module\Helper::getHelper($modueDirName);
$helper->loadLanguage('admin');
//require_once dirname(__DIR__) . "/language/english/admin.php"; // messages will be in english

if (false === @session_start()) {
    throw new \RuntimeException('Session could not start.');
}

global $hdrs;
$hdrs = [];
/**
 * Function to put HTTP headers in an array
 *
 * @param resource $curl
 * @param string  $hdrLine
 *
 * @return int length of header line put into array
 */
function xoopspartnersHandleHeaderLine($curl, $hdrLine)
{
    global $hdrs;
    $hdrs[] = trim($hdrLine);

    return mb_strlen($hdrLine);
}

/**
 * @param string $hdr
 * @param        $hdrArray
 * @param bool   $asArray
 * @return array|false|string array($hdr=>value) or false if not found
 */
function xoopspartnersGetHeaderFromArray($hdr, $hdrArray, $asArray = false)
{
    $val = '';
    foreach ($hdrArray as $thisHdr) {
        if (preg_match("/^{$hdr}/i", $thisHdr)) {
            $val = mb_substr($thisHdr, mb_strlen($hdr));
            break;
        }
    }

    return (bool)$asArray ? [$hdr => trim($val)] : trim($val);
}

$serviceUrl   = "https://github.com/XoopsModules25x/{$moduleDirName}/issues?state=open";
$sessPrefix   = "{$moduleDirName}_";
$err          = '';
$sKeyEtag     = "{$sessPrefix}github_etag";
$sKeyHdrSize  = "{$sessPrefix}github_hdr_size";
$sKeyResponse = "{$sessPrefix}github_curl_response";
$sKeyArray    = [$sKeyEtag, $sKeyHdrSize, $sKeyResponse];

$cachedEtag = isset($_SESSION[$sKeyEtag]) ? base64_decode(unserialize($_SESSION[$sKeyEtag]), true) : false;
if ($cachedEtag) {
    // found the session var so check to see if anything's changed since last time we checked
    $curl = curl_init($serviceUrl);
    curl_setopt_array(
        $curl,
        [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => true,
            CURLOPT_VERBOSE        => true,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_HTTPGET        => true,
            CURLOPT_USERAGENT      => "XOOPS-{$moduleDirName}",
            CURLOPT_HTTPHEADER     => [
                'Content-type:application/json',
                'If-None-Match: ' . $cachedEtag,
            ],
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_HEADERFUNCTION => 'xoopspartnersHandleHeaderLine',
        ]
    );
    // execute the session
    $curl_response = curl_exec($curl);
    // get the header size and finish off the session
    $hdrSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    curl_close($curl);

    $status = xoopspartnersGetHeaderFromArray('Status: ', $hdrs);
    if (preg_match('/^304 Not Modified/', $status)) {
        // hasn't been modified so get response & header size from session
        $curl_response = isset($_SESSION[$sKeyResponse]) ? base64_decode(unserialize($_SESSION[$sKeyResponse]), true) : [];
        $hdrSize       = isset($_SESSION[$sKeyHdrSize]) ? unserialize($_SESSION[$sKeyHdrSize]) : 0;
    } elseif (preg_match('/^200 OK/', $status)) {
        // ok - request new info
        $hdrs = []; //reset the header array for new curl op
        $curl = curl_init($serviceUrl);
        curl_setopt_array(
            $curl,
            [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER         => true,
                CURLOPT_VERBOSE        => true,
                CURLOPT_TIMEOUT        => 5,
                CURLOPT_HTTPGET        => true,
                CURLOPT_USERAGENT      => "XOOPS-{$moduleDirName}",
                CURLOPT_HTTPHEADER     => ['Content-type:application/json'],
                CURLOPT_HEADERFUNCTION => 'xoopspartnersHandleHeaderLine',
            ]
        );
        // execute the session
        $curl_response = curl_exec($curl);
        // get the header size and finish off the session
        $hdrSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        curl_close($curl);

        $hdrEtag                 = xoopspartnersGetHeaderFromArray('Etag: ', $hdrs);
        $_SESSION[$sKeyEtag]     = serialize(base64_encode($hdrEtag));
        $_SESSION[$sKeyHdrSize]  = serialize((int)$hdrSize);
        $_SESSION[$sKeyResponse] = serialize(base64_encode($curl_response));
    } elseif (preg_match('/^403 Forbidden/', $status)) {
        // probably exceeded rate limit
        $responseArray = explode('\n', $curl_response);
        $msgEle        = array_search('message: ', $responseArray, true);
        if (false !== $msgEle) {
            //found the error message so set it
            $err = mb_substr($responseArray[$msgEle], 8); //get the message
        } else {
            // couldn't find error message, but something went wrong
            // clear session vars
            foreach ($sKeyArray as $key) {
                $_SESSION[$key] = null;
                unset($_SESSION[$key]);
            }
            $err = _AM_XOOPSPARTNERS_ISSUES_ERR_UNKNOWN;
        }
    } else {
        // unknown error condition - display message
        // clear session vars
        foreach ($sKeyArray as $key) {
            $_SESSION[$key] = null;
            unset($_SESSION[$key]);
        }
        $err = _AM_XOOPSPARTNERS_ISSUES_ERR_STATUS;
    }
} else {
    // nothing in session so request new info
    $hdrs = [];
    $curl = curl_init($serviceUrl);
    curl_setopt_array(
        $curl,
        [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => true,
            CURLOPT_VERBOSE        => true,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_HTTPGET        => true,
            CURLOPT_USERAGENT      => "XOOPS-{$moduleDirName}",
            CURLOPT_HTTPHEADER     => ['Content-type:application/json'],
            CURLOPT_HEADERFUNCTION => 'xoopspartnersHandleHeaderLine',
        ]
    );
    // execute the session
    $curl_response = curl_exec($curl);
    // get the header size and finish off the session
    $hdrSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    curl_close($curl);

    $hdrEtag                 = xoopspartnersGetHeaderFromArray('Etag: ', $hdrs);
    $_SESSION[$sKeyEtag]     = serialize(base64_encode($hdrEtag));
    $_SESSION[$sKeyHdrSize]  = serialize((int)$hdrSize);
    $_SESSION[$sKeyResponse] = serialize(base64_encode($curl_response));
}
$hdr        = mb_substr($curl_response, 0, $hdrSize);
$rspSize    = mb_strlen($curl_response) - $hdrSize;
$response   = mb_substr($curl_response, -$rspSize);
$issuesObjs = json_decode($response); //get as objects

echo "    <br>\n"
     . '    <h4 class="odd">'
     . _AM_XOOPSPARTNERS_ISSUES_OPEN
     . "</h4>\n"
     . "    <p class=\"even\">\n"
     . "    <table>\n"
     . "      <thead>\n"
     . "      <tr>\n"
     . '        <th class="center width10">'
     . _AM_XOOPSPARTNERS_HELP_ISSUE
     . "</th>\n"
     . '        <th class="center width10">'
     . _AM_XOOPSPARTNERS_HELP_DATE
     . "</th>\n"
     . '        <th class="center">'
     . _AM_XOOPSPARTNERS_HELP_TITLE
     . "</th>\n"
     . '        <th class="center width10">'
     . _AM_XOOPSPARTNERS_HELP_SUBMITTER
     . "</th>\n"
     . "      </tr>\n"
     . "      </thead>\n"
     . "      <tbody>\n";

$pullReqFound = false;
$suffix       = '';
$cssClass     = 'odd';
$i            = 0;
if (!empty($issuesObjs)) {
    foreach ($issuesObjs as $issue) {
        if (isset($issue->pull_request)) {
            /** @internal {uncomment the following line if you don't want to see pull requests as issues}}} */
            //            continue; // github counts pull requests as open issues so ignore these

            $suffix       = '*';
            $pullReqFound = true;
        } else {
            $suffix = '';
        }

        $dateTimeObj = DateTime::createFromFormat(DateTime::ISO8601, $issue->created_at);
        $dispDate    = $dateTimeObj->format('Y-m-d');
        ++$i; // issue count

        echo "      <tr>\n"
             . "        <td class=\"{$cssClass} center\">"
             . '<a href="'
             . $issue->html_url
             . '" target="_blank">'
             . (int)$issue->number
             . "{$suffix}</a>"
             . "</td>\n"
             . "        <td class=\"{$cssClass} center\">{$dispDate}</td>\n"
             . "        <td class=\"{$cssClass} left\" style=\"padding-left: 2em;\">"
             . htmlspecialchars($issue->title, ENT_QUOTES | ENT_HTML5)
             . "</td>\n"
             . "        <td class=\"{$cssClass} center\">"
             . '<a href="'
             . htmlspecialchars($issue->user->html_url, ENT_QUOTES | ENT_HTML5)
             . '" '
             . 'target="_blank">'
             . htmlspecialchars($issue->user->login, ENT_QUOTES | ENT_HTML5)
             . '</a>'
             . "</td>\n"
             . "      </tr>\n";
        $cssClass = ('odd' === $cssClass) ? 'even' : 'odd';
    }
}

if (!empty($err)) {
    echo "    <tr><td colspan=\"4\" class=\"{$cssClass} center bold italic\">" . htmlspecialchars($err, ENT_QUOTES | ENT_HTML5) . "</td></tr>\n";
} elseif (0 == $i) { // no issues found
    echo "    <tr><td colspan=\"4\" class=\"{$cssClass} center bold italic\">" . _AM_XOOPSPARTNERS_ISSUES_NONE . "</td></tr>\n";
}

if ($pullReqFound) {
    echo "    <tfoot>\n" . '      <tr><td colspan="4" class="left italic marg3 foot">' . _AM_XOOPSPARTNERS_ISSUES_NOTE . "</td></tr>\n" . "    </tfoot>\n";
}
echo "    </tbody></table></p>\n";
