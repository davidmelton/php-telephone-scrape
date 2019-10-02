# PHP Telephone Scrape

## Usage

To collect phone numbers from a single web page, pass a url directly to the telephone_scrape() function.

```php
print telephone_scrape('http://www.example.com');`
```

To collect phone numbers from a list of web pages, pass an array of URLs to telephone_scrape()

```php
$urls = array(
	'http://www.example.com/contact.html',
	'http://www.example.com/about.html',
	'http://www.example.com/blog.html'
);

foreach ($urls as $url){
	print telephone_scrape( $url );
}
```
