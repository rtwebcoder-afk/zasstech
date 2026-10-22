<?php
$isHttps = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") || (($_SERVER["SERVER_PORT"] ?? "") === "443");
session_set_cookie_params([
    "httponly" => true,
    "secure" => $isHttps,
    "samesite" => "Lax",
    "path" => "/",
]);
session_start();
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Permissions-Policy: camera=(), microphone=(), geolocation=()");
if ($isHttps) { header("Strict-Transport-Security: max-age=31536000; includeSubDomains"); }
$allowed=["ZassFood","Healthcare Appointment Platform","ZassMarket","Something else"];
function finish(int $status,string $title,string $message):never {
 http_response_code($status); $t=htmlspecialchars($title,ENT_QUOTES,"UTF-8"); $m=htmlspecialchars($message,ENT_QUOTES,"UTF-8"); $symbol=$status<400?"✓":"!";
 echo "<!doctype html><html lang=\"en\"><head><meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width,initial-scale=1\"><meta name=\"theme-color\" content=\"#5b21b6\"><title>{$t} | ZassTech</title><script src=\"https://cdn.tailwindcss.com\"></script><style>body{font-family:Arial,sans-serif}.gradient-hero{background:linear-gradient(118deg,#3b176d 0%,#5b21b6 35%,#176b93 72%,#0b9aa5 100%)}</style></head><body class=\"grid min-h-screen place-items-center bg-slate-50 p-5\"><main class=\"w-full max-w-lg rounded-3xl bg-white p-8 text-center shadow-xl sm:p-10\"><span class=\"mx-auto grid h-16 w-16 place-items-center rounded-2xl gradient-hero text-3xl text-white\">{$symbol}</span><h1 class=\"mt-6 text-3xl font-bold text-slate-900\">{$t}</h1><p class=\"mt-3 leading-7 text-slate-600\">{$m}</p><a href=\"index.php\" class=\"mt-7 inline-flex rounded-full bg-violet-700 px-6 py-3 font-bold text-white\">Back to ZassTech</a> <a href=\"contact.php#contact-form\" class=\"ml-2 inline-flex rounded-full border border-slate-200 px-6 py-3 font-bold text-slate-700\">Contact page</a></main></body></html>"; exit;
}
if($_SERVER["REQUEST_METHOD"]!=="POST"){header("Allow: POST");finish(405,"Method not allowed","Please submit the contact form to send us a message.");}
if (session_status() !== PHP_SESSION_ACTIVE) { finish(500, "Session unavailable", "Please try again shortly."); }
if(!empty($_POST["website"]))finish(200,"Thank you","Your message has been received.");
$posted=(string)($_POST["csrf_token"]??"");$token=(string)($_SESSION["csrf_token"]??"");if($posted===""||$token===""||!hash_equals($token,$posted))finish(400,"Form expired","Please return to the contact page, refresh it, and send your message again.");
$name=trim((string)($_POST["name"]??""));$email=trim((string)($_POST["email"]??""));$phone=trim((string)($_POST["phone"]??""));$interest=trim((string)($_POST["interest"]??""));$message=trim((string)($_POST["message"]??""));$consent=(string)($_POST["consent"]??"");
$invalid=strlen($name)<2||strlen($name)>100||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($email)>254||strlen($phone)>40||($phone!==""&&!preg_match("/^[0-9+().\-\s]{6,40}$/",$phone))||!in_array($interest,$allowed,true)||strlen($message)<10||strlen($message)>2000||$consent!=="yes";
if($invalid)finish(422,"Please check your details","Some details are missing or invalid. Return to the form and review your entries.");
// Set ZASSTECH_CONTACT_EMAIL and configure PHP mail to enable email delivery.
$recipient=getenv("ZASSTECH_CONTACT_EMAIL")?:"";$sent=false;
if($recipient!==""&&filter_var($recipient,FILTER_VALIDATE_EMAIL)){$subject="ZassTech enquiry: ".$interest;$body="Name: {$name}\nEmail: {$email}\nPhone: {$phone}\nInterest: {$interest}\n\nMessage:\n{$message}";$headers="From: ZassTech Website <noreply@zasstech.com>\r\nReply-To: {$email}\r\nContent-Type: text/plain; charset=UTF-8\r\n";$sent=mail($recipient,$subject,$body,$headers);}
if($sent){unset($_SESSION["csrf_token"]);finish(200,"Message sent","Thanks for reaching out. Your message is on its way, and our team will get back to you soon.");}
// Store submissions outside the public document root. Configure a persistent private directory for production.
$storage=getenv("ZASSTECH_CONTACT_STORAGE");if($storage===false||$storage==="")$storage=sys_get_temp_dir().DIRECTORY_SEPARATOR."zasstech-contact";
if(!is_dir($storage)&&!mkdir($storage,0750,true)&&!is_dir($storage)){error_log("ZassTech contact form: unable to initialize storage.");finish(503,"We could not save your message","Please try again shortly, or email rtwebcoder@gmail.com.");}
$storageReal=realpath($storage);$documentRoot=realpath((string)($_SERVER["DOCUMENT_ROOT"]??""));$insideDocumentRoot=$documentRoot!==false&&$storageReal!==false&&(strcasecmp($storageReal,$documentRoot)===0||stripos($storageReal,rtrim($documentRoot,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR)===0);
if($storageReal===false||$insideDocumentRoot){error_log("ZassTech contact form: storage must be outside the public document root.");finish(503,"We could not save your message","Please try again shortly, or email rtwebcoder@gmail.com.");}
$entry=["received_at"=>gmdate("c"),"name"=>$name,"email"=>$email,"phone"=>$phone,"interest"=>$interest,"message"=>$message];$saved=file_put_contents($storageReal.DIRECTORY_SEPARATOR."contact-submissions.jsonl",json_encode($entry,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).PHP_EOL,FILE_APPEND|LOCK_EX);
if($saved===false){error_log("ZassTech contact form: unable to save submission.");finish(503,"We could not save your message","Please try again shortly, or email rtwebcoder@gmail.com.");}unset($_SESSION["csrf_token"]);finish(200,"Message received","Thanks for getting in touch. Your message has been saved, and the ZassTech team will follow up soon.");
?>
