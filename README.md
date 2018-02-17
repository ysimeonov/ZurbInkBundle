# GremoZurbInkBundle
[![Latest stable](https://img.shields.io/packagist/v/gremo/zurb-ink-bundle.svg?style=flat-square)](https://packagist.org/packages/gremo/zurb-ink-bundle) [![Downloads total](https://img.shields.io/packagist/dt/gremo/zurb-ink-bundle.svg?style=flat-square)](https://packagist.org/packages/gremo/zurb-ink-bundle) [![GitHub issues](https://img.shields.io/github/issues/gremo/ZurbInkBundle.svg?style=flat-square)](https://github.com/gremo/ZurbInkBundle/issues)

Creating email templates is hard. This Symfony Bundle provides help.

The original bundle [thampe/ZurbInkBundle](https://github.com/thampe/ZurbInkBundle) is abandoned. This fork is under development and aims to provide maintained version of the original project.

**Important**: this README will be in sync with master branch. Examples **may not reflect** the actual usage of this bundle.

Latest tag compatible with with the original bundle is [v2.3.1](https://github.com/gremo/ZurbInkBundle/blob/v2.3.1/README.md).

## Installation
Install the bundle via composer:

```
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

Email clients typically support only a subset of valid HTML, and don’t have strong support for CSS (especially CSS in the `<head>` of the HTML email). Yahoo, Outlook, and even Gmail strip CSS that’s included in the `<head>` of your HTML, so in most cases **CSS inlining is necessary**.

[Foundation for Emails](https://foundation.zurb.com/emails/email-templates.html) is a framework for building HTML responsive emails. Extend the base layout and override the `body` or `content` block:

```
{% extends 'GremoZurbInkBundle:FoundationForEmails:2/base.html.twig' %}

{% block content %}
    {# your custom HTML or Inky language #}
{% endblock %}
```

CSS added using `zurb_ink_styles.add` will be inlined. You can add custom CSS overriding the `preHtml` block:

```
{# ... #}

{% block preHtml %}
    {# your custom CSS #}
    {{ zurb_ink_styles.add("css/style1.css") }}
    {{ zurb_ink_styles.add("@AppBundle/Resources/public/css/style2.css") }}
{% endblock %}
```

If you prefer **not to have the CSS style also** in the `<head>` of your HTML document (that is, rely only on inlining) add the following block:

```
{# ... #}

{% block headStyles %}{% endblock %}
```
