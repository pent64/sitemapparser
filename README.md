#Main info
##Instalation
* git clone ...
* composer install -o
* php index.php

## Configuration
In index.php there are 5 variables
* $sitemap_url - write url of your sitemap xml file, you can use sitemap that includes urls to other sitemaps;
* $new_domain - if you need to change domains while parsing, enter new domain value (ex. 'https://example.com');
* $old_domain - if you need to change domains while parsing, enter old domain that was written in sitemap you entered above (ex. 'https://example.com');
* $to_html - boolean, enter true if you want to get result in html < a > tags with counter as text inside;
* $output - leave empty if you want result be echoed, or enter file path where to write result;