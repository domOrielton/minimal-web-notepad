
# minimal-web-notepad

This is a fork of [pereorga/minimalist-web-notepad](https://github.com/pereorga/minimalist-web-notepad) with additional functionality - the additional code does add size so not minimalist but still minimal at just over 10kb when minified and gzipped. If you want to go really minimalist then pereorga's implementation is under 3kb and that's not even minified! Password functionality is implemented by adding a header line to the text file which isn't displayed on the note.

![edit screenshot](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_edit.png)

Added functionality to [pereorga's](https://github.com/pereorga/minimalist-web-notepad) excellent original:

 - view option for note with URLs hyperlinked (very useful for mobile)
 - password protection with option for read only access
 - view only link
 - show last saved time of note
 - copy note url, view only url and note text to clipboard
 - view note in sans-serif or mono font
 - ability to download note
 - list of available notes
 - turn features on and off to reduce page size of needed

See demo at http://note.rf.gd/ or http://note.rf.gd/some-note-name-here.

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

No configuration should be needed as long as mod_rewrite is enabled and the web server is allowed to write to the `_notes` directory. All the notes are stored as text files so a server running Apache (or Nginx) should be enough, no databases required.

### On Apache

You may need to enable mod_rewrite and set up `.htaccess` files in your site configuration.
See [How To Set Up mod_rewrite for Apache](https://www.digitalocean.com/community/tutorials/how-to-set-up-mod_rewrite-for-apache-on-ubuntu-14-04).
