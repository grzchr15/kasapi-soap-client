kasapi-soap-client
==================

I am putting here some things together which may from interrest also to others

*Access the kasserver.com via Soap

*Autoconfiguration Thunderbird for domains served from all-inkl.com

This solves the email address to IMAP/SMTP Thunderbird settings for All-inkl.com Customers when they want more automation.

=Story  =

I am customer from ALL-INKL.COM - Webhosting Server Hosting Domain Provider

You and i get there also mail accounts which have a system like

Loginname mXXXXXX were XXXXXX is a number. This number you need to know when you want to setup Thunderbird as Mailclient too. Most my users know there email adrress hosted at all-inkl.com , their password but not their login name.

kasserver-mailboxes

But wait there is help. At https://developer.mozilla.org/en-US/docs/Thunderbird/Autoconfiguration there is nice way of how autoconfiguration works with thunderbird.

All we need is a http://autoconfig.example.com/mail/config-v1.xml?emailaddress=fred@example.com were example.com is your/mine hosted domain at all-inkl.com.

So you can either edit a file based on your email boxes http://www.kasserver.com/. For the syntax see Mozilla documenation.

But i am frequently changing/adding/deleting email addresses and donot want do to that manual.

= Steps to follow  =

*created a host autoconfig.yourallinkldomain.tld 
*Use Code to gernerate thunderbird autoconfiguration


https://github.com/grzchr15/kasapi-soap-client

Be shure to setup your site with PHP > 5.0 ( see http://all-inkl.com/wichtig/ )

/xx/xx/pages/ <- should be root of website

/pages/admin/config_autoconfig.bretterhofer.at.php needs the account data.

= Voila= 

 Autokonfiguration with ALL-inkl for Thunderbird works

= Thanks =

With the help of Frank Steurich from Supportteam All-inkl and http://kasapi.kasserver.de/dokumentation there is a SOAP service API existant

See Github  https://github.com/grzchr15/kasapi-soap-client for SOAP services for https://www.kasserver.com

Ar   http://www.bretterhofer.at/blog/projects/autoconfiguration-thunderbird-for-domains-served-from-allinkl-com i show my atempts to used that SOAP services to make Autoconfiguration Thunderbird happen.

Feel free to fork and to make PULL requests

= Wiki = 
https://github.com/grzchr15/kasapi-soap-client/wiki