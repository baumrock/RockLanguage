# RockLanguage

Teppo is much butter in writing than I am. RockLanguage was announced in his ProcessWire Weekly Newsletter: https://weekly.pw/issue/422/

This week we're happy to introduce a brand new module from Bernhard Baumrock, called RockLanguage. As the name suggests, RockLanguage is a tool for dealing with translations, and more specifically with translations related to ProcessWire modules.

While ProcessWire natively ships with extensive language support, including the ability to ship module translations with the module itself, this does still require some manual work. That is exactly what RockLanguage aims to solve.

Here's what the module translation process looks like with RockLanguage:

## Usage

- Install RockLanguage on your site and (optionally) configure custom language code mapping via the module configuration screen.
- Add a directory for the language you'd like to include translations for within your own module's directory, e.g. /site/modules/MyModule/RockLanguage/FI/ for the Finnish language.
- Translate your module for said language via ProcessWire's translations manager. RockLanguage will automatically notice the update and duplicate the translation file from its original source to the directory you've just created.
- Now if you install this module to another site with the language folder included, and the site has RockLanguage installed and Finnish as one of its languages, the translation files for your module will be automatically synced with ProcessWire.


What's nice about this workflow is that it takes some manual steps out of the equation, thus streamlining translation management. It's too early to say how widely this module will be adopted among public third party modules, but if you like the concept, you can easily start using it for your own modules right away.

## Real World Example

[RockCalendar](https://www.baumrock.com/RockCalendar) ships with german translations. All I had to do to pull them into my module's folder was this:

- Install RockLanguage
- Setup language mapping, in my case the german language had the name "german", so I mapped "german" to "DE": `german=DE`
- Add the language folder to my module: `/site/modules/RockCalendar/RockLanguage/DE/`
- Translate via ProcessWire's language manager
- Done. The translation files are now in my module's folder and synced with ProcessWire.

Whenever I need to update or add a translation, all I have to do is to translate via ProcessWire's language manager, and the file in my module's folder is automatically updated, ready to be committed to GitHub. 🚀😎
