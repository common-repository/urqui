=== Plugin Name ===
Contributors: urqui
Donate link: http://urqui.com/
Tags: login, authentication, identity security, access keys, two factor authorization, privacy,
Requires at least: 3.0.1
Tested up to: 3.8
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

 
URQUi is based on ephemeral numbers, that are used as keys to identify individuals.

== Description ==
URQUi is based on ephemeral numbers, that are used as keys to identify individuals.

There are two related components to the framework. One that is used by an individual, and the second that is used by an organization(s).

At no time is any individuals personal information collected, transmitted or saved.

The individual component  is an application that functions on any mobile or digital device.  The  purpose of this application is to create keys, locally on the device, no cellular or Wi-Fi connection is required. A list of where you can get the app can be found <a href="http://urqui.com/web/title"> here.</a>


Features of plugin:
---
- Replace static password access with random key access.(presence of RQUi overrides password access).
- Add 2-factor authentication to login.
- Can be enabled for each user independently,
- Admin can force users to use 2FA.
- When 2FA is required, user will not have access, until user adds RQUi.
- If user registration allowed, user can input RQUi at time of registration.
 

== Installation ==

1. Upload `URQUi` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enter the RQUi found on mobile device app, in your user profile.
4. **Important** You must have the mcrypt library enabled in php.
 
== Frequently Asked Questions ==

Many answers to questions can be found <a href="http://urqui.com/web/faq"> here.</a>
= What happens if I have both a password and an RQUi? =

The presence of an RQUi in the User Profile, overrides the use of the password. Unless 2FA is enabled, the password should not be used.

= What if I only want users to use URQUi, not Admin =

The use of URQUi can be set to optional for each user. Only the presence of an RQUi in the User Profile, triggers the use of a URQUi access.

= What if I don't have access to my mobile device. =

You can use the password reset option. This will eliminate the RQUi in your profile, and you would then access your account normally.

== Screenshots ==

1. Login page with URQUi.
2. URQUi options
3. New field in User Profile.

== Changelog ==

= v1.1.0 =
* First release of the plugin
* update to use wp http

== Upgrade Notice ==
* update to use wp http
= 1.1 =
* update to use wp http
 