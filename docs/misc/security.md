# Security

The output from object templates or twig templates can potentially contain harmful content, so it is
run through a [purify](https://craftcms.com/docs/4.x/dev/filters.html#purify) filter. Set the `purifierConfig` plugin config if you do not want to use the default purifier config.

You can hide objects like actions via permission/group/events etc., however this is just 'visual' and does not protect your app from being hacked. Be sure to implement security measures in your backend.  
