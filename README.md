#Purge

A command line application to find and flag potentially unused CSS from your site. (Currently a work in progress). 


##Usage

###Installation

Download Purge and extract to a location of your choosing.


###Running Purge

Change into the src directory of Purge and run it with the following command

``` bash
php purge.php purge:run <css file> <html file> <output file>
```

For a list of other commands run

``` bash
php purge.php purge:run --help
```

*Commands are subject to change as Purge is intended to support reading from multiple CSS and HTML files.



##To-Do

- Support usage of sitemap.xml for HTML files
- Support multiple CSS and HTML files
- Pull HTML files directly from framework routes (Symfony, Laravel, etc)
- Flag duplicated or overwritten CSS rules


##Resources

Thanks to @sabberworm for the wonder PHP CSS Parsing library
Thanks to @symfony for their Console components


##Misc

To run unit tests, ensure phpunit is installed and navigate to the root directory of Purge. Run the following command:
``` bash
phpunit --bootstrap vendor/autoload.php tests/
```

##License


