# GremoZurbInkBundle
[![Latest stable](https://img.shields.io/packagist/v/gremo/zurb-ink-bundle.svg?style=flat-square)](https://packagist.org/packages/gremo/zurb-ink-bundle) [![Downloads total](https://img.shields.io/packagist/dt/gremo/zurb-ink-bundle.svg?style=flat-square)](https://packagist.org/packages/gremo/zurb-ink-bundle) [![GitHub issues](https://img.shields.io/github/issues/gremo/ZurbInkBundle.svg?style=flat-square)](https://github.com/gremo/ZurbInkBundle/issues)

*The original bundle [thampe/ZurbInkBundle](https://github.com/thampe/ZurbInkBundle) is abandoned. This fork aims to provide a maintained version of the original project. I use this bundle at work, on daily basis, and I respect semantic versioning.*

Creating email templates is hard. This Symfony Bundle provides help.

Do you have a good idea and want to **contribute**? Let's do it! Feel free to open an issue.

## Upgrade to 3.x

You can use this bundle without changing your code up to the [v2.3.0](https://github.com/gremo/ZurbInkBundle/blob/v2.3.0/README.md) tag.

Breaking changes in `3.x`:

- Template `FoundationForEmails/base.html.twig` is renamed into `base.html.twig`
- Template `FoundationForEmails/2/base.html.twig` is renamed into `foundation-emails/base.html.twig`
- Template `base.html.twig` doesn't include the `inky.css` anymore
- Twig block `preHtml` has been removed
- Twig block `headStyles` has been renamed to `stylesheets`
- Twig block `additionalStyles` has been renamed to `additional_stylesheets` and it's not inside the `<style>` tag anymore
- Twig block `body` isn't inside the `inky` tag anymore (use `content` block instead)
- Twig globals `zurb_ink_inlinecss`, `zurb_ink_locator` and `zurb_ink_styles` has been removed in favour of function `zurb_ink_add_stylesheet`

## Installation
Install the bundle via composer:

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

Email clients typically support only a subset of valid HTML, and don’t have strong support for CSS (especially CSS in the `<head>` of the HTML email). Yahoo, Outlook, and even Gmail strip CSS that’s included in the `<head>` of your HTML, so in most cases **CSS inlining is necessary**.

[Foundation for Emails](https://foundation.zurb.com/emails/email-templates.html) is a framework for building HTML responsive emails. Extend the base layout and override the `content` block:

```twig
{% extends '@GremoZurbInk/foundation-emails/base.html.twig' %}

{% block content %}
    {# HTML or Inky language #}
{% endblock %}
```

**Custom styles** can be added overriding the `additional_stylesheets` block and calling the `zurb_ink_add_stylesheet` function. By default this function will **only inline the CSS**:

```twig
{# ... #}

{% block additional_stylesheets %}
    {# Custom style (inlined only) #}
    {{ zurb_ink_add_stylesheet('@AppBundle/Resources/public/css/style.css') }}
{% endblock %}
```

Pass a truthy value as second argument in order to also **output the stylesheet** into the `<style>` tag:

```twig
{# ... #}

{% block additional_stylesheets %}
    <style type="text/css">
        {# Custom style (both inlined and outputted) #}
        {{ zurb_ink_add_stylesheet('css/style.css', true) }}
    </style>
{% endblock %}
```

By default the Foundation for Emails CSS will be only inlined. In order to change this behaviour, override the entire `stylesheets` block.

## Future plans

- [ ] Use interfaces and adapters for services
- [ ] Change implementation using bundle configuration
- [ ] Add tests
