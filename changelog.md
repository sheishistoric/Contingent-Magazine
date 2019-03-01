# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
though this project doesn't succeed in adhering to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Largo 0.6.1](https://github.com/INN/largo/compare/v0.6...v0.6.1)

This release contains bugfixes for Largo 0.6.

### Changes

- Uses [`filemtime()`](https://secure.php.net/manual/en/function.filemtime.php) as the version number for more enqueued assets, meaning that cachebusting will be handled by file modification time and not by Largo version. [Pull Request #1575](https://github.com/INN/largo/pull/1575) for [issue #1550](https://github.com/INN/largo/issues/1550).
- For many assets where no version number was provided for enqueued assets, `largo_version()` is now used. [Pull Request #1575](https://github.com/INN/largo/pull/1575) for [issue #1550](https://github.com/INN/largo/issues/1550).
- Removes the list of recommended plugins displayed on new installations of Largo. [Pull Request #1580](https://github.com/INN/largo/pull/1580) for [issue #1570](https://github.com/INN/largo/issues/1570). We'll be bringing this list back in an updated form on an INN website; stay tuned.

### Fixes

- Updates templates to make sure that bylines are output. [Pull request #1574](https://github.com/INN/largo/pull/1574).
- Fixes a division-by-zero bug in avatar functions. [Pull request #1578](https://github.com/INN/largo/pull/1578) as part of [issue #1492](https://github.com/INN/largo/issues/1492).
- Allows the Largo Taxonomy List Widget to have an empty title. [Pull request #1583](https://github.com/INN/largo/pull/1583) for [issue #1581](https://github.com/INN/largo/issues/1581).
- Allows the Largo Recent Posts Widget to have an empty title. [Pull request #1588](https://github.com/INN/largo/pull/1588) for [issue #1405](https://github.com/INN/largo/issues/1405).
- Makes sure that the series, post type, and post prominence taxonomies appear in the REST API and in the Gutenberg editor. [Pull request #1586](https://github.com/INN/largo/pull/1586) for [issue #1582](https://github.com/INN/largo/issues/1582).

### Documentation and administrative improvements

- Lays groundwork for testing Largo under PHP 7.3. [Pull request #1587](https://github.com/INN/largo/pull/1587) for [issue #1579](https://github.com/INN/largo/issues/1579).
- Adds a pip `requirements.txt` for Sphinx dependencies required by Grunt tasks used during the development process. [Pull request #1585](https://github.com/INN/largo/pull/1585) for [issue #1359](https://github.com/INN/largo/issues/1359).
- Removes several unneccessary Grunt tasks from the Gruntfile, and their dependencies. [Pull request #1585](https://github.com/INN/largo/pull/1585) for [issue #1540](https://github.com/INN/largo/issues/1540).
- Removes some old developer setup instructions from the largo.readthedocs.io setup instructions. [Pull request #1585](https://github.com/INN/largo/pull/1585).

## [Largo 0.6](https://github.com/INN/largo/compare/v0.5.5.4...v0.6)

Special thanks to our community contributors:
- Mike Schinkel for his work on [pull request #1469](https://github.com/INN/largo/pull/1469) at WordCamp for Publishers 2017's Contributor Day
- GitHub user [fenriz07](https://github.com/fenriz07) for their work in [PR #1541](https://github.com/INN/largo/pull/1541) on updating links in our documentation


### New Features
- Adds Gutenberg support, with
	- editor styles
	- support for the `.alignwide` and `.alignfull` CSS classes and their use in blocks
	- pullquote styles

### Changes
- Fixes numerous undefined variable errors, as part of [issue #1492](https://github.com/INN/largo/issues/1492).
- Users who have the capability to edit a given post will see the edit link on the frontend, where before users with the capability to edit published posts in general saw the link to edit the post in the frontend. [PR #1559](https://github.com/INN/largo/pull/1559) for [issue #1543](https://github.com/INN/largo/issues/1543).
- Largo now uses WordPress' `title-tag` support for `<title>` tag output, which means that site title tags shoud now be modifiable by plugins. [PR #1566](https://github.com/INN/largo/pull/1566) for [issue #1470](https://github.com/INN/largo/issues/1470).
- If the [Yoast SEO plugin](https://wordpress.org/plugins/wordpress-seo/) is active, Largo's default [Open Graph Protocol](http://ogp.me/) and [Twitter Cards](https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/abouts-cards) tags will not be output. [PR #1567](https://github.com/INN/largo/pull/1567) for issues [#1437](https://github.com/INN/largo/issues/1437) and [#1470](https://github.com/INN/largo/issues/1470)
- Adds support for WordPress' `.screen-reader-text` CSS class. [PR #1530](https://github.com/INN/largo/pull/1530) for [issue #1528](https://github.com/INN/largo/issues/1528) as part of [issue #844](https://github.com/INN/largo/issues/844).
- Updates `.visuallyhidden` CSS styles in accordance with [the latest recommended technique](https://make.wordpress.org/accessibility/2015/02/09/hiding-text-for-screen-readers-with-wordpress-core/). [PR #1530](https://github.com/INN/largo/pull/1530) for [issue #1528](https://github.com/INN/largo/issues/1528) as part of [issue #844](https://github.com/INN/largo/issues/844).
- Thins the homepage stylesheets with LESS `(reference)` imports. [PR #1530](https://github.com/INN/largo/pull/1530) for [issue #1528](https://github.com/INN/largo/issues/1528) as part of [issue #844](https://github.com/INN/largo/issues/844).
- Adds a text domain to `style.css`. [PR #1527](https://github.com/INN/largo/pull/1527) as part of [issue #844](https://github.com/INN/largo/issues/844).
- Fixes a "WP_Admin_Bar::add_node was called incorrectly" warning message. [PR #1504](https://github.com/INN/largo/pull/1504) for [issue #1349](https://github.com/INN/largo/issues/1349).
- Modernizes Travis CI configuration to cover PHP 5.6, 7.0 and 7.1, and WordPress 4.6 through 5.0. Drops support for PHP 5.5 and earlier and WordPress 4.5 and earlier. [PR #1503](https://github.com/INN/largo/pull/1503) and [#1554](https://github.com/INN/largo/pull/1554).
- Where `largo_remove_hero()` removed duplicate hero images from the top of `the_content()`, the funciton no longer outputs empty paragraph tags, and now works on `img` tags without `src=""` attributes. [PR #1503](https://github.com/INN/largo/pull/1503/files#diff-751911f6a0ebcc05da47094668329397) for [issue #1404](https://github.com/INN/largo/issues/1404).
- Alphabetizes the contributor list in `readme.md`.

### Removed
- Deprecates `largo_fb_user_is_followable()`, [because Facebook changed their API](https://github.com/INN/largo/pull/1503#issuecomment-407869218).
- Removes the default inclusion of Google Analytics with INN's Largo Project IDs. [PR #1502](https://github.com/INN/largo/pull/1502) as part of [issue #1495](https://github.com/INN/largo/issues/1495), and by request.
- Removes the INN Member RSS widget, because the RSS feed it draws from is no longer supported or maintained by INN. Because the RSS feed was occasionally empty, the widget would result in 500 errors. [RP #1535](https://github.com/INN/largo/pulls/1535) for [issue #1511](https://github.com/INN/largo/issues/1511) and [#893](https://github.com/INN/largo/issues/893).
- Removes lingering traces of the Largo Featured Widget. [PR #1563](https://github.com/INN/largo/pull/1563) and [#1469](https://github.com/INN/largo/pull/1469) for [issue #1467](https://github.com/INN/largo/issues/1467), from Github user [mikeschinkel](https://github.com/mikeschinkel).
- Removes many uses of `extract()` in widgets and theme functions, and improves code quality in widgets.
- Removes uses of `screen_icon()` and `get_screen_icon()`, deprecated in WordPress 4.8. [PR #1523](https://github.com/INN/largo/pull/1531) for [issue #1523](https://github.com/INN/largo/issues/1523) as part of [issue #844](https://github.com/INN/largo/issues/844).
- Removes the `<title>` element from `header.php`, since Largo declares `title-tag` theme support. [PR #1566](https://github.com/INN/largo/pull/1566) for [issue #1470](https://github.com/INN/largo/issues/1470).
- Removes two remaining PHP short tags. [PR #1525](https://github.com/INN/largo/pull/1525) for [issue #844](https://github.com/INN/largo/issues/844).
- Removes some deprecated `style.css` metadata tags. [PR #1524](https://github.com/INN/largo/pull/1524) for [issue #844](https://github.com/INN/largo/issues/844).
- Removes Hipchat support from `.travis.yml`. [PR #1503](https://github.com/INN/largo/pull/1503).

### Upgrade notices
- If your child theme has significant custom styling, or has custom post templates, your theme may need to provide additional styles to ensure Gutenberg compatibility.
- A future version of Largo will require the third parameter of `largo_byline()` to be specified in all calls. [PR #1561](https://github.com/INN/largo/pull/1561) for [issue #1517](https://github.com/INN/largo/issues/1517) adds code that, in testing environments with `WP_DEBUG` or `LARGO_DEBUG` set to `true`, will result in server log messages. This is necessary to prevent mismatches between the Loop's global `$post` and the desired byline output. The third parameter of `largo_byline()` may be a `WP_Post` instance or a post ID. Example call: `largo_byline( true, false, get_the_ID() );`.

## [Largo 0.5.5.4](https://github.com/INN/largo/releases/tag/v0.5.5.4)

This is a maintenance release containing bug fixes for v0.5.5.

This release breaks compatibility with PHP versions before 5.5: https://github.com/INN/largo/pull/1407/files#r105924102 If you are still using PHP 5.5 or earlier, please be warned that they no longer receive security patches: https://secure.php.net/eol.php

- Updates some minor documentation
- Fixes a bug where using an image gallery on a post caused the post to scroll to the gallery upon page load (https://github.com/INN/largo/commit/8acc31d4d338a0dcf2b22041acb6044bd6df91be)
- Fixes a bug where the current post was included in a list of related posts for the current post (https://github.com/INN/largo/pull/1403)
- Fixes an `undefined` warning regarding meta boxes (https://github.com/INN/largo/pull/1408 for https://github.com/INN/largo/pull/1406)
- Fixes several `undefined` notices in featured media functionality (https://github.com/INN/largo/issues/1350)
- Cleans up `inc/helpers.php` (https://github.com/INN/largo/pull/1407)
- Reorders the featured media dialog's UI from "Embed, Video, Image, Gallery" to "Image, Gallery, Video, Embed" (https://github.com/INN/largo/pull/1408)

## [Largo 0.5.5.3](https://github.com/INN/largo/releases/tag/v0.5.5.3)

Maintenance release containing bug fixes for v0.5.5

### Features
- Removed a MySQL query that was causing unnecessary server load.
- Removed var_log() function calls creating errors
- Updated Largo update notification to rely on the update_themes capability
- Added thumbnail to featured image meta box on post edit screen
- Show byline separator on single post pages
- Retain sort order when opening featured media gallery modal window
- Added the lightbox view to single images
- Made the gallery/grid-view setup more user-friendly and consistent

## [Largo 0.5.5.1](https://github.com/INN/largo/releases/tag/v0.5.5.2)

Maintenance release containing bug fixes for v0.5.5

### Features
- Removed a MySQL query that was causing unnecessary server load.

## [Largo 0.5.5.1](https://github.com/INN/largo/releases/tag/v0.5.5.1)

Maintenance release containing bug fixes for v0.5.5

### Features
- Fixed issue with related posts [widget sometimes displaying current post](https://github.com/INN/Largo/issues/1381) (duplicating the display)
- Fixed [status notification issue](https://github.com/INN/Largo/issues/1377) when upgrading Largo
- Reverted visual updates made in v0.5.5 to display post Updated Date by default. These are now [available via a hook](https://github.com/INN/Largo/commit/36549b0bff6daa94694d0282cc1f1b5e7b80c98a#diff-f455f0ca1903cb74b64f07a3b236ce46R386).
- Fixed issue with [class variables not correctly printing](https://github.com/INN/Largo/commit/e50a032be75646ce655f5071d58e0c7fcbd6828e)
- Fixed [front end errors displaying in comments](https://github.com/INN/Largo/pull/1382).
- Made [twitter widget scrollable](https://github.com/INN/Largo/pull/1378).
- Minor code cleanup

## [Largo 0.5.5](https://github.com/INN/largo/releases/tag/v0.5.5)

### Documentation

The project website (largo.inn.org) is now the home for user-facing and admin-facing docs. Developer-facing docs remain at largo.readthedocs.io

### Features
- **Set Featured Media Button** has moved from above the post editor to a new metabox (https://github.com/INN/Largo/pull/1323 and https://github.com/INN/Largo/pull/1285 for https://github.com/INN/Largo/issues/698)
- Adds support for TinyMCE’s underlining and text color buttons, while removing Heading 1 (https://github.com/INN/Largo/pull/1295 for https://github.com/INN/Largo/issues/790, https://github.com/INN/Largo/pull/1296 for https://github.com/INN/Largo/issues/670)
- A new design for the gallery slider (https://github.com/INN/Largo/pull/1307)
- Enable displaying the sticky nav on all pages (https://github.com/INN/Largo/pull/1262, https://github.com/INN/Largo/pull/1266, and https://github.com/INN/Largo/pull/1269 for https://github.com/INN/Largo/issue/1260, https://github.com/INN/Largo/pull/1286)
- Improvements to search pages including cleaner styles, shorter excerpts, the publish date and the URL of the post, and new actions in Google Custom Search Engine and non-GCSE searches. (https://github.com/INN/Largo/pull/1167 for https://github.com/INN/Largo/issue/1162, https://github.com/INN/Largo/pull/1177, https://github.com/INN/Largo/pull/1237 for https://github.com/INN/Largo/issues/1235)
- Improvements to 404 pages, now including the query string that resulted in the 404 to aid in searching. (https://github.com/INN/Largo/pull/1168 for https://github.com/INN/Largo/issues/692)
- Adds “Job Title” to the list of fields that Co-Authors Plus allows guest authors to have (https://github.com/INN/Largo/pull/1098 for https://github.com/INN/Largo/issues/1097)
- Adds job title to the output of `largo_byline()` with and without Co-Authors plus enabled, but does not link it to the author’s byline page (https://github.com/INN/Largo/pull/1098 for https://github.com/INN/Largo/issues/1097)
- Adds the option to hide the email address of a Co-Authors Plus guest author in the author bio partial, which is used in the Largo Author Bio widget and the posts-by-author archive. (https://github.com/INN/Largo/pull/1098 for https://github.com/INN/Largo/issues/1097)
- A number of changes to the Largo Related Posts widget, including removing the option for placing the image before or after the headline and making the “Show byline” checkbox work (https://github.com/INN/Largo/pull/1243 for https://github.com/INN/Largo/issues/1242)
- A revised Largo Taxonomy List widget, including the ability to exclude terms, limiting output of related terms to 5 or fewer, making the “taxonomy” chooser into a `<select>` box, and adding the ability to sort alphabetically by term name or by newest term first (to fix a performance issue where it was outputting infinite terms) (https://github.com/INN/Largo/pull/1187)
- Supports a “None” option for top term, allowing posts to have no top term set (https://github.com/INN/Largo/pull/1090 for https://github.com/INN/Largo/issues/1082, https://github.com/INN/Largo/pull/1094)
- Posts that have been updated now display the updated date/time at the top of the post. This creates a new function `largo_edited_date()` which displays either the time since updated or the date of update. (https://github.com/INN/Largo/pull/1343 for https://github.com/INN/Largo/issues/1341)
- Adds the Largo `post-type` taxonomy to the list of taxomomies that can be chosen for a post’s Top Term. (https://github.com/INN/Largo/pull/1086 for https://github.com/INN/Largo/issues/1084)
- Ads are now horizontally centered within ad zones (https://github.com/INN/Largo/pull/1093)
- Improved Homepage Alert widget styles (https://github.com/INN/Largo/pull/1095)
- Adds Instagram and Pinterest as supported social networks (https://github.com/INN/Largo/pull/1099)
- Largo’s Floating Social Buttons are now enabled in the two-column post template and in custom templates for single posts (https://github.com/INN/Largo/pull/1102)
- Add a option to the Largo Recent Posts widget to toggle the presence of the publish date in the byline (https://github.com/INN/Largo/pull/1364)
- Add a new widget area “Header Widget”  in the header, floated to the right and limited to 320px wide. This is controlled by a checkbox in Theme Options > Advanced, and is best used for a newsletter signup or a donation call-to-action. (https://github.com/INN/Largo/pull/1114 for https://github.com/INN/Largo/issues/1038) 
- Improved support for Link Roundups in archives of posts (https://github.com/INN/Largo/pull/1122)
- Adds support for Largo-style featured media to the two-column classical layout (https://github.com/INN/Largo/pull/1140 for https://github.com/INN/Largo/issues/934)
- **Removes** the WordPress custom image sizes options page, because Largo forces these image sizes and the settings page has no meaning (https://github.com/INN/Largo/pull/1218 for https://github.com/INN/Largo/issues/404)
- **Removes** the Largo Explore Related widget, which was already deprecated and was breaking slideshows in posts that had categories. (https://github.com/INN/Largo/pull/1241 for https://github.com/INN/Largo/issues/1240)
- **Removes** the sidebar from the single-post single-column template, to match documentation. It shouldn’t have been showing up there. If you wish to display widgets in the single-column template, may we recommend the [Super Cool Ad Inserter Plugin](https://wordpress.org/plugins/super-cool-ad-inserter/)? (https://github.com/INN/Largo/pull/1292 for https://github.com/INN/Largo/issues/1104)
- General style cleanup and improvements

### Bugfixes
- Social media buttons are now translatable (https://github.com/INN/Largo/pull/1153)
- Uses `esc_url` instead of `esc_attr` to escape URLs passed to the Twitter and Facebook Share functions (https://github.com/INN/Largo/pull/1077 for https://github.com/INN/Largo/issues/1076)
- Better fallbacks in `largo_top_term` for posts with no top term set but top term display not set to “None”: attempt to display the category, the tags, and finally the post-type. (https://github.com/INN/Largo/pull/1094)
- Better fallbacks for the `via` attribute of the Twitter share link in post social media buttons, including supporting the Twitter accounts of Co-Authors Plus guest authors. (https://github.com/INN/Largo/pull/1107 for https://github.com/INN/Largo/issue/1088, https://github.com/INN/Largo/pull/1118 for https://github.com/INN/Largo/issues/1117)
- Removes `friend@example.com` from `mailto:` links in share buttons, and removes the JavaScript requirement for the email functionality (https://github.com/INN/Largo/pull/1192 for https://github.com/INN/Largo/issues/799, https://github.com/INN/Largo/pull/1281 for https://github.com/INN/Largo/issues/799)
- Properly escapes post titles in the Twitter and Facebook share links (https://github.com/INN/Largo/pull/1121, https://github.com/INN/Largo/pull/1147 for https://github.com/INN/Largo/issues/1134)
- Job titles are not output in bylines if the Largo custom byline text is set for a post (https://github.com/INN/Largo/pull/1109 for https://github.com/INN/Largo/issues/1108)
- Remove date duplication in the Recent Posts Widget (https://github.com/INN/Largo/pull/1111 for https://github.com/INN/Largo/issue/1110)
- If an author does not have a first name set in their profile, the “More by \___” text uses “More by this author” (https://github.com/INN/Largo/pull/1112)
- Actually respect the output of the `largo_post_social_links` filter (https://github.com/INN/Largo/pull/1142)
- Don’t display “Page Not Found” language on categories with a hierarchical header and fewer than 5 posts (https://github.com/INN/Largo/pull/1270 for https://github.com/INN/Largo/issues/898)
- Post Prominence terms created by users are now available in post add/edit screens (https://github.com/INN/Largo/pull/1255 for https://github.com/INN/Largo/issues/956)
- Switch Travis to using a Facebook user that doesn’t exist, after someone created an account using the name `abcdefghijklmnopqrstuvwxyz12` (https://github.com/INN/Largo/pull/1234 for https://github.com/INN/Largo/issues/1233)
- Adds a title for `/?post_type=` archives using `archive.php` (https://github.com/INN/Largo/pull/1232 for https://github.com/INN/Largo/issues/1231)
- Strip HTML tags from `og:` Open Graph tag contents (https://github.com/INN/Largo/pull/1279/files)
- A fix for the Don’t Miss menu’s label not displaying correctly (https://github.com/INN/Largo/pull/1284 for https://github.com/INN/Largo/issues/1083)
- Un-hides posts that were being skipped in the Recent Stories list (https://github.com/INN/Largo/pull/1287 for https://github.com/INN/Largo/issues/1219)
- Better detection of no related topics in `partials/archive-category-related.php`, which means that `largo_get_related_topics_for_category()` outputs an empty string if there are no related topics (https://github.com/INN/Largo/pull/1289 for https://github.com/INN/Largo/issues/1288)
- The update nag is no longer shown on fresh installs of Largo (https://github.com/INN/Largo/pull/1363 for https://github.com/INN/Largo/issues/690)
- In the Homepage Bottom Widget Area homepage bottom partial, `$wp_query->posts` is now temporarily an empty array for the duration of the partial (https://github.com/INN/Largo/pull/1354)
- Sticky navigation now supports menus named “More” (https://github.com/INN/Largo/pull/1339 for https://github.com/INN/Largo/issues/1336)
- `Largo_Related` now uses a modern `tax_query` for some queries, and uses the correct slugs for the Tag and Category taxonomies (https://github.com/INN/Largo/pull/1338)
- Replacing `showposts` with `posts_per_page` throughout (https://github.com/INN/Largo/pull/1313)
- Replace `get_currentuserinfo` with `wp_get_current_user` ([#1247](https://github.com/INN/Largo/pull/1247) from [Kirsten Lambertsen](https://github.com/MsPseudolus))
  `largo_get_avatar_src()` will no longer try to use author email addresses as user IDs when calling `largo_get_user_avatar_id` ([#1251](https://github.com/INN/Largo/pull/1251))
- All terms in the `prominence` taxonomy will now be displayed in the Prominence meta box on the post editor ([#1255](https://github.com/INN/Largo/pull/1255) by [RC Lations](https://github.com/rclations) for [#956](https://github.com/INN/Largo/issues/956))
- Add a closing `</ul>` to the Largo Recent Posts widget ([#1353](https://github.com/INN/Largo/pull/1353) for [#1330](https://github.com/INN/Largo/issues/1330) via @jmusal)
- Adds the user’s name and job title to the alt attribute of images in the Largo Staff Widget (https://github.com/INN/Largo/pull/1148)
- Adds theme support for `<title>` tags as reported by the Theme Check plugin (https://github.com/INN/Largo/pull/1245 from [Kirsten Lambertsen](https://github.com/MsPseudolus) for https://github.com/INN/Largo/issues/844)
- Cleans up many undefined variables, including but not limited to:
  https://github.com/INN/Largo/pull/1079 for https://github.com/INN/Largo/issues/1078
  https://github.com/INN/Largo/pull/1306 for https://github.com/INN/Largo/issues/1302
  https://github.com/INN/Largo/pull/1348

### Developer Notes / Potentially Breaking Changes
- Adds WordPress master, 4.6, 4.5, 4.3, and 4.3 to our Travis config and removes support for WordPress 3.9 and 4.0, while simplifying the Travis config. Thanks to @ntwb for his help here!  (https://github.com/INN/Largo/pull/1116 and https://github.com/INN/Largo/issues/1227 for https://github.com/INN/Largo/issues/1020)
- Fixes a bunch of tests that were broken by PHP 5.5 (https://github.com/INN/Largo/pull/1293 for https://github.com/INN/Largo/issues/1209)
- The minimum supported PHP version is now officially 5.3. This was already the case, because Largo uses anonymous functions, a feature introduced in PHP 5.3, but it was not documented until this release. (https://github.com/INN/Largo/pull/1345 for https://github.com/INN/Largo/issues/1344)
- Improved support for WordPress 4.5 and following (https://github.com/INN/Largo/pull/1239 for https://github.com/INN/Largo/issues/1238 and https://github.com/INN/Largo/pull/1225 for https://github.com/INN/Largo/issues/1224)
- **Formally deprecates** the constant `SHOW_STICKY_NAV`, which had been kept around since `0.5.4`. `0.5.4` had effectively deprecated it, but we didn’t make a note of that in the release notes and some sites were affected. https://github.com/INN/Largo/pull/1136 contained a backwards compatability fix for the `master` branch of Largo between `0.5.4` and `0.5.5`. See PR https://github.com/INN/Largo/issues/1136 and Issue https://github.com/INN/Largo/issues/1135
- Adds a counter to `archive.php` and `category.php` to allow running a new action `largo_loop_after_post_x` after every post, passing the counter and the context. This is useful if you want to output a widget area after the `n`th post. (https://github.com/INN/Largo/pull/1272)
  `largo_byline()` has been broken up into a number of classes and wrapper function, to make it easier to maintain. Child-theme replacements of `largo_byline()` as a [pluggable function](https://codex.wordpress.org/Pluggable_Functions) are not affected. Filtering functions hooked on the filter `largo_byline` are not affected. ([#1251](https://github.com/INN/Largo/pull/1251) and https://github.com/INN/Largo/pull/1265 for [#1126](https://github.com/INN/Largo/issues/1126), https://github.com/INN/Largo/pull/1312, https://github.com/INN/Largo/pull/1367, https://github.com/INN/Largo/pull/1343, https://github.com/INN/Largo/pull/1333)
  `largo_top_term()` now outputs `’’` empty strings if a post does not have a top term, which is saved as `‘none’` in the `’top_term’` post meta. (https://github.com/INN/Largo/pull/1090 for https://github.com/INN/Largo/issues/1082, https://github.com/INN/Largo/pull/1094)
- Cleans up the Largo Follow Widget to no longer require Twitter javascript (https://github.com/INN/Largo/pull/1115)
- Updates the markup used for the Facebook page widget (https://github.com/INN/Largo/pull/1115)
- Uses `rect_thumb` image size instead of `full` in `partials/content.php` (https://github.com/INN/Largo/pull/1125)
- Adds the top term to the post classes if it is set, in the form `top-term-{$taxonomy_slug}-{$term_slug}` (https://github.com/INN/Largo/pull/1132 for https://github.com/INN/Largo/issues/1119)
  `largo_remove_hero()` is now run on the two-column `’classic’` post template. This can be disabled with the filter `largo_remove_hero` to allow this to be disabled categorically or on a per-post basis. (https://github.com/INN/Largo/pull/1140 for https://github.com/INN/Largo/issues/934)
  `.hero` styles are no longer grouped under the `body.normal` selector (https://github.com/INN/Largo/pull/1140 for https://github.com/INN/Largo/issues/934)
- Updates TGMPA to the latest version and updates the list of recommended plugins (https://github.com/INN/Largo/pull/1151)
- Site-wide footers on Series Landing Page now use the correct `$post` (https://github.com/INN/Largo/pull/1176)
- Removes final references to Argo Links, replacing all references and recommendations with Link Roundups (https://github.com/INN/Largo/pull/1203 for https://github.com/INN/Largo/issues/926)
- Breaks up `inc/post-tags.php`, making that file smaller and putting some other functions in places that make more sense for them. This creates the new files `inc/pagination.php` and `inc/post-social.php` (https://github.com/INN/Largo/pull/1250)
  `partials/content-series.php` has been merged into `partials/content.php`, introducing new filter `largo_content_partial_arguments` to change the display of that and adding the new function `largo_content_partial_arguments_filter()` to affect how `partials/content.php` displays in certain contexts. This also removes rendering of YouTube videos in `partials/content.php` (https://github.com/INN/Largo/pull/1280 for https://github.com/INN/Largo/issues/1271 and https://github.com/INN/Largo/issues/1326)
- **Removes** the files for the deprecated Largo Sidebar Featured Posts, Largo Footer Featured Posts, and  \* Largo Featured Posts widgets (https://github.com/INN/Largo/pull/1294 for https://github.com/INN/Largo/issues/897)
- Adds new function `largo_maybe_top_term()` which outputs `largo_top_term()` wrapped in an `h5.top-tag` if and only if `largo_top_term()` would return a link. (https://github.com/INN/Largo/pull/1319, https://github.com/INN/Largo/issues/1318 for https://github.com/INN/Largo/issues/1316 and https://github.com/INN/Largo/pull/1317)
  ### New Actions and Filters
- Adds new filter `largo_additional_networks` to allow child themes to add additional social networks. (https://github.com/INN/Largo/pull/1115) 
- Applies `largo_get_partial_by_post_type` to support per-type custom partials in category and archive pages (https://github.com/INN/Largo/pull/1122, https://github.com/INN/Largo/pull/1258)
- Adds action hooks in the main navigation: (https://github.com/INN/Largo/pull/1101)
  `largo_before_main_nav_shelf`
  `largo_before_main_nav_list_items`
  `largo_after_main_nav_list_items`
  `largo_after_main_nav_shelf`
- Adds actions in `partials/largo-header.php` before and after `largo_header()`: (https://github.com/INN/Largo/pull/1114)
  `largo_header_before_largo_header`
  `largo_header_after_largo_header`
- Adds new filter `largo_archive_rounduplink_title` to allow Link Roundups to change the archive title (https://github.com/INN/Largo/pull/1127 for https://github.com/INN/Largo/issues/1123)
- The social links that are output in `largo_post_social_links` can now be edited using array functions using the `largo_post_social_more_social_links` filter (https://github.com/INN/Largo/pull/1128)
- Adds new action at the bottom of the one- and two-column single post templates called `largo_post_bottom_widget_area` The Article Bottom widget area is now hooked on this action as the function `largo_post_bottom_widget_area()`. (https://github.com/INN/Largo/pull/1131)
- Adds filter `largo_top_term_metabox_taxonomies` to allow changing which taxonomies terms may be drawn from for use as top terms (https://github.com/INN/Largo/pull/1200)
- Adds new action `largo_after_category_river` to match `largo_before_category_river`, adds `largo_category_acter_description_in_header` which runs in the header before `get_template_part('partials/archive', 'category-related');` (https://github.com/INN/Largo/pull/1217)

### Outside contributor shout-outs

https://github.com/yayannabelle for documenting all of Largo’s todos: https://github.com/INN/Largo/issues/963 and https://github.com/INN/Largo/pull/1327

https://github.com/jmusal for https://github.com/INN/Largo/pull/1353

@ntwb for https://github.com/INN/Largo/pull/1227

Thanks to [Kirsten Lambertsen](https://github.com/MsPseudolus) for [#1247](https://github.com/INN/Largo/pull/1247) and https://github.com/INN/Largo/pull/1245

Thanks to [RC Lations](https://github.com/rclations) for [#1255](https://github.com/INN/Largo/pull/1255) before we hired him.

## [Largo 0.5.4](https://github.com/INN/largo/releases/tag/v0.5.4)

<img width="640" alt="release_notes_banner" src="https://cloud.githubusercontent.com/assets/9565066/12328921/fd59a918-ba9a-11e5-86e0-cc78f476f74f.png">

### New Features
- Full navigation overhaul - menus have a new look, better proportions and interactions
  - Menu items collapse into More dropdown as browser resizes (#1061, #376)
  - New styles for mobile and tablet navigation (#732)
  - Sticky navigation fades as user scrolls down, reappears as they scroll up.
  - Add option for different brand name for use in Sticky Navigation (#1059)
  - Sticky navigation no longer overlaps WordPress Admin Bar for logged-in users (#808)
  - Settings moved to their own Navigation tab in Theme Options.
- New social media buttons on single-column posts (#961)
- Featured Images for Terms (#928)
- Remove Sticky Footer from Posts (#974)
- Add option to Largo Taxonomy List widget to display series thumbnails (#927)
- New WordPress Filter in article-bottom Widget area (for Analytic Bridge plugin) (#971)

### Documentation
- Largo development with Grunt (#1036 for #454)
- Installing development dependencies using npm install (#1036 for #953) 
- New navigation documentation (#1041)
- New filters for Load More Posts (#1028, #1043)
- Add Featured Media to Terms (#1016)
- PHP inline documentation for navigation partials and header (#603, #604, #605, #606, #607)

### Bugs Fixed
- Navigation shows on Pages, adopting the same settings as Posts (#1062)
- Featured Posts on Category Archive Pages now receive proper post_class (#1052)
- Load minified JavaScript for Load More Posts, respecting LARGO_DEBUG constant (#967)
- Header search box style consistency (#937)
- Fix display of text-only brand name/logo in sticky navigation on internal pages (#870)
- Remove background color from hover state on sticky navigation logo, replace with transparency (#767)

### Developer Notes / Potentially Breaking Changes
- Largo Featured Posts, Largo Footer Featured Posts, and Largo Sidebar Featured Posts widgets will be replaced with the more-configurable Largo Recent Posts widget. (#987 for #982)
- Files for the Largo Featured widgets will be removed in the next release of Largo. (#897)
- Search view now uses partial chooser similar to Load More Posts (#1021 for #1023 and #1018)
- Removes “emeritus” and “honorary” profile fields (#1050)
- Removes Picturefill, which was unused. (#1049)

## [Largo 0.5.3](https://github.com/INN/largo/releases/tag/v0.5.3)

### New Features
- Added backwards lookup to Largo_Related class (allows Largo Related widget to look at both newer and older posts when querying for related items) (#842)
- Enhancements to the Largo Taxonomy List Widget, including the option to display thumbnails and headlines from the most-recent post in the taxonomy (#932)
- Converted all links in Largo Follow widget to simple anchor tags, instead of using third-party widgets (#769)
- Removed “Show read more link?” from Largo Recent Posts widget (#883)
- Removed third-party social buttons from single-post template, for privacy and page speed (#943)
- Make nav menus “display: inline” in one column footer (#850)
- Improved styles for Largo Sidebar Featured widget (#800)
- Improved styles for the optional social media buttons in the article header and in the Largo Follow widget in the Article Bottom widget area (#951 for #950)
- Break out `less/inc/widgets.less` into per-widget less files (#882)
- General improvements to widget styles (#942)
- Thumbnails in many places gain a play icon overlay (#923 for #836)
- Switches to INN logo with grey text (#879)
- Adds new actions to the homepage: `largo_before_sticky_posts`, `largo_after_sticky_posts`, `largo_after_homepage_bottom` (#966 for #965)

### Documentation
- Added inline documentation to several template partials (#892)
- Fixed API documentation generation command in `Gruntfile.js` (#892)

### Bug Fixes
- Added missing “Save” button to Largo Author Bio widget options (#889)
- Fix duplicate widget titles (#891)
- Fix update notice displaying to users that do not have permission to run updates (#855)
- Fix styling of Largo Tag List widget (#840)
- Fix footer widget areas 2 and 3 showing in widget settings when using layout with only one available widget area (#853)
- Properly set the default widgets for the “Article Bottom” widget area (#728)
- Various fixes for bugs related to updating/migrating from pre-v0.4 Largo (#728)
- Site logo in the sticky navigation no longer receives a background color when hovered upon (#979 for #767)
- The Load More Posts button will use the correct partial for archive pages (#925 for #868)
- Refactors the category page code to make it clearer when featured posts will be displayed (#875 for #869)
- Fixes for Load More Posts and the ability to use more than one Load More Posts button on a page.
- Fixes #878, a missing `>` introduced in Largo version 0.5.2.

### Potentially-Breaking Changes
- If your theme defines `largo_load_more_posts_data`, make sure that it [properly defines](https://github.com/INN/Largo/blob/868-correct-partial-on-archives/inc/ajax-functions.php#L47) `is_home` in the LMP AJAX request. (#925)
- Largo now uses the `.is-video` tag for thumbnail images that are for featured videos. Check your theme for conflicting styles. ([#923](https://github.com/INN/Largo/pull/923/files))

## [Largo 0.5.2](https://github.com/INN/largo/releases/tag/v0.5.2)

Read the [announcement blog post](http://nerds.inn.org/2015/08/18/inns-wordpress-framework-for-news-sites-now-fully-supports-https/) on INN's Nerds blog.

### Bugfixes and enhancements
- Featured Media editor enhancements (#832):
  - User can now set a thumbnail for embed and video Featured Media
  - Video Featured Media editor will attempt to pull a thumbnail from any available oEmbed provider if the user has not set their own thumbnail
  - Add "featured-media" and "featured-media-{type}" to story containers to allow for special treatment via CSS
- Fix malformed "mailto:" links in docs (#824)
- Adjust the INN logo and credit in site footer and remove "Member since" option for INN members (#761)
- Add new footer layout options (#761):
  - 4-column asymmetrical layout, with three narrow columns and one wide column. THis is well suited for three custom menus and an image widget.
  - 1-column centered layout, well-suited for a minimalist navigation
- Update TGM Plugin Activation class to [2.5.2](https://github.com/TGMPA/TGM-Plugin-Activation/releases)
- Remove use of border-radius throughout Largo, with the exception of some social media buttons (#777)
- Add basic styles for Largo Sidebar Featured widget (#800)
- Prevent homepage layouts from enqueueing assets on non-home pages (#830)
- Fix formatting of update message (#801)
- Remove margin-bottom on search form in sticky nav (#804)
- Improve HTTPS support by removing "http" and "https" from LESS customizer output (#815)
- Allow for filtering of "Load More Posts" arguments (#822)
- Fix a bug where Largo outputs markup for bylines despite having no author data to render said markup with (#826)
- Prevent Image widget image widths from stretching more than 100% the width of the container (#828)

## [Largo 0.5.1](https://github.com/INN/largo/releases/tag/v0.5.1)

A hearty thanks to contributors:
- Ben Welsh (@palewire): PR #700
- Josh Romero (@joshuarrrr): PR #723
- Chris Harmoney (@nipoez): PR #455

### Features
- Google Custom Search results are now displayed in the WordPress search results page instead of a popup. Use the “Results only” layout in GCSE for best results (PR #758 for Issue #730)
- The WordPress Admin Bar now contains useful links for Largo (PR #751)
- Plugin installation notices are hidden for users that cannot install Plugins (PR #740)
- Author bios now include Email vCard metadata (PR #700, thanks to Ben Welsh)
- Some Widgets font sizes have changed, for improved readability (PR #733, #755)
- Social media icon colors updated to reflect latest brand colors (PR #750)
- The ‘Donate’ link shows up in the sticky nav on smaller screen sizes, instead of being hidden

### Documentation
- Improved API docs and user-facing docs (PR #757)
- Overhaul of [Largo developer docs](https://largo.readthedocs.org/developers/index.html)
  - [Semi-functioning API documentation](https://largo.readthedocs.org/api/)
  - [Revised technical notes](https://largo.readthedocs.org/developers/index.html#technical-notes)
  - [Instructions for setting up a development environment](https://largo.readthedocs.org/developers/index.html#setting-up-a-development-environment)
  - [Working with Largo to create Child Themes](https://largo.readthedocs.org/developers/index.html#child-themes)

### Developer-facing changes

**Breaking Change**: If you redefined `largo_load_more_posts` in your child theme, you will need to update it with [code from this release](https://github.com/INN/Largo/blob/v0.5.1/inc/ajax-functions.php#L70), as [the old logic](https://github.com/INN/Largo/blob/v0.5/inc/ajax-functions.php#L67) will fail to load the correct posts.
- The Load More Posts button can now be used multiple times on one page (PR #786 for #745)
- The Load More Posts button text can be changed with the `largo_next_posts_link` filter. (1c125269b6fb01f5cf25bb8f945f0bba8f44539c)- The list of users in the Largo Staff widget is now filterable using `largo_staff_widget_users`. [Example use in nonprofitquarterly.org’s theme on lines 177-202 of functions.php](https://bitbucket.org/projectlargo/theme-npq/src/eb3d2d1d966907c0181236f409ce5b27442f1b61/functions.php?at=master#cl-177). (PR #701)
- `largo_excerpt()` no longer uses `$use_more` and `$more_link` arguments. **These arguments have been deprecated**, and will be ignored. (PR #759 and #765 for issues #52 and #764)
- The footer, sidebar, and article-bottom widget areas, and the navigation are excluded from consideration in Google’s searches using the `nocontent` class. (PR #743 and #772 for issue #664)
- The number of posts in the homepage template is now filterable (PR #744 and #776 for #742)
- Theme update functions are now organized (PR #739)
- When the update functions are run, new options will have the defaults set. (PR #734 for issue #727)
- The tablet size check in largoCore.js is now for window widths less than or equal to 768px wide, instead of less than 768px wide. (PR #704)
- The Series Landing Page permalink now uses an improved filter (PR #455, thanks to Chris Harmoney)
- Various fixes related to sidebars for Series Landing Pages (PR #788 for issue #642)
- The hero image partial has been enhanced with a filterable set of functions (PR #724, #737):
  - `largo_hero`: Prints the hero
  - `largo_get_hero`: Returns the hero
  - `largo_featured_image_hero`: One featured image
  - `largo_featured_gallery_hero`: A featured image gallery
  - `largo_featured_embed_hero`: An embedded video. Ex: YouTube or Vimeo
- Travis now tests against WordPress 4.1.5 and 4.2.2 (fbe7b72b3421047eb2d47c0667cc7beef60df7d3) and uses `sudo: false` (0d8b89d36ddd1e80dc00fca8f19ac6ff617238e2 for #738)

### Bugfixes
- Miscellaneous typo fixes
- Bugfix for staff avatars not displaying on the `[roster]` shortcode (PR #754)
- The “Exit Clean Read” button is no longer hidden by the sticky navigation (PR #781 for #768)
- Largo_Related once again looks both forwards and backwards in time for related posts in series, categories and tags (PR #789 for #782)
- The Load More Posts button now works with the `”` character in a search query (PR #673)

## [Largo 0.5](https://github.com/INN/largo/releases/tag/v0.5)

### Features
- LESS source maps are now included in unminified CSS (Issue #369, PR #646)
- Refactored/updated slideshows (PR #643, Issue #371)
- Refactored most recent widget display styles (#444)
- Added `LARGO_DEBUG` constant to allow use of unminified and uncompressed development versions of all CSS and Javascript (#432)
  - For CSS, this includes sourcemaps.
- Updated references to INN following INN’s rebranding (Issue #425, PR #428)
- Clickable hero images for river view (Issue #457, PR #461)
- Set default Single Column Layout (Issue #438)
- Added custom taxonomies to menus (Issue #401, PR #640)

### Bugfixes
- Largo Related Posts widget now requires less resources (Issue #671, PR #676)
- Largo Footer is now aligned left
- Load More Posts functions as expected on Category Pages (Issue #499, PR #636
- Various fixes for the sticky nav (PR #460)
- Various fixes for byline and authors (Issue #445, #446) 
- Fixes for the layout of single column story template (remove negative margins) (Issue #379, #290, PR #420)
- Fix for Facebook® debugging (Issue #462)
- Fix for Largo Author Widget on Series Landing Pages (Issue #452, PR #639)
- Fix margins on images without alignment (Issue #443)
- Fix for Top Story term, replace it with Homepage Top Story (Issue #414, PR #424)
- Fix Homepage single w/series displays additional stories in list at the top right (Issue #408, PR #429)
- Fix for Edit Featured Media to enable adding an image after deleting a gallery (Issue #392)
- Fixes to Clean Contact(Issue #355, #370 PR #372 )

### Documentation
- First pass at documentation for all PHP functions
  - Example http://largo.readthedocs.org/en/develop/api/inc/ajax-functions.html

## [Largo 0.4.1](https://github.com/INN/largo/releases/tag/v0.4.1)

### Features
- Largo Recent Posts widget now has options to show byline and top term for posts
- The featured image of the “Top Story” homepage templates now stretch to fill the frame ([#383](https://github.com/INN/Largo/issues/383))
- Improved print styles ([#382](https://github.com/INN/Largo/issues/382))
- Breakpoints for Doubleclick For Wordpress [now included](https://github.com/INN/Largo/blob/v0.4.1/inc/ad-codes.php)
- `largo_get_the_main_feature()` can be passed a WP_Post object
- Branding now uses Institute for Nonprofit News and inn.org ([#425])(https://github.com/INN/Largo/issues/425)
- Dates are displayed on single column article pages ([#405](https://github.com/INN/Largo/issues/405))

### Bugfixes
- INN_MEMBER constant is respected in child themes ([#386](https://github.com/INN/Largo/issues/386))
- Duplicate hero images should be removed from posts
- `largo_excerpt` now works outside The Loop ([#426](https://github.com/INN/Largo/issues/426))
- Homepage Single Story With Series now displays the correct series
- Changes to Load More Posts button ([#394](https://github.com/INN/Largo/issues/394))
- Largo Image widget no longer runs the widget_title filter twice
- Largo Staff widget now uses the author posts URL instead of the author twitter URL.
- Largo Series Posts widget styles now match other widgets ([#384](https://github.com/INN/Largo/issues/384))
- Homepage Single Story layout shows correct byline ([#415](https://github.com/INN/Largo/issues/415))
- Improvements to the options update functions introduced in 0.4
  - Sticky navigation now enabled by default if not previously set ([#377](https://github.com/INN/Largo/issues/377))
  - “Top Story” prominence from 0.3 is now renamed to “Homepage Top Story” to prevent duplication

### Documentation:
- [Instructions on additional tools when posting](http://largo.readthedocs.org/users/posting.html)
- [Instructions for recompiling translation files](http://largo.readthedocs.org/developers/fordevelopers.html#technical-notes)
- [Staff roster shortcode documentation](http://largo.readthedocs.org/users/staffpage.html)
- [Common ways of customizing custom landing pages](http://largo.readthedocs.org/users/landingpages.html)
- Typo and formatting fixes

## [Largo 0.4](https://github.com/INN/largo/releases/tag/v0.4)

This changes everything.

[Here's an overview of what's changed](http://nerds.inn.org/2015/01/27/announcing-largo-version-0-4/) and [here's more documentation](http://largo.readthedocs.org/) on ReadTheDocs.org.

