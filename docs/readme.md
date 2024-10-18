# RockLanguage

RockLanguage is a module that allows you to manage language translations in a more efficient way.

ProcessWire's native language management is very powerful, but it can be a bit cumbersome to manage translations, especially to ship your module with translations.

## Usage

- Setup language mappings (eg `german=DE`)
- Create a folder for every language that your module supports, eg `site/modules/MyModule/RockLanguage/DE`
- Enjoy! 🚀

## WHY I built this module

Imagine you are a module developer and you want to ship your module with german translations, as your native language is german and most of your customers speak german as well. What would you have to do using ProcessWire's native language management?

- Translate your module via ProcessWire's translation interface.
- Export translation files, which can be [quite complicated](https://processwire.com/blog/posts/pw-3.0.181-hello/) (and now imagine what you would have done if you didn't know where to find that information!)
- Find all the files that contain translations
- Copy them over to your module. Which folder? I don't know, you'd have to look that up and make sure it works. It's not fun...
- Write docs for your users on how to install those translations

This is by far too much work for me!

You don't agree? Ok, you are right, that's not too bad. You only have to do this once, right?

No! You have to do this every single time you changed a translation!

You still don't agree? Ok, thanks for reading this far. This module is not for you. Please go ahead and check out one of my other modules 😉
