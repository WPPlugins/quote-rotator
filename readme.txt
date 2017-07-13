=== Quote Rotator ===
Contributors: snumb130
Donate link: http://www.lukehowell.com/donate
Tags: widget, admin, sidebar, plugin, javascript, shortcode, jquery, quote
Requires at least: 2.8
Tested up to: 3.2.1
Stable tag: 4.0.4

Quote Rotator gives you the ability to put rotating quotes on your sidebar using a widget or in a post/page using a shortcode.

To add your quote, go to `Posts->Quotes`

To set the options for the, got to `Options->Quote Rotator`

There are options in the widget to customize your sidebar which are the same as the shortcode options

There is also a shortcode for using the rotator within a page.
`[quote_rotator title="Quote Rotator" number="5" howlong="3000" fadetime="700" random="1" height="200"]`
'title' is the title to show above the quotes section
'number' is the number of quotes to show
'howlong' is the number of milliseconds to display each quote
'fadetime' is how long the transistion takes in milliseconds
'random' is whether quotes are random.  1 is yes and 0 is no
'height' is how tall the quote section is

== Screenshots ==

1. Location of Quote Rotator Options Page in admin menu.
2. Options Page for Quote Rotator.
3. Location of Quotes in admin menu.
4. Quotes page to manage your quotes.
5. Short code added to post (or page).
6. Displaying quotes in a post (or page).
7. Widget options for sidebar widget.
8. Displaying quotes in sidebar widget.

== Upgrade Notice ==
= 4.0.3 =
 * Fixes error with missing quotes from old version.  You should have them back.
= 4.0.1 =
 * If your custom CSS is not working, this should fix it.
= 4.0 =
 * When updating your quotes should stay but it is best to back up first.  You will have to reset your widget options.

== Change Log ==
= 4.0.3 =
 * Fixes error with missing quotes from old version.  You should have them back.
= 4.0.2 =
 * Fix for css saving provided by Drew Kine
= 4.0.1 =
 * Fix error with custom CSS not being used.
= 4.0 =
 * Rewrite of plugin to functin with latest version of Wordpress and to fix some errors.
 * Added ability to add quote with a function 
= 3.5.6 =
 * Fixed error with dead link when trying to edit or delete quotes.
= 3.5.5 =
 * Added update to make compatible with Wordpress 2.7 Admin interface.
 * Moved author name on line under quote instead of on same line.
= 3.5.4 =
 * Just straightened some code.
= 3.5.3 =
 * Took out donate link as it is now on my site.
= 3.5.2 =
 * Added option for choosing font size unit.
= 3.4.2 =
 * Added ability to edit quotes.  (seggestion from rustykruffle.com)
 * Added widget option to choose whether quotes are in order or random.  (seggestion from rustykruffle.com as well as andrewpitchford.com/)
 * Added field to enter the author of the quote.  (suggestion from andrewpitchford.com/)
				  
= 2.4.2 =
 * With assistance from Dan Coulter, found variables clashing with other program.  With Dan's suggestion I placed JS in class and now problem solved.  Thanks again Dan.
 * Added option to choose font size.
			      
= 2.3.2 =
 * This version will pull quotes randomly from database.  Prevents visitors seeing same quotes over and over when you have a lot of quotes.  Thanks for suggestions from Mark (http://www.madmapper.co.za/).

= 2.2.2 =
 * Now able to enter quotation marks without trouble.  If there are any quotes in the database that have double quotes then you will have to manually change them to single quotes.

= 2.2.1 =
 * Changed database creation to include table prefix

= 2.2 =
 * Added option to choose time it take for fade.

= 2.1 =
 * Fixed Database creation issues. This time for real.  Sorry. :0

= 2.0 =
 * Fixed database creation issues.
 * Convert database column 'quote' from varchar to text.
 * Convert plugin to class.
 * Added option to track plugin version.
			      
= 1.0 =
 * First release.
== Installation ==

Old *busted* way to install this plugin:

1. Upload folder `quote-rotator` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Change your settings in `Options->Quote Rotator`
1. Add your quotes to `Pages->Quotes`
1. Place Quote Rotator widget on the sidebar you want and set the options.
	 OR
   Place `[quote_rotator title="Quote Rotator" number="5" howlong="3000" fadetime="700" random="1" height="200"]` in your post or page content area.

New *hotness* way to install this plugin:

1. From your wordpress plugin menu, click 'add new'.
1. Search for 'ctabs'.
1. Click 'Install Now'.
1. After install, click 'Activate'.
1. Change your settings in `Options->Quote Rotator`
1. Add your quotes to `Pages->Quotes`
1. Place Quote Rotator widget on the sidebar you want and set the options.
	 OR
   Place `[quote_rotator title="Quote Rotator" number="5" howlong="3000" fadetime="700" random="1" height="200"]` in your post or page content area.

The settings are as follows:
 * 'title' is the title to show above the quotes section
 * 'number' is the number of quotes to show
 * 'howlong' is the number of milliseconds to display each quote
 * 'fadetime' is how long the transistion takes in milliseconds
 * 'random' is whether quotes are random.  1 is yes and 0 is no
 * 'height' is how tall the quote section is

== Frequently Asked Questions ==
= Where do I add my quotes? =
 * Under the "Posts" tab of the admin page, there is a "Quotes" subpage.

= My widget quotes are overlapping other widgets. =
 * There is a widget option for the height of the widget to use.  Make sure that it is big enough for your largest quote.
