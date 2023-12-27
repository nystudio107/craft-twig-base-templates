# Craft Twig Base Templates

Craft CMS Twig base templates that provide flexible agnostic layout templates for any web-based Craft CMS project.

They provide a base layout with baked-in blocks to structure the various sections of the `<head>` and `<body>` HTML tags.

They also automatically handle both regular web requests and AJAX requests for the same page, returning only the content without the UX chrome for AJAX requests.

These templates are installed automatically via the [Twig Bundle Installer](https://github.com/nystudio107/twig-bundle-installer) so they can be easily updated like any Composer dependency.

## Requirements

These templates Craft CMS 3 or later (fully compatible with Craft CMS 4 & 5).

## Installation

To install the Craft Twig Base Templates, follow these steps:

1. Follow the instructions for installing the [Twig Bundle Installer](https://github.com/nystudio107/twig-bundle-installer?tab=readme-ov-file#adding-twig-bundles-to-your-project) Composer plugin into your project

2. Open your terminal and go to your Craft project:

        cd /path/to/project

3. Then tell Composer to require the Craft Twig Base Templates package:

        composer require nystudio107/craft-twig-base-templates

The templates will then be installed into the git-ignored `vendor/` directory inside of your Twig `templates/` directory.

## Usage

The layouts are intentionally bare-bones, providing a sane structure on which any Craft CMS site can be built. The value provided is largely structural and organizational, at the expense of out of the box functionality.

You can use the `html-page.twig` directly, or you can `extends` it with your own layout template that adds functionality you want available to all of your pages.

### Extending the `html-page.twig` base layout

In your layout or page templates, extend the `html-page.twig` as follows:

```twig
{% extends "vendor/nystudio107/craft-twig-base-templates/templates/_layouts/html-page.twig" %}
```

### The base layout blocks

The layout has the following blocks defined that you can override as you see fit:

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                headMeta                                 │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                headLinks                                │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                               headScripts                               │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                               headStyles                                │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│                                 headContent                                 │
└─────────────────────────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────────────────────────┐
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │ ┌─────────────────────────────────────────────────────────────────────┐ │ │
│ │ │                             preContent                              │ │ │
│ │ └─────────────────────────────────────────────────────────────────────┘ │ │
│ │ ┌─────────────────────────────────────────────────────────────────────┐ │ │
│ │ │                               content                               │ │ │
│ │ └─────────────────────────────────────────────────────────────────────┘ │ │
│ │ ┌─────────────────────────────────────────────────────────────────────┐ │ │
│ │ │                            postContent                              │ │ │
│ │ └─────────────────────────────────────────────────────────────────────┘ │ │
│ │                                bodyHtml                                 │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                               bodyScripts                               │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│                                 bodyContent                                 │
└─────────────────────────────────────────────────────────────────────────────┘
```

Here's a breakdown of the blocks, and intended uses for each:

* **`headContent`** - Wrapper block for everything that appears inside of the `<head>` tag
  * **`headMeta`** - For `<meta>` tags such as `<meta charset="UTF-8">`
  * **`headLinks`** - For `<link>` tags such as `<link rel="stylesheet" href="style.css" />`
  * **`headScripts`** - For `<script>` tags such as `<script type="module" src="app.js"></script>` that should appear inside the `<head>` tag
  * **`headStyles`** - For any inline (critical) CSS `<style></style>` tags
* **`bodyContent`** - Wrapper block for everything that appears inside of the `<body>` tag
  * **`bodyHtml`** - Wrapper block for HTML content that appears inside of the `<body>` tag
    * **`preContent`** - HTML content that appears before the primary `content` block (such as a navbar or a site header)
    * **`content`** - The primary HTML content for the page. This is the only block rendered for AJAX requests
    * **`postContent`** - HTML content that appears after the primary `content` block (such as links or a site footer)
  * **`bodyScripts`** - For `<script>` tags such as `<script tyoe="module" src="app.js"></script>` that should appear before the `</body>` tag

As a rule of thumb, override only the most specific block you need to. For instance, to add content to your page in a template that extends the `html-page` layout, just override the `content` block:

```twig
{% block content %}
    <h1>Some title</h1>
    <p>Some content</p>
{% endblock content %}
```

...rather than overriding the `bodyHtml` block.

However, if you need to provide HTML that wraps your `content` block, you're free to do so as well:

```twig
{% block bodyHtml %}
    <div class="contaniner">
    {% block preContent %}
        <p>Site header</p>
    {% endblock preContent %}
    {% block content %}
        <h1>Content title</h1>
        <p>Some content</p>
    {% endblock content %}
    {% block postContent %}
        <p>Site footer</p>
    {% endblock postContent %}
    </div>
{% endblock bodyHtml %}
```

### Rendering Parent Block Content

You'll notice that even in these very basic base layout templates, some of the blocks have content in them, for example the `headMeta` block:

```twig
    {# -- Any <meta> tags that should be included in the <head> -- #}
    {% block headMeta %}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,minimum-scale=1">
    {% endblock headMeta %}
```

This is provided as a convenience for you, because almost every website will want to have these tags on them.

If you override a block in your own layout or page templates, your content will be displayed instead of the parent block's content.

However, you can use `{{ parent() }}` to render the parent block's content, while also adding your own content to it:

```twig
{% block headMeta %}
    {{ parent() }}
    <meta http-equiv="refresh" content="30">
{% endblock headMeta %}
```

The above will render the content from the `html-page.twig`'s `headMeta` block, and then also output your content as well.

### The special `content` block for AJAX

The `content` block is handled specially, in that when the incoming request is a web request, it will render the page normally with all of the UX chrome from the various blocks specified above.

When the incoming request is an AJAX request, instead **only** the `content` block is rendered and returned.

This allows you to easily create full web pages for your content (great for SEO and indexing) while also providing that same content in a modal or other presentation via JavaScript and AJAX requests.

### Advanced customization

In addition to the blocks provided by the `html-page.twig` layout, further customization of the rendered page is available to you by overriding the blocks in the `web.twig` layout template (which the `html-page.twig` layout extends from):

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                 htmlTag                                 │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                 headTag                                 │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                               headContent                               │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                 bodyTag                                 │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                               bodyContent                               │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│                                  htmlPage                                   │
└─────────────────────────────────────────────────────────────────────────────┘
```

So if you need a `<html>`, `<head>` or `<body>` tag with specific attributes on it, you can do that easily:

```twig
{% block htmlTag %}
    <html class="some-feature">
{% endblock htmlTag %}
```

```twig
{% block headTag %}
    <head class="some-feature">
{% endblock headTag %}
```

```twig
{% block bodyTag %}
    <body class="some-feature">
{% endblock bodyTag %}
```

You can also entirely replace the content wrapped in the `<head>` or `<body>` tags with:

```twig
{% block headContent %}
    {# -- anything you like -- #}
{% endblock headContent %}
```

```twig
{% block bodyContent %}
    {# -- anything you like -- #}
{% endblock bodyContent %}
```

You can even entirely replace everything rendered on the page by overriding `htmlPage` block that encompasses everything the page renders:

```twig
{% block htmlPage %}
    {# -- anything you like -- #}
{% endblock htmlPage %}
```

## Roadmap

Some things to do, and ideas for potential features:

* Add more layouts that extend off of the `html-page.twig` to provide additional opinionated functionality

Brought to you by [nystudio107](http://nystudio107.com)
