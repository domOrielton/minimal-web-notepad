
# minimal-web-notepad

This is a fork of the excellent [pereorga/minimalist-web-notepad](https://github.com/pereorga/minimalist-web-notepad) with additional functionality - the additional code does add size so not minimalist but still minimal at 10kb when minified and gzipped. If you want to go really minimalist then pereorga's implementation is under 3kb and that's not even minified! Password functionality is implemented by adding a header line to the text file which isn't displayed on the note ** be aware this does not encypt the contents, just limits access ** . The only server requirements are an Apache webserver with mod_rewrite and PHP enabled.

![edit screenshot](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_edit.png)

Added functionality to [pereorga's](https://github.com/pereorga/minimalist-web-notepad) original:

 - view option for note with URLs hyperlinked (very useful for mobile)
 - password protection with option for read only access
 - view only link
 - show last saved time of note
 - copy note url, view only url and note text to clipboard
 - view note in sans-serif or mono font
 - ability to download note
 - list of available notes
 - turn features on and off to reduce page size if needed

See demo at http://note.rf.gd/ or http://note.rf.gd/some-note-name-here. The demo doesn't have https so you will see password warnings in your browser - *do not* use it for anything other than a test.

Screenshots
------------

**Note in View mode**

![view screenshot](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_view.png)

**Responsive menu for mobile compatibility**

![mobile menu screenshot](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_mobile_menu_expanded.png) ![mobile menu screenshot](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_mobile_menu.png)

**Mono font**

![mono display screenshot](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_mono.png)

**Password protection**

![password protection screenshot](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_password.png)

**Password prompt for protected note**

![password prompt screenshot](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_password_prompt.png)

The 'View as Read Only' link shows the note text and nothing else

**Links for copying to clipboard**

![copy screenshot](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_copy.png)

**Note list** - generally only used for a URL that is not public, although the page is password protected

![note list screenshot](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_notelist.png)

If you don't want the note list to show then either set the $allow_noteslist parameter to false at the top of index.php or just rename `notelist.php` to something else. The password for the note list page is at the top of `notelist.php` - Protect\with('modules/protect_form.php', 'change the password here');

**Alternative editing view**

There is also an alternative editing view that can be accessed by adding ?simple after the note e.g. /quick?simple. I personally find this view very useful for adding very quick notes on my phone - it has a small edit area at the top of the page and when you enter text and hit newline it adds it to the note and moves it to to the view that takes up the rest of the page. This view section shows URLs as clickable links. You can't set passwords on this view but it does honor them.

![copy screenshot](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_simple.png)

Installation
------------

No configuration should be needed as long as mod_rewrite is enabled and the web server is allowed to write to the `_notes` data directory. This data directory is set in `config.php` so if you want to change it to the folder used by the original pereorga/minimalist-web-notepad version then change it there. All the notes are stored as text files so a server running Apache (or Nginx) should be enough, no databases required.

If notes aren't saving then please check the permissions on the `_notes` directory - 0755 or 744 should be all that is needed.

![permissions screenshot](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_permissions.png)

There is also a `setup.php` page that can be used to check the `_notes` directory exists and can be written to. If you are having difficulty saving notes it may be worth deleting the `_notes` directory and then going to the `setup.php` page to create the folder. If all is working ok then you can delete the `setup.php` file if you wish.

There may be scenarios where the $base_url variable in `config.php` needs to be replaced with the hardcoded URL path of your installation. If that is the case just replace the line in `config.php` beginning with  `$base_url = dirname('//'` with `$base_url ='http://actualURL.com/notes'` replacing actualURL.com/notes with whatever is relevant for your installation.

### On Apache

You may need to enable mod_rewrite and set up `.htaccess` files in your site configuration.
See [How To Set Up mod_rewrite for Apache](https://www.digitalocean.com/community/tutorials/how-to-set-up-mod_rewrite-for-apache-on-ubuntu-14-04).

## On nginx

On nginx, you will need to ensure nginx.conf is configured correctly to ensure the application works as expected.
Please check the nginx.conf.example file or the [view without password issue](https://github.com/domOrielton/minimal-web-notepad/issues/4). Credit to [eonegh](https://github.com/eonegh) for the example file.
