# Embed GitHub

> Simply embed GitHub Readme or any other markdown file to page or post

## Getting started

This should be installed with Composer since it has dependencies:

```
$ composer require johnie/embedgithub
```

### Usage

**Shortcode**

Simply get the repo readme file

`[embedgithub repo="johnie/embedgithub"]`

You can also trim lines from the top of the readme using the **trim** option:

`[embedgithub repo="johnie/embedgithub" trim="3"]`

This is useful for removing titles since your page/post will most likely already have one.

You can also specify a markdown file using the **file** option, e.g. "changelog.md"

`[embedgithub repo="johnie/embedgithub" file="changelog.md"]`

## Licence

MIT © [Johnie Hjelm](http://johnie.se)
