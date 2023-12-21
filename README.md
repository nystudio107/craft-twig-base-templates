# Craft Twig Base Templates

Craft CMS Twig base templates that provide flexible agnostic layout templates for any web-based Craft CMS project.

They provide a base layout with baked-in blocks to structure the various sections of the `<head>` and `<body>` HTML tags.

They also automatically handle both regular web requests and AJAX requests for the same page, returning only the content without the UX chrome for AJAX requests.

These templates are installed automatically via the [Twig Bundle Installer](https://github.com/nystudio107/twig-bundle-installer) so they can be easily updated like any Composer dependency.

## Requirements

These templates Craft CMS 3 or later (fully compatible with Craft CMS 4 & 5).

## Installation

To install the Craft Twig Base Templates, follow these steps:

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require nystudio107/craft-twig-base-templates

The templates will then be installed into the git ignored `vendor/` directory inside of your `templates/` directory.

## Usage

The layouts are intentionally bare-bones, providing a sane structure on which any Craft CMS site can be built. The value provided is largely structural and organizational, at the expense of out of the box functionality.

### Extending the base layout

In your templates, extend one of the layouts such as the as follows:

```twig
{% extends "vendor/nystudio107/craft-twig-base-templates/templates/_layouts/base-html-layout.twig" %}
```

### The base layout blocks

The layout has the following blocks defined that you can override as you see fit:

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                                                                             │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                                                         │ │
│ │                                headMeta                                 │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                                                         │ │
│ │                                headLinks                                │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                                                         │ │
│ │                                 headJs                                  │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                                                         │ │
│ │                                 headCss                                 │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│                                                                             │
│                                 headContent                                 │
└─────────────────────────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────────────────────────┐
│                                                                             │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                                                         │ │
│ │ ┌─────────────────────────────────────────────────────────────────────┐ │ │
│ │ │                                                                     │ │ │
│ │ │                               content                               │ │ │
│ │ └─────────────────────────────────────────────────────────────────────┘ │ │
│ │ ┌─────────────────────────────────────────────────────────────────────┐ │ │
│ │ │                                                                     │ │ │
│ │ │                             subContent                              │ │ │
│ │ └─────────────────────────────────────────────────────────────────────┘ │ │
│ │                                                                         │ │
│ │                                bodyHtml                                 │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                                                         │ │
│ │                                 bodyJs                                  │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│                                                                             │
│                                 bodyContent                                 │
└─────────────────────────────────────────────────────────────────────────────┘
```

As a rule of thumb, override only the most specific block you need to. For instance, to add content to your page in a template that extends the base layout, just override the `content` block:

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
    {% block content %}
        <h1>Some title</h1>
        <p>Some content</p>
    {% endblock content %}
    {% block subContent %}
        <h2>Some heading</h2>
        <p>Some sub-content</p>
    {% endblock subContent %}
    </div>
{% endblock bodyHtml %}
```

### Blocks in multiple templates

If you extend the various blocks in multiple templates, remember that you can use `{{ parent() }}` to render the parent block's content, while also providing your own:

```twig
{% block content %}
    {{ parent() }}
    <h1>Some title</h1>
    <p>Some content</p>
{% endblock content %}
```

### The special `content` block for AJAX

The `content` block is handled specially, in that when the incoming request is a web request, it will render the page normally with all of the UX chrome from the various blocks specified above.

When the incoming request is an AJAX request, instead **only** the `content` block is rendered and returned.

This allows you to easily create full web pages for your content (great for SEO and indexing) while also providing that same content in a modal or other presentation via JavaScript and AJAX requests.

### Advanced customization

In addition to the blocks provided by the base html layout, further customization of the rendered page is available to you by overriding the blocks in the `base-web-layout` (which the `base-html-layout` extends from):

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                                                                             │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                                                         │ │
│ │                                 htmlTag                                 │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                                                         │ │
│ │                                 headTag                                 │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                                                         │ │
│ │                               headContent                               │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                                                         │ │
│ │                                 bodyTag                                 │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │                                                                         │ │
│ │                               bodyContent                               │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│                                                                             │
│                                  htmlPage                                   │
└─────────────────────────────────────────────────────────────────────────────┘
```

So if you need a `<html>`, `<head>` or `<body>` tag with specific attributes on it, you can do that easily:

```twig
{% block htmlTag %}
    <html class="some-feature">
{% endblock htmlTag %}
```

Or you can even completely replace the content wrapped in the `<head>` or `<body>` tags with:

```twig
{% block headContent %}
    {# -- anything you like -- #}
{% endblock headContent %}
```

## Roadmap

Some things to do, and ideas for potential features:

* Add more layouts that extend off of the `base-html-layout.twig` to provide additional opinionated functionality

Brought to you by [nystudio107](http://nystudio107.com)
