## Description:
This an AJAX multi-level comment system, that allows infinite level comment and replies.

## How to Install:
You can install the comment system very easily by using composer. You just have to run:

`composer require magkopian/php-infinite-multi-level-comments`

Alternatively you can add it as a dependency in you `composer.json` file,

```JSON
{
	"require": {
		"magkopian/php-infinite-multi-level-comments": "1.0.*"
	}
}
```

and run `composer install`.

After installing the comment system move the `Config.template.php` file to `src/classes/Config.php` and
add to it your database credentials.

Finaly use the `sql/inf_comments.sql` to generate the `comment` table in your database.