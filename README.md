# Embed Github

> Simply embed Github Readme or any other markdown file to page or post

## Getting started

Download the [latest zip](https://github.com/johnie/embedgithub/archive/master.zip) and upload it via the plugins page in WordPress or unzip it in the `plugins` directory.

You can also install it via `composer require johnie/embedgithub`

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
