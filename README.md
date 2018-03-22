# GremoZurbInkBundle
[![Latest stable](https://img.shields.io/packagist/v/gremo/zurb-ink-bundle.svg?style=flat-square)](https://packagist.org/packages/gremo/zurb-ink-bundle) [![Downloads total](https://img.shields.io/packagist/dt/gremo/zurb-ink-bundle.svg?style=flat-square)](https://packagist.org/packages/gremo/zurb-ink-bundle) [![GitHub issues](https://img.shields.io/github/issues/gremo/ZurbInkBundle.svg?style=flat-square)](https://github.com/gremo/ZurbInkBundle/issues)

Creating email templates is hard. This Symfony Bundle provides help.

*The original bundle [thampe/ZurbInkBundle](https://github.com/thampe/ZurbInkBundle) is abandoned. This fork aims to provide a maintained version of the original project. I use this bundle at work, on daily basis, and I respect semantic versioning.*

Do you have a good idea and want to **contribute**? Let's do it! Feel free to open an issue.

## Upgrade

- Latest tag of the original project is [2.2.6](https://github.com/gremo/ZurbInkBundle/blob/2.2.6/README.md). You can use this release only changing your Composer requirements.
- Latest `2.x` tag of my fork is [2.3.0](https://github.com/gremo/ZurbInkBundle/blob/v2.3.0/README.md) and contains some bug fixes. You can use this release changing your Composer requirements and bundle name in the kernel.

## Installation
Install the bundle via Composer:

```bash
composer require gremo/zurb-ink-bundle
```

Then enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Gremo\ZurbInkBundle\GremoZurbInkBundle(),
        // ...
    );
}
```

## Usage

First we need to create a template for our HTML email. You can use [Foundation for Emails](https://foundation.zurb.com/emails/email-templates.html) and [Inky](https://foundation.zurb.com/emails/docs/inky.html) or write it from scratch.

### Working with Foundation for Emails and Inky

[Foundation for Emails](https://foundation.zurb.com/emails/email-templates.html) is a framework for building HTML responsive emails while [Inky](https://foundation.zurb.com/emails/docs/inky.html) is a templating language that converts simple HTML tags into the complex table HTML required for emails.

Extend the base Foundation for Emails layout and override the `content` block:

```twig
{% extends '@GremoZurbInk/foundation-emails/base.html.twig' %}

{% block content %}
    {# Inky markup and plain HTML #}
{% endblock %}
```

The base layout includes Foundation for Emails CSS (inlined only). Custom styles can be added overriding the `stylesheets` block (see [Adding styles](#adding-styles)).

### From scratch

Not using Foundation for Emails or Inky markup? Extend the base layout and override the `body` block:

```twig
{% extends '@GremoZurbInk/base.html.twig' %}

{% block body %}
    {# Plain HTML #}
{% endblock %}
```
Custom styles can be added overriding the `stylesheets` block (see [Adding styles](#adding-styles)).

### Adding styles

Email clients typically support only a subset of valid HTML, and don’t have strong support for CSS (especially CSS in the `<head>` of the HTML email). Yahoo, Outlook, and even Gmail strip CSS that’s included in the `<head>` of your HTML, so in most cases **CSS inlining is necessary**.

Stylesheets can be added calling the `zurb_ink_add_stylesheet` Twig function inside the `stylesheets` block:

```twig
{# ... #}

{% block stylesheets %}
	{{ parent() }}

    {# Custom CSS (inlined only) #}
	{{ zurb_ink_add_stylesheet('css/style.css') }}
{% endblock %}

{# ... #}
```

By default this will **only inline the CSS**. Pass a truthy value as second argument to **both inline and output the CSS** into the `<style>` tag:

```twig
{% block stylesheets %}
	{{ parent() }}

    <style type="text/css">
        {# Custom CSS (both inlined and outputted) #}
        {{ zurb_ink_add_stylesheet('@AppBundle/Resources/public/css/style.css', true) }}
    </style>
{% endblock %}
```

## Future plans

- [ ] Use interfaces and adapters for services
- [ ] Change implementation using bundle configuration
- [ ] Add tests
