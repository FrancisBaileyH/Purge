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

- [ ] Support usage of sitemap.xml for HTML files
- [ ] Support multiple CSS and HTML files
- [ ] Pull HTML files directly from framework routes (Symfony, Laravel, etc)
- [ ] Flag duplicated or overwritten CSS rules
- [ ] Ability to ignore specificed CSS selectors


##Resources

Thanks to @sabberworm for the wonder PHP CSS Parsing library
Thanks to @symfony for their Console components


##Misc

To run unit tests, ensure phpunit is installed and navigate to the root directory of Purge. Run the following command:
``` bash
phpunit --bootstrap vendor/autoload.php tests/
```

##License

The MIT License (MIT)

Copyright (c) 2015 Francis Bailey

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

