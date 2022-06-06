![img](RockLanguage.svg)

<br>

### Finally a good and easy way to ship ProcessWire modules with translation files 🥳

<br>

Quickstart:

1. Install the module
1. Optional: Set custom language mappings
1. Enjoy two-way language file syncing

![img](hr.svg)

# Donations

[![img](https://github.com/baumrock/RockFinder3/raw/master/donate.svg)](https://paypal.me/baumrock)

😎🤗👍

# The Problem

ProcessWires translation system itself is great. You can easily add translatable strings in any PHP file and the string will show up in the site's translation interface.

Once that string is translated ProcessWire stores a json file in `/site/assets/files/{languageID}`. That is good as long as you only want to translate site-specific stuff, but what if you wanted to translate a single module that you are using in many of your projects? You'd need to copy those json files over from project to project, find the correct folder to copy to, look up the page id of the language and so on. For me these tasks are neither easy nor enjoyable.

On the other hand [since version 3.0.181 we have the option to ship our modules with translation files](https://processwire.com/blog/posts/pw-3.0.181-hello/). So what is the problem with that solution? For me the workflow is extremely tedious as well. Even for translating a single word you have to take several steps like exporting a csv file, copying it over to your module and so on.

# RockLanguage works totally different

RockLanguage maps language names to standardized 2-letter-code folders:

```
default=DE
english=EN
dutch=FI
```

Once that easy setup is done RockLanguage will sync files from PW to your modules' language folders and vice versa.

Every Module that ships with a `RockLanguage` folder will now automatically be synced with your site translation files.

## Way 1: Pulling translations from Modules to ProcessWire

Example:
```php
// src language files from module
/site/modules/FooModule/RockLanguage/DE/...

// target folder from PW site
/site/assets/files/{id-of-german-language}/...
```

In the example the `FooModule` ships with german RockLanguage translations (in the `DE` folder). RockLanguage will copy those files to the mapped site language folder **if those files do not exist or the files have an older timestamp**.

That means that if your module gets an update that also ships with new translations your site's translations will automatically be up to date!

## Way 2: Pushing translations from ProcessWire to modules

We take the same example from above, but now we are the module author of `FooModule` and we want to add a feature to our module that needs some new translations.

We simply add the new translatable strings to our module code:

```php
$feature = __('This is the new feature');
```

Now that translatable string will show up in ProcessWire's translations GUI:

![img](https://i.imgur.com/V5vRF0U.png)

Now we click save and the following will happen (automatically):

1. ProcessWire will create the new json file in `site/assets/files`
1. ProcessWire will load the next page
1. RockLanguage will kick in and detect the changed json file
1. RockLanguage will push the new file to the mapped modules folder `site/modules/FooModule/RockLanguage/DE/*.json` (Note: You need to create the `RockLanguage/DE` folder manually if it does not exist)
1. The changed translation file will show up in your module and you can commit the new translation

![img](https://i.imgur.com/wUwdnnZ.png)

No complicated export of csv files etc 😎

# Limitations/Restrictions/Questions/Ideas

* At the moment this will only work for modules in `/site/modules` though the concept could easily be applied to modules in the wire folder as well - but there we have the concept of language packs wich already works well.
* I'm not sure how to handle this but I've also thought of having a central place for managing translations. Like for example a github repository that holds the translations of several modules in several languages, what do you think?

# Feedback

What do you think of this concept? Will you use the module? Should the concept be part of the core instead? Please let me know in the forum support thread...

